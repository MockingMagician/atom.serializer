<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/atom.serializer/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/atom.serializer/blob/master/README.md
 */

namespace MockingMagician\Atom\Serializer\Standardize;

use MockingMagician\Atom\Serializer\Exceptions\StandardizeException;
use MockingMagician\Atom\Serializer\Registry\ObjectRegistry;
use MockingMagician\Atom\Serializer\Registry\RegistryInterface;
use MockingMagician\Atom\Serializer\Standardize\Options\CircularReferenceHandlerInterface;
use MockingMagician\Atom\Serializer\Standardize\Options\StandardizeOptionsInterface;
use Throwable;
use function is_subclass_of;

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
     * GlobalStandardizer constructor.
     *
     * @param array                       $standardizers class implemented at least CertifiedStandardizerInterface
     * @param StandardizeOptionsInterface $options
     */
    public function __construct($standardizers, $options)
    {
        $this->standardizers = [];
        foreach ($standardizers as $standardizer) {
            if (!is_subclass_of($standardizer, CertifiedStandardizerInterface::class)) {
                continue;
            }
            if (is_subclass_of($standardizer, GlobalStandardizerDependant::class)) {
                $this->standardizers[] = new $standardizer($this);

                continue;
            }
            $this->standardizers[] = new $standardizer();
        }
        $this->registry = new ObjectRegistry();
        $this->options = $options;
    }

    /**
     * @param $valueToStandardize
     *
     * @return mixed
     * @throws Throwable
     */
    public function standardize($valueToStandardize)
    {
        try {
            $standardized = $this->internalStandardize($valueToStandardize);
            $this->dealWithResetRegistry();

            return $standardized;
        } catch (Throwable $exception) {
            $this->registry = new ObjectRegistry();
            throw $exception;
        }
    }

    /**
     * @param $valueToStandardize
     * @return array|mixed|null
     * @throws StandardizeException
     * @throws Throwable
     */
    public function internalStandardize($valueToStandardize)
    {
        if (is_scalar($valueToStandardize) || null === $valueToStandardize) {
            return $valueToStandardize;
        }

        $this->goDeeper();
        if (!$this->dealWithDepth()) {
            $this->goHigher();
            return null;
        }

        if (is_iterable($valueToStandardize)) {
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
     * @return bool
     * @throws StandardizeException
     */
    private function dealWithDepth()
    {
        if ($this->getDepth() > $this->getOptions()->getMaxDepth()) {
            if ($this->getOptions()->isExceptionOnMaxDepth()) {
                throw StandardizeException::MaxDepth($this->getOptions()->getMaxDepth());
            }

            return false;
        }

        return true;
    }

    /**
     * @param mixed $valueToStandardize
     * @return bool|CircularReferenceHandlerInterface
     * @throws StandardizeException
     */
    private function dealWithCircular($valueToStandardize)
    {
        $options = $this->getOptions();
        $this->registry = $this->getRegistry();
        $this->registry->register($valueToStandardize);

        if ($this->registry->countRegisterTime($valueToStandardize) > $options->getMaxCircularReference()) {
            dump($this->registry);
            foreach ($options->getCircularReferenceHandlers() as $circularReferenceHandler) {
                if ($circularReferenceHandler->canHandle($circularReferenceHandler)) {
                    return $circularReferenceHandler;
                }
            }

            throw StandardizeException::CircularReference();
        }

        return false;
    }

    /**
     * @param $valueToStandardize
     * @return CertifiedStandardizerInterface
     * @throws StandardizeException
     */
    private function getStandardizer($valueToStandardize)
    {
        foreach ($this->getStandardizers() as $standardizer) {
            if ($standardizer->canStandardize($valueToStandardize)) {
                return $standardizer;
            }
        }

        throw StandardizeException::CanNotStandardize($valueToStandardize, $this);
    }

    private function dealWithResetRegistry()
    {
        if ($this->getDepth() === 0) {
            // reset registry, cause standardize it's on his end
            $this->registry = new ObjectRegistry();
        }
    }
}
