<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/atom.serializer/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/atom.serializer/blob/master/README.md
 */

namespace MockingMagician\Atom\Serializer\Standardize;

interface StandardizerInterface
{
    /**
     * @param mixed $valueToStandardize
     *
     * @return mixed the standardized value
     */
    public function standardize($valueToStandardize);
}
