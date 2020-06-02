<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/atom.serializer/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/atom.serializer/blob/master/README.md
 */

namespace MockingMagician\Atom\Serializer\Standardize\Options;

interface StandardizeOptionsInterface
{
    /**
     * @return int
     */
    public function getMaxCircularReference();

    /**
     * @return CircularReferenceHandlerInterface[]
     */
    public function getCircularReferenceHandlers();

    /**
     * @return int
     */
    public function getMaxDepth();

    /**
     * @return bool
     */
    public function isExceptionOnMaxDepth();
}
