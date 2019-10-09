<?php

namespace MockingMagician\Atom\Serializer\Standardizer;


interface ObjectStandardizerInterface
{
    /**
     * Standardize the input object and return an array
     *
     * @param object|array|\Traversable $value
     * @return array
     */
    public function standardize($value): array;
}
