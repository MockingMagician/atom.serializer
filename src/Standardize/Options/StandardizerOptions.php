<?php


namespace MockingMagician\Atom\Serializer\Standardize\Options;


class StandardizerOptions implements StandardizeOptionsInterface
{
    /**
     * @var int
     */
    private $maxCircularReference;
    /**
     * @var array
     */
    private $circularReferenceHandlers;
    /**
     * @var int
     */
    private $maxDepth;
    /**
     * @var bool
     */
    private $isExceptionOnMaxDepth;

    public function __construct(
        $maxCircularReference = 1,
        $circularReferenceHandlers = [],
        $manDepth = 256,
        $isExceptionOnMaxDepth = false
    ) {
        $this->maxCircularReference = $maxCircularReference;
        $this->circularReferenceHandlers = $circularReferenceHandlers;
        $this->maxDepth = $manDepth;
        $this->isExceptionOnMaxDepth = $isExceptionOnMaxDepth;
    }

    /**
     * @inheritDoc
     */
    public function getMaxCircularReference()
    {
        return $this->maxCircularReference;
    }

    /**
     * @inheritDoc
     */
    public function getCircularReferenceHandlers()
    {
        return $this->circularReferenceHandlers;
    }

    /**
     * @inheritDoc
     */
    public function getMaxDepth()
    {
        return $this->maxDepth;
    }

    /**
     * @inheritDoc
     */
    public function isExceptionOnMaxDepth()
    {
        return $this->isExceptionOnMaxDepth;
    }
}
