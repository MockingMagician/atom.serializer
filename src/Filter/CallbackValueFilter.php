<?php

namespace MockingMagician\Atom\Serializer\Filter;


class CallbackValueFilter implements ValueFilterInterface
{
    /**
     * @var callable as is function($value) that SHOULD return true for valid $value and false for $value to filter
     */
    private $validator;

    public function __construct(callable $validator)
    {
        $this->validator = $validator;
    }

    public function isValid($value): bool
    {
        return ($this->validator)($value);
    }
}
