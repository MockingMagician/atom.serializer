<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/atom.serializer/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/atom.serializer/blob/master/README.md
 */

namespace MockingMagician\Atom\Serializer\Exception;

use Throwable;

class StandardizeValueImplementationException extends \Exception
{
    public function __construct($value, int $code = 0, Throwable $previous = null)
    {
        $type = \gettype($value);
        if (\is_object($value)) {
            $type = \get_class($value);
        }
        if (\is_resource($value)) {
            $type .= '{'.\get_resource_type($value).'}';
        }
        $message = \sprintf('Implementation for `%s` is not yet defined', $type);
        parent::__construct($message, $code, $previous);
    }
}
