<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/atom.serializer/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/atom.serializer/blob/master/README.md
 */

namespace MockingMagician\Atom\Serializer\Standardizer;

interface ObjectStandardizerInterface
{
    /**
     * Standardize the input object and return an array.
     *
     * @param array|object|\Traversable $value
     *
     * @return array
     */
    public function standardize($value): array;
}
