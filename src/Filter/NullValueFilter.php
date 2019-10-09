<?php

namespace MockingMagician\Atom\Serializer\Filter;


class NullValueFilter implements ValueFilterInterface
{
    public function isValid($value): bool
    {
        return !is_null($value);
    }
}
