<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/atom.serializer/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/atom.serializer/blob/master/README.md
 */

namespace MockingMagician\Atom\Serializer\Standardize;

use MockingMagician\Atom\Serializer\Exceptions\StandardizeException;

abstract class AbstractCertifiedStandardizer implements CertifiedStandardizerInterface
{
    /**
     * @param $valueToStandardize
     *
     * @throws StandardizeException
     *
     * @return mixed|void
     */
    public function standardize($valueToStandardize)
    {
        if (!$this->canStandardize($valueToStandardize)) {
            throw StandardizeException::CanNotStandardize($valueToStandardize, $this);
        }
    }
}
