<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/atom.serializer/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/atom.serializer/blob/master/README.md
 */

namespace MockingMagician\Atom\Serializer\Standardize\Natural;

use MockingMagician\Atom\Serializer\Exceptions\StandardizeException;
use MockingMagician\Atom\Serializer\Standardize\AbstractCertifiedStandardizer;
use MockingMagician\Atom\Serializer\Standardize\GlobalStandardizerDependant;
use MockingMagician\Atom\Serializer\Standardize\GlobalStandardizerInterface;

class ObjectStandardizer extends AbstractCertifiedStandardizer implements GlobalStandardizerDependant
{
    /**
     * @var GlobalStandardizerInterface
     */
    private $globalStandardizer;

    public function __construct(GlobalStandardizerInterface $globalStandardizer)
    {
        $this->globalStandardizer = $globalStandardizer;
    }

    /**
     * {@inheritdoc}
     */
    public function canStandardize($valueToStandardize)
    {
        return \is_object($valueToStandardize);
    }

    /**
     * {@inheritdoc}
     *
     * @throws StandardizeException
     */
    public function standardize($valueToStandardize)
    {
        parent::standardize($valueToStandardize);

        $toReturn = [];
        // Get the public properties
        $properties = \get_object_vars($valueToStandardize);
        foreach ($properties as $property => $value) {
            $toReturn[$property] = $this->globalStandardizer->standardize($value);
        }
        // Get the properties based on methods
        $methods = \get_class_methods($valueToStandardize);
        foreach ($methods as $method) {
            $toReturn[$method] = $this->globalStandardizer->standardize($valueToStandardize->{$method}());
        }

        return $toReturn;
    }

    /**
     * {@inheritdoc}
     */
    public function getGlobalStandardizer()
    {
        return $this->globalStandardizer;
    }
}
