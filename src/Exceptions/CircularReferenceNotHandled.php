<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/atom.serializer/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/atom.serializer/blob/master/README.md
 */

namespace MockingMagician\Atom\Serializer\Exceptions;

class CircularReferenceNotHandled extends StandardizeException
{
    public function __construct($valueToStandardize, $maxCircularReference, $code = 0, $previous = null)
    {
        $message = \sprintf(
            "Circular reference handler not found for value of type : %s.\nMaximum circular reference is set to %s and was reached.",
            self::typeGetter($valueToStandardize),
            $maxCircularReference
        );
        parent::__construct($message, $code, $previous);
    }
}
