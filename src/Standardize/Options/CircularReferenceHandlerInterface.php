<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/atom.serializer/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/atom.serializer/blob/master/README.md
 */

namespace MockingMagician\Atom\Serializer\Standardize\Options;

interface CircularReferenceHandlerInterface
{
    /**
     * @param mixed $valueToHandle the value which is a circular reference
     *
     * @return bool
     */
    public function canHandle($valueToHandle);

    /**
     * @param mixed $valueToHandle the value which is a circular reference
     *
     * @return mixed the value returned by the handler if can handle
     */
    public function handle($valueToHandle);
}
