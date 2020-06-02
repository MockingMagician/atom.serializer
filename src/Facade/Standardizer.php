<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/atom.serializer/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/atom.serializer/blob/master/README.md
 */

namespace MockingMagician\Atom\Serializer\Facade;

use MockingMagician\Atom\Serializer\Standardize\GlobalStandardizer;
use MockingMagician\Atom\Serializer\Standardize\Natural\IterableStandardizer;
use MockingMagician\Atom\Serializer\Standardize\Natural\NullStandardizer;
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
            NullStandardizer::class,
        ], new StandardizerOptions());
    }
}
