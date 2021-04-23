<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/atom.serializer/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/atom.serializer/blob/master/README.md
 */

namespace MockingMagician\Atom\Serializer\Standardize\Natural;

use Exception;
use MockingMagician\Atom\Serializer\Standardize\CertifiedStandardizerInterface;
use MockingMagician\Atom\Serializer\Standardize\GlobalStandardizerDependant;
use MockingMagician\Atom\Serializer\Standardize\GlobalStandardizerInterface;

class ObjectStandardizer implements CertifiedStandardizerInterface, GlobalStandardizerDependant
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
     */
    public function standardize($valueToStandardize)
    {
        $toReturn = [];
        // Get the public properties
        $properties = \get_object_vars($valueToStandardize);
        foreach ($properties as $property => $value) {
            $toReturn[$property] = $this->globalStandardizer->standardize($value);
        }
        // Get the properties based on methods
        $methods = \get_class_methods($valueToStandardize);
        // Filter public internal methods
        $methods = \array_filter($methods, function ($val) {
            if (\preg_match('#^__#', $val)) {
                return false;
            }

            return true;
        });
        foreach ($methods as $method) {
            try {
                $valueFromMethod = $valueToStandardize->{$method}();
            } catch (Exception $exception) {
                continue;
            }
            $toReturn[$method] = $this->globalStandardizer->standardize($valueFromMethod);
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
