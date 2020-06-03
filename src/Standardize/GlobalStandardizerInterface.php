<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/atom.serializer/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/atom.serializer/blob/master/README.md
 */

namespace MockingMagician\Atom\Serializer\Standardize;

use MockingMagician\Atom\Serializer\Registry\RegistryInterface;
use MockingMagician\Atom\Serializer\Standardize\Options\StandardizeOptionsInterface;

interface GlobalStandardizerInterface extends StandardizerInterface
{
    /**
     * @return RegistryInterface
     */
    public function getRegistry();

    /**
     * @return StandardizeOptionsInterface
     */
    public function getOptions();

    /**
     * @return int
     */
    public function getDepth();

    /**
     * @return int
     */
    public function goDeeper();

    /**
     * @return int
     */
    public function goHigher();
}
