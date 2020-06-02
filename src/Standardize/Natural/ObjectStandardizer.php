<?php


namespace MockingMagician\Atom\Serializer\Standardize\Natural;

use MockingMagician\Atom\Serializer\Exceptions\StandardizeException;
use MockingMagician\Atom\Serializer\Standardize\AbstractCertifiedStandardizer;
use MockingMagician\Atom\Serializer\Standardize\GlobalStandardizerDependant;
use MockingMagician\Atom\Serializer\Standardize\GlobalStandardizerInterface;

class ObjectStandardizer extends AbstractCertifiedStandardizer implements GlobalStandardizerDependant
{
    /**
     * @var GlobalStandardizerInterface|null
     */
    private $globalStandardizer;

    public function __construct(GlobalStandardizerInterface $globalStandardizer)
    {
        $this->globalStandardizer = $globalStandardizer;
    }

    /**
     * @inheritDoc
     */
    public function canStandardize($valueToStandardize)
    {
        return is_object($valueToStandardize);
    }

    /**
     * @inheritDoc
     * @throws StandardizeException
     */
    public function standardize($valueToStandardize)
    {
        parent::standardize($valueToStandardize);

        $toReturn = [];
        // Get the public properties
        $properties = get_object_vars($valueToStandardize);
        foreach ($properties as $property => $value) {
            $toReturn[$property] = $this->globalStandardizer->standardize($value);
        }
        // Get the properties based on methods
        $methods = get_class_methods($valueToStandardize);
        foreach ($methods as $method) {
            $toReturn[$method] = $this->globalStandardizer->standardize($valueToStandardize->{$method}());
        }

        return $toReturn;
    }

    /**
     * @inheritDoc
     */
    public function getGlobalStandardizer()
    {
        return $this->globalStandardizer;
    }
}
