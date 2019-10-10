<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/atom.serializer/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/atom.serializer/blob/master/README.md
 */

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
        if (!\is_object($object)) {
            return null;
        }

        if (\get_class($object) === $this->class) {
            return $this->valueFilter;
        }

        return null;
    }
}
