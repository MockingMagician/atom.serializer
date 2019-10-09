<?php

namespace MockingMagician\Atom\Serializer\Standardizer;


use MockingMagician\Atom\Serializer\Register\ObjectRegister;

class ValueStandardizer implements ValueStandardizerInterface
{
    private $register;
    private $config;

    public function __construct(ObjectRegister $register, StandardizerConfig $config)
    {
        $this->register = $register;
        $this->config = $config;
    }

    /**
     * Standardize the input value and can return scalars type list:
     * - bool
     * - integer
     * - float
     * - string
     * - array
     * - null
     *
     * @param $value
     * @return bool|int|float|string|array
     * @throws \Exception
     */
    public function standardize($value)
    {
        if (is_object($value) || is_iterable($value)) {
            $os = new ObjectStandardizer($this->register, $this->config);

            return $os->standardize($value);
        }

        if (is_bool($value)
            || is_int($value)
            || is_float($value)
            || is_string($value)
            || is_null($value)
        ) {
            return $value;
        }

        throw new \Exception();
    }
}
