<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/atom.serializer/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/atom.serializer/blob/master/README.md
 */

namespace MockingMagician\Atom\Serializer\Standardize\Options;

class CircularReferenceHandler implements CircularReferenceHandlerInterface
{
    /**
     * @var callable
     */
    private $canHandleMethod;
    /**
     * @var callable
     */
    private $handlerMethod;

    /**
     * CircularReferenceHandler constructor.
     *
     * @param callable $canHandleMethod callable as is callable($valueToHandle), check if handler can handle with this kind of value, shall return bool
     * @param callable $handlerMethod   callable as is callable($valueToHandle), deal with the value
     */
    public function __construct($canHandleMethod, $handlerMethod)
    {
        $this->canHandleMethod = $canHandleMethod;
        $this->handlerMethod = $handlerMethod;
    }

    /**
     * {@inheritdoc}
     */
    public function canHandle($valueToHandle)
    {
        return ($this->canHandleMethod)($valueToHandle);
    }

    /**
     * {@inheritdoc}
     */
    public function handle($valueToHandle)
    {
        return ($this->handlerMethod)($valueToHandle);
    }
}
