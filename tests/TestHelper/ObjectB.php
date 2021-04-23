<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/atom.serializer/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/atom.serializer/blob/master/README.md
 */

namespace MockingMagician\Atom\Serializer\Tests\TestHelper;

class ObjectB
{
    private $canReference;

    public function __construct($canReference = null)
    {
        $this->canReference = $canReference;
    }

    public function iAmObject()
    {
        return 'B';
    }

    public function reference()
    {
        return $this->reference();
    }
}
