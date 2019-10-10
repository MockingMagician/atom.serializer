<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/atom.serializer/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/atom.serializer/blob/master/README.md
 */

namespace MockingMagician\Atom\Serializer\Standardizer;

use MockingMagician\Atom\Serializer\Exception\StandardizeValueImplementationException;
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
     * Standardize the input value and can return value in scalars type list:
     * - bool
     * - integer
     * - float
     * - string
     * - array
     * - null.
     *
     * @param mixed $value
     *
     * @throws StandardizeValueImplementationException
     * @throws \Exception
     * @throws \Throwable
     *
     * @return array|bool|float|int|string|null
     */
    public function standardize($value)
    {
        if (\is_object($value) || \is_iterable($value)) {
            $os = new ObjectStandardizer($this->register, $this->config);

            return $os->standardize($value);
        }

        if (\is_bool($value)
            || \is_int($value)
            || \is_float($value)
            || \is_string($value)
            || \is_null($value)
        ) {
            return $value;
        }

        throw new StandardizeValueImplementationException($value);
    }
}
