<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/atom.serializer/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/atom.serializer/blob/master/README.md
 */

namespace MockingMagician\Atom\Serializer\Exceptions;

use Exception;

class StandardizeException extends Exception
{
    protected static function typeGetter($value)
    {
        if (is_object($value)) {
            return get_class($value);
        }

        if (is_resource($value)) {
            return get_resource_type($value);
        }

        return gettype($value);
    }
}
