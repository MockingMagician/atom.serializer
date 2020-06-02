<?php


namespace MockingMagician\Atom\Serializer\Standardize\Natural;



use MockingMagician\Atom\Serializer\Exceptions\StandardizeException;
use MockingMagician\Atom\Serializer\Standardize\AbstractCertifiedStandardizer;

class NullStandardizer extends AbstractCertifiedStandardizer
{
    /**
     * @inheritDoc
     */
    public function canStandardize($valueToStandardize)
    {
        return null === $valueToStandardize;
    }

    /**
     * @param $valueToStandardize
     * @return null
     * @throws StandardizeException
     */
    public function standardize($valueToStandardize)
    {
        parent::standardize($valueToStandardize);

        return $valueToStandardize;
    }
}
