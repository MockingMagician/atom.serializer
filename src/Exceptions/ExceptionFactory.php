<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/atom.serializer/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/atom.serializer/blob/master/README.md
 */

namespace MockingMagician\Atom\Serializer\Exceptions;

use Exception;

class ExceptionFactory
{
    /**
     * @param $valueToStandardize
     * @param int       $code
     * @param Exception $previous
     *
     * @return StandardizerNotFound
     */
    public static function standardizerNotFound($valueToStandardize, $code = 0, $previous = null)
    {
        return new StandardizerNotFound($valueToStandardize, $code = 0, $previous = null);
    }

    /**
     * @param $valueToStandardize
     * @param int       $maxCircularReference
     * @param int       $code
     * @param Exception $previous
     *
     * @return CircularReferenceNotHandled
     */
    public static function circularReferenceNotHandled($valueToStandardize, $maxCircularReference, $code = 0, $previous = null)
    {
        return new CircularReferenceNotHandled($valueToStandardize, $maxCircularReference, $code, $previous);
    }

    /**
     * @param $maxDepthReached
     * @param int       $code
     * @param Exception $previous
     *
     * @return MaxDepthReached
     */
    public static function maxDepthReached($maxDepthReached, $code = 0, $previous = null)
    {
        return new MaxDepthReached($maxDepthReached, $code, $previous);
    }
}