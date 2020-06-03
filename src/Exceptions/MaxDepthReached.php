<?php


namespace MockingMagician\Atom\Serializer\Exceptions;


class MaxDepthReached extends StandardizeException
{
    public function __construct($maxDepthReached, $code = 0, $previous = null)
    {
        $message = sprintf("Max depth of %s was reached", $maxDepthReached);
        parent::__construct($message, $code, $previous);
    }
}
