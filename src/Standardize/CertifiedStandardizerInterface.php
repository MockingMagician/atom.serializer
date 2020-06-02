<?php


namespace MockingMagician\Atom\Serializer\Standardize;


interface CertifiedStandardizerInterface extends StandardizerInterface
{
    /**
     * @param $valueToStandardize
     * @return bool return true is the value can be standardized, false otherwise
     */
    public function canStandardize($valueToStandardize);
}
