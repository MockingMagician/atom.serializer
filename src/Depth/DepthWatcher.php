<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/atom.serializer/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/atom.serializer/blob/master/README.md
 */

namespace MockingMagician\Atom\Serializer\Depth;

class DepthWatcher
{
    private $depth;

    public function __construct()
    {
        $this->depth = 0;
    }

    public function goDeeper(): self
    {
        ++$this->depth;

        return $this;
    }

    public function getDepth(): int
    {
        return $this->depth;
    }
}
