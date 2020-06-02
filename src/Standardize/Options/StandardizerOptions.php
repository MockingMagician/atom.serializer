<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/atom.serializer/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/atom.serializer/blob/master/README.md
 */

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
     * {@inheritdoc}
     */
    public function getMaxCircularReference()
    {
        return $this->maxCircularReference;
    }

    /**
     * {@inheritdoc}
     */
    public function getCircularReferenceHandlers()
    {
        return $this->circularReferenceHandlers;
    }

    /**
     * {@inheritdoc}
     */
    public function getMaxDepth()
    {
        return $this->maxDepth;
    }

    /**
     * {@inheritdoc}
     */
    public function isExceptionOnMaxDepth()
    {
        return $this->isExceptionOnMaxDepth;
    }
}
