<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/atom.serializer/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/atom.serializer/blob/master/README.md
 */

namespace MockingMagician\Atom\Serializer\Standardize\Natural;

use MockingMagician\Atom\Serializer\Exceptions\StandardizeException;
use MockingMagician\Atom\Serializer\Standardize\AbstractCertifiedStandardizer;

class ScalarStandardizer extends AbstractCertifiedStandardizer
{
    /**
     * {@inheritdoc}
     */
    public function canStandardize($valueToStandardize)
    {
        return \is_scalar($valueToStandardize);
    }

    /**
     * @param $valueToStandardize
     *
     * @throws StandardizeException
     *
     * @return bool|float|int|string
     */
    public function standardize($valueToStandardize)
    {
        parent::standardize($valueToStandardize);

        return $valueToStandardize;
    }
}
