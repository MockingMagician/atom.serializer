<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/atom.serializer/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/atom.serializer/blob/master/README.md
 */

namespace MockingMagician\Atom\Serializer\Facade;

use MockingMagician\Atom\Serializer\Standardize\CertifiedStandardizerInterface;
use MockingMagician\Atom\Serializer\Standardize\GlobalStandardizer;
use MockingMagician\Atom\Serializer\Standardize\Natural\ObjectStandardizer;
use MockingMagician\Atom\Serializer\Standardize\Options\CircularReferenceHandlerInterface;
use MockingMagician\Atom\Serializer\Standardize\Options\StandardizeOptionsInterface;
use MockingMagician\Atom\Serializer\Standardize\Options\StandardizerOptions;

class Standardizer
{
    public static function getDefaultStandardizer()
    {
        return new GlobalStandardizer([
            ObjectStandardizer::class,
        ], new StandardizerOptions());
    }

    /**
     * @param CertifiedStandardizerInterface[] $standardizers
     * @param StandardizeOptionsInterface          $options
     *
     * @return GlobalStandardizer
     */
    public function createStandardizer($standardizers, $options = null)
    {
        if (null === $options) {
            $options = new StandardizerOptions();
        }

        return new GlobalStandardizer($standardizers, $options);
    }

    /**
     * @param int                                 $maxCircularReference
     * @param CircularReferenceHandlerInterface[] $circularReferenceHandlers
     * @param int                                 $maxDepth
     * @param bool                                $isExceptionOnMaxDepth
     *
     * @return StandardizerOptions
     */
    public function createOptions(
        $maxCircularReference = 1,
        $circularReferenceHandlers = [],
        $maxDepth = 256,
        $isExceptionOnMaxDepth = false
    ) {
        return new StandardizerOptions(
            $maxCircularReference,
            $circularReferenceHandlers,
            $maxDepth,
            $isExceptionOnMaxDepth
        );
    }
}
