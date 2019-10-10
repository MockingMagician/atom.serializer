<?php

namespace MockingMagician\Atom\Serializer\Standardizer;


use MockingMagician\Atom\Serializer\Register\ObjectRegister;

class Standardizer implements ValueStandardizerInterface
{
    private $config;

    public function __construct(StandardizerConfig $config)
    {
        if (is_null($config)) {
            $config = new StandardizerConfig();
        }

        $this->config = $config;
    }

    /**
     * Standardize the input value and can return scalars type list:
     * - bool
     * - integer
     * - float
     * - string
     * - array
     *
     * @param $value
     * @return bool|int|float|string|array
     * @throws \Exception
     */
    public function standardize($value)
    {
        $vs = new ValueStandardizer(new ObjectRegister(), $this->config);

        return $vs->standardize($value);
    }
}
