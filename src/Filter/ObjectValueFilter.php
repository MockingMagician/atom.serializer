<?php

namespace MockingMagician\Atom\Serializer\Filter;


class ObjectValueFilter
{
    private $class;
    private $valueFilter;

    public function __construct(string $class, ValueFilterInterface $valueFilter)
    {
        $this->class = $class;
        $this->valueFilter = $valueFilter;
    }

    public function getFilter($object): ?ValueFilterInterface
    {
        if (!is_object($object)) {
            return null;
        }

        if (get_class($object) === $this->class) {
            return $this->valueFilter;
        }

        return null;
    }
}
