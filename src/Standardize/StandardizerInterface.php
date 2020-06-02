<?php


namespace MockingMagician\Atom\Serializer\Standardize;


interface StandardizerInterface
{
    /**
     * @param mixed $valueToStandardize
     * @return mixed the standardized value
     */
    public function standardize($valueToStandardize);
}
