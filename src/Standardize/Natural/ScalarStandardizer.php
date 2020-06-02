<?php


namespace MockingMagician\Atom\Serializer\Standardize\Natural;



use MockingMagician\Atom\Serializer\Exceptions\StandardizeException;
use MockingMagician\Atom\Serializer\Standardize\AbstractCertifiedStandardizer;

class ScalarStandardizer extends AbstractCertifiedStandardizer
{
    /**
     * @param $valueToStandardize
     * @return string|int|float|null|bool
     * @throws StandardizeException
     */
    public function standardize($valueToStandardize)
    {
        parent::standardize($valueToStandardize);

        return $valueToStandardize;
    }

    /**
     * @inheritDoc
     */
    public function canStandardize($valueToStandardize)
    {
        return is_scalar($valueToStandardize);
    }
}
