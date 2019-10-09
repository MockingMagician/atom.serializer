<?php

namespace MockingMagician\Atom\Serializer\Filter;


interface ValueFilterInterface
{
    public function isValid($value): bool;
}
