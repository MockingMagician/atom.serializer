<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/atom.serializer/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/atom.serializer/blob/master/README.md
 */

namespace MockingMagician\Atom\Serializer\Registry;

class ObjectRegistry implements RegistryInterface
{
    private $registry = [];

    /**
     * {@inheritdoc}
     */
    public function register($object)
    {
        $key = \spl_object_hash($object);

        if (!isset($this->registry[$key])) {
            $this->registry[$key] = 0;

            return;
        }

        ++$this->registry[$key];
    }

    /**
     * {@inheritdoc}
     */
    public function isRegistered($object)
    {
        return isset($this->registry[\spl_object_hash($object)]);
    }

    /**
     * {@inheritdoc}
     */
    public function countRegisterTime($object)
    {
        return $this->isRegistered($object) ? $this->registry[\spl_object_hash($object)] : 0;
    }
}
