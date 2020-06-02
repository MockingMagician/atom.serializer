<?php


namespace MockingMagician\Atom\Serializer\Standardize\Options;


interface CircularReferenceHandlerInterface
{
    /**
     * @param mixed $valueToHandle the value which is a circular reference
     * @return bool
     */
    public function canHandle($valueToHandle);

    /**
     * @param mixed $valueToHandle the value which is a circular reference
     * @return mixed the value returned by the handler if can handle
     */
    public function handle($valueToHandle);
}
