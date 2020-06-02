<?php


namespace MockingMagician\Atom\Serializer\Standardize;


use MockingMagician\Atom\Serializer\Exceptions\StandardizeException;

abstract class AbstractCertifiedStandardizer implements CertifiedStandardizerInterface
{
    /**
     * @param $valueToStandardize
     * @return mixed|void
     * @throws StandardizeException
     */
    public function standardize($valueToStandardize)
    {
        if (!$this->canStandardize($valueToStandardize)) {
            throw StandardizeException::CanNotStandardize($valueToStandardize, $this);
        }
    }
}
