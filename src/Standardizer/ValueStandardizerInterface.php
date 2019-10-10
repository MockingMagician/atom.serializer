<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/atom.serializer/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/atom.serializer/blob/master/README.md
 */

namespace MockingMagician\Atom\Serializer\Standardizer;

interface ValueStandardizerInterface
{
    /**
     * Standardize the input value and can return scalars type list:
     * - bool
     * - integer
     * - float
     * - string
     * - array.
     *
     * @param $value
     *
     * @return array|bool|float|int|string
     */
    public function standardize($value);
}
