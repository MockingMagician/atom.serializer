<?php


namespace MockingMagician\Atom\Serializer\Facade;


use MockingMagician\Atom\Serializer\Standardize\GlobalStandardizer;
use MockingMagician\Atom\Serializer\Standardize\Natural\IterableStandardizer;
use MockingMagician\Atom\Serializer\Standardize\Natural\ObjectStandardizer;
use MockingMagician\Atom\Serializer\Standardize\Natural\ScalarStandardizer;
use MockingMagician\Atom\Serializer\Standardize\Options\StandardizerOptions;

class Standardizer
{
    public static function getDefault()
    {
        return new GlobalStandardizer([
            IterableStandardizer::class,
            ObjectStandardizer::class,
            ScalarStandardizer::class,
        ], new StandardizerOptions());
    }
}
