<?php


namespace MockingMagician\Atom\Serializer\Exceptions;


class StandardizerNotFound extends StandardizeException
{
    public function __construct($valueToStandardize, $code = 0, $previous = null)
    {
        $message = sprintf(
            "Standardizer not found for value of type : %s",
            self::typeGetter($valueToStandardize)
        );
        parent::__construct($message, $code, $previous);
    }
}
