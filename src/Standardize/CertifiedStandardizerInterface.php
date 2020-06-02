<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/atom.serializer/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/atom.serializer/blob/master/README.md
 */

namespace MockingMagician\Atom\Serializer\Standardize;

interface CertifiedStandardizerInterface extends StandardizerInterface
{
    /**
     * @param $valueToStandardize
     *
     * @return bool return true is the value can be standardized, false otherwise
     */
    public function canStandardize($valueToStandardize);
}
