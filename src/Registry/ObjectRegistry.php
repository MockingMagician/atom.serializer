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
            $this->registry[$key] = [
                'objects' => [$object],
                'counts' => [1],
            ];

            return;
        }

        $k = array_search($object, $this->registry[$key]['objects'], true);

        ++$this->registry[$key]['counts'][$k];
    }

    /**
     * {@inheritdoc}
     */
    public function isRegistered($object)
    {
        $key = \spl_object_hash($object);

        if (!isset($this->registry[$key])) {
            return false;
        }

        return array_search($object, $this->registry[$key]['objects'], true);
    }

    /**
     * {@inheritdoc}
     */
    public function countRegisterTime($object)
    {
        if (!$this->isRegistered($object)) {
            return 0;
        }

        $key = \spl_object_hash($object);
        $k = array_search($object, $this->registry[$key]['objects'], true);

        return $this->registry[$key]['counts'][$k];
    }
}
