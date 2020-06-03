<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/atom.serializer/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/atom.serializer/blob/master/README.md
 */

namespace MockingMagician\Atom\Serializer\Exceptions;

class MaxDepthReached extends StandardizeException
{
    public function __construct($maxDepthReached, $code = 0, $previous = null)
    {
        $message = \sprintf('Max depth of %s was reached', $maxDepthReached);
        parent::__construct($message, $code, $previous);
    }
}
