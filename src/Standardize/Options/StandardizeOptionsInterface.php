<?php


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
