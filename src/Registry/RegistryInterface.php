<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/atom.serializer/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/atom.serializer/blob/master/README.md
 */

namespace MockingMagician\Atom\Serializer\Registry;

interface RegistryInterface
{
    /**
     * @param object $object
     */
    public function register($object);

    /**
     * @param object $object
     *
     * @return bool
     */
    public function isRegistered($object);

    /**
     * @param object $object
     *
     * @return int
     */
    public function countRegisterTime($object);
}
