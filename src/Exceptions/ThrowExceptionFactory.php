<?php


namespace MockingMagician\Atom\Serializer\Exceptions;


use Throwable;

class ThrowExceptionFactory
{
    /**
     * @param $valueToStandardize
     * @param int $code
     * @param Throwable $previous
     * @throws StandardizerNotFound
     */
    public static function standardizerNotFound($valueToStandardize, $code = 0, $previous = null)
    {
        throw new StandardizerNotFound($valueToStandardize, $code = 0, $previous = null);
    }

    /**
     * @param $valueToStandardize
     * @param $maxCircularReference
     * @param int $code
     * @param null $previous
     * @throws CircularReferenceNotHandled
     */
    public static function circularReferenceNotHandled($valueToStandardize, $maxCircularReference, $code = 0, $previous = null)
    {
        throw new CircularReferenceNotHandled($valueToStandardize, $maxCircularReference, $code , $previous);
    }

    /**
     * @param $maxDepthReached
     * @param int $code
     * @param null $previous
     * @throws MaxDepthReached
     */
    public static function maxDepthReached($maxDepthReached, $code = 0, $previous = null)
    {
        throw new MaxDepthReached($maxDepthReached, $code, $previous);
    }
}
