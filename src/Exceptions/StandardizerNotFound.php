<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/atom.serializer/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/atom.serializer/blob/master/README.md
 */

namespace MockingMagician\Atom\Serializer\Exceptions;

class StandardizerNotFound extends StandardizeException
{
    public function __construct($valueToStandardize, $code = 0, $previous = null)
    {
        $message = \sprintf(
            'Standardizer not found for value of type : %s',
            self::typeGetter($valueToStandardize)
        );
        parent::__construct($message, $code, $previous);
    }
}
