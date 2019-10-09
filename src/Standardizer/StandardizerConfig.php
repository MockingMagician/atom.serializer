<?php

namespace MockingMagician\Atom\Serializer\Standardizer;


use MockingMagician\Atom\Serializer\Filter\ObjectValueFilter;
use MockingMagician\Atom\Serializer\Filter\ValueFilterInterface;

class StandardizerConfig
{
    /** @var ValueFilterInterface[] */
    private $valueFilters = [];
    /** @var ObjectValueFilter[] */
    private $objectValueFilters = [];

    public function addValueFilter(ValueFilterInterface $valueFilter)
    {
        $this->valueFilters[] = $valueFilter;
    }

    public function addObjectValueFilter(ObjectValueFilter $objectValueFilter)
    {
        $this->objectValueFilters[] = $objectValueFilter;
    }

    /**
     * @return ValueFilterInterface[]
     */
    public function getValueFilters(): array
    {
        return $this->valueFilters;
    }

    /**
     * @return ObjectValueFilter[]
     */
    public function getObjectValueFilters(): array
    {
        return $this->objectValueFilters;
    }
}