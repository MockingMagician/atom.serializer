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
    private $deep = 0;

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
        $this->registry = new ObjectRegistry();
        $this->options = $options;
    }

    /**
     * @param $valueToStandardize
     *
     * @throws StandardizeException
     *
     * @return mixed
     */
    public function standardize($valueToStandardize)
    {
        if ($this->goDeeper() > $this->getOptions()->getMaxDepth()) {
            $this->goHigher();
            if ($this->getOptions()->isExceptionOnMaxDepth()) {
                throw StandardizeException::MaxDepth($this->getOptions()->getMaxDepth());
            }

            return null;
        }
        $this->goHigher();

        if (\is_object($valueToStandardize)) {
            $options = $this->getOptions();

            $this->registry = $this->getRegistry();
            $this->registry->register($valueToStandardize);

            if ($this->registry->countRegisterTime($valueToStandardize) > $options->getMaxCircularReference()) {
                foreach ($options->getCircularReferenceHandlers() as $circularReferenceHandler) {
                    if ($circularReferenceHandler->canHandle($circularReferenceHandler)) {
                        return $circularReferenceHandler->handle($valueToStandardize);
                    }
                }

                throw StandardizeException::CircularReference();
            }
        }

        $exception = null;
        $standardizeSuccess = false;
        $this->goDeeper();
        foreach ($this->getStandardizers() as $standardizer) {
            try {
                $standardizedValue = $standardizer->standardize($valueToStandardize);
                $standardizeSuccess = true;

                break;
            } catch (StandardizeException $exception) {
            }
        }
        $this->goHigher();

        if ($standardizeSuccess) {
            /** @var mixed $standardizedValue */
            return $standardizedValue;
        }

        throw StandardizeException::CanNotStandardize($valueToStandardize, $this, 0, $exception);
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
    public function getDeep()
    {
        return $this->deep;
    }

    /**
     * {@inheritdoc}
     */
    public function goDeeper()
    {
        return ++$this->deep;
    }

    /**
     * {@inheritdoc}
     */
    public function goHigher()
    {
        return --$this->deep;
    }
}
