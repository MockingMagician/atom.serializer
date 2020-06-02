<?php


namespace MockingMagician\Atom\Serializer\Standardize;


interface GlobalStandardizerDependant
{
    /**
     * @return GlobalStandardizerInterface
     */
    public function getGlobalStandardizer();
}
