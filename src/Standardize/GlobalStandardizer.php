<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/atom.serializer/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/atom.serializer/blob/master/README.md
 */

namespace MockingMagician\Atom\Serializer\Standardize;

use Exception;
use MockingMagician\Atom\Serializer\Exceptions\ExceptionFactory;
use MockingMagician\Atom\Serializer\Exceptions\StandardizeException;
use MockingMagician\Atom\Serializer\Path\PathsNode;
use MockingMagician\Atom\Serializer\Registry\ObjectRegistry;
use MockingMagician\Atom\Serializer\Registry\RegistryInterface;
use MockingMagician\Atom\Serializer\Standardize\Options\CircularReferenceHandlerInterface;
use MockingMagician\Atom\Serializer\Standardize\Options\StandardizeOptionsInterface;

class GlobalStandardizer implements StandardizerInterface, GlobalStandardizerInterface
{
    /**
     * @var CertifiedStandardizerInterface[]
     */
    private $standardizers;

    /**
     * @var RegistryInterface
     */
    private $registry;

    /**
     * @var StandardizeOptionsInterface
     */
    private $options;

    /**
     * @var int
     */
    private $depth = 0;

    /**
     * @var PathsNode
     */
    private $pathsNodeObjectRegistry;

    /**
     * GlobalStandardizer constructor.
     *
     * @param array                       $standardizers class implemented at least CertifiedStandardizerInterface
     * @param StandardizeOptionsInterface $options
     */
    public function __construct($standardizers, $options)
    {
        $this->standardizers = [];
        foreach ($standardizers as $standardizer) {
            if (!\is_subclass_of($standardizer, CertifiedStandardizerInterface::class)) {
                continue;
            }
            if (\is_subclass_of($standardizer, GlobalStandardizerDependant::class)) {
                $this->standardizers[] = new $standardizer($this);

                continue;
            }
            $this->standardizers[] = new $standardizer();
        }
        $this->pathsNodeObjectRegistry = new PathsNode();
        $this->registry = new ObjectRegistry();
        $this->options = $options;
    }

    /**
     * @param $valueToStandardize
     *
     * @throws Exception
     *
     * @return mixed
     */
    public function standardize($valueToStandardize)
    {
        try {
            $standardized = $this->internalStandardize($valueToStandardize);
            $this->dealWithResetRegistry();

            return $standardized;
        } catch (Exception $exception) {
            $this->registry = new ObjectRegistry();

            throw $exception;
        }
    }

    /**
     * @param $valueToStandardize
     *
     * @throws Exception
     * @throws StandardizeException
     *
     * @return null|array|mixed
     */
    public function internalStandardize($valueToStandardize)
    {
        if (\is_scalar($valueToStandardize) || null === $valueToStandardize) {
            return $valueToStandardize;
        }

        $this->goDeeper();
        if (!$this->dealWithDepth()) {
            $this->goHigher();

            return null;
        }

        if (\is_iterable($valueToStandardize)) {
            $toReturn = [];
            foreach ($valueToStandardize as $k => $value) {
                $toReturn[$k] = $this->standardize($value);
            }
            $this->goHigher();

            return $toReturn;
        }

        if ($handler = $this->dealWithCircular($valueToStandardize)) {
            return $handler->handle($valueToStandardize);
        }

        $standardizer = $this->getStandardizer($valueToStandardize);
        $standardizedValue = $standardizer->standardize($valueToStandardize);
        $this->goHigher();

        return $standardizedValue;
    }

    /**
     * @return CertifiedStandardizerInterface[]
     */
    public function getStandardizers(): array
    {
        return $this->standardizers;
    }

    /**
     * @return ObjectRegistry|RegistryInterface
     */
    public function getRegistry()
    {
        return $this->registry;
    }

    /**
     * {@inheritdoc}
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * {@inheritdoc}
     */
    public function getDepth()
    {
        return $this->depth;
    }

    /**
     * {@inheritdoc}
     */
    public function goDeeper()
    {
        return ++$this->depth;
    }

    /**
     * {@inheritdoc}
     */
    public function goHigher()
    {
        return --$this->depth;
    }

    /**
     * @throws StandardizeException
     *
     * @return bool
     */
    private function dealWithDepth()
    {
        if ($this->getDepth() > $this->getOptions()->getMaxDepth()) {
            if ($this->getOptions()->isExceptionOnMaxDepth()) {
                throw ExceptionFactory::maxDepthReached($this->getOptions()->getMaxDepth());
            }

            return false;
        }

        return true;
    }

    /**
     * @param mixed $valueToStandardize
     *
     * @throws StandardizeException
     *
     * @return bool|CircularReferenceHandlerInterface
     */
    private function dealWithCircular($valueToStandardize)
    {
        $options = $this->getOptions();
        $this->getRegistry()->register($valueToStandardize);

        if ($this->getRegistry()->countRegisterTime($valueToStandardize) > $options->getMaxCircularReference()) {
            foreach ($options->getCircularReferenceHandlers() as $circularReferenceHandler) {
                if ($circularReferenceHandler->canHandle($circularReferenceHandler)) {
                    return $circularReferenceHandler;
                }
            }

            throw ExceptionFactory::circularReferenceNotHandled(
                $valueToStandardize,
                $options->getMaxCircularReference()
            );
        }

        return false;
    }

    /**
     * @param $valueToStandardize
     *
     * @throws StandardizeException
     *
     * @return CertifiedStandardizerInterface
     */
    private function getStandardizer($valueToStandardize)
    {
        foreach ($this->getStandardizers() as $standardizer) {
            if ($standardizer->canStandardize($valueToStandardize)) {
                return $standardizer;
            }
        }

        throw ExceptionFactory::standardizerNotFound($valueToStandardize);
    }

    private function dealWithResetRegistry()
    {
        if (0 === $this->getDepth()) {
            // reset registry, cause standardize it's on his end
            $this->registry = new ObjectRegistry();
        }
    }
}
