<?php


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
     * @param array $standardizers class implemented at least CertifiedStandardizerInterface
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
     * @return mixed
     * @throws StandardizeException
     */
    public function standardize($valueToStandardize)
    {
        $exception = null;

        if ($this->goDeeper() > $this->getOptions()->getMaxDepth()) {
            $this->goHigher();
            if ($this->getOptions()->isExceptionOnMaxDepth()) {
                throw StandardizeException::MaxDepth($this->getOptions()->getMaxDepth());
            } else {
                return null;
            }
        }

        if (is_object($valueToStandardize)) {
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

        $this->goDeeper();
        foreach ($this->getStandardizers() as $standardizer) {
            try {
                return $standardizer->standardize($valueToStandardize);
            } catch (StandardizeException $exception) {
                dump(get_class($standardizer));
            }
        }
        $this->goHigher();

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
     * @inheritDoc
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @inheritDoc
     */
    public function getDeep()
    {
        return $this->deep;
    }

    /**
     * @inheritDoc
     */
    public function goDeeper()
    {
        return ++$this->deep;
    }

    /**
     * @inheritDoc
     */
    public function goHigher()
    {
        return --$this->deep;
    }
}
