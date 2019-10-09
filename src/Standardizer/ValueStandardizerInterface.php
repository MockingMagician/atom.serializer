<?php

namespace MockingMagician\Atom\Serializer\Standardizer;


interface ValueStandardizerInterface
{
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
     */
    public function standardize($value);
}
