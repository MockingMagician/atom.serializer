<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/atom.serializer/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/atom.serializer/blob/master/README.md
 */

namespace MockingMagician\Atom\Serializer\Exceptions;

use Exception;
use MockingMagician\Atom\Serializer\Standardize\StandardizerInterface;
use Throwable;

class StandardizeException extends Exception
{
    /**
     * @param mixed                 $value
     * @param StandardizerInterface $standardizer
     * @param int                   $code
     *
     * @return StandardizeException
     */
    public static function CanNotStandardize($value, $standardizer, $code = 0, Throwable $previous = null)
    {
        \ob_start();
        \var_dump($value);
        $dumpedValue = \ob_get_clean();

        return new self(\sprintf(
            "Can not standardize `%s` type\n---\nvalue :\n%s\n---\nfrom `%s` standardizer",
            \gettype($value),
            $dumpedValue,
            \get_class($standardizer)
        ), $code, $previous);
    }

    /**
     * @param int $code
     *
     * @return StandardizeException
     */
    public static function CircularReference($code = 0, Throwable $previous = null)
    {
        return new self(\sprintf(
            'Circular reference not handled'
        ), $code, $previous);
    }

    /**
     * @param int $maxDepth
     * @param int $code
     *
     * @return StandardizeException
     */
    public static function MaxDepth($maxDepth, $code = 0, Throwable $previous = null)
    {
        return new self(\sprintf(
            'Max depth %s reached',
            $maxDepth
        ), $code, $previous);
    }
}
