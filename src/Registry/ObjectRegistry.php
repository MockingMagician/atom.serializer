<?php


namespace MockingMagician\Atom\Serializer\Registry;


class ObjectRegistry implements RegistryInterface
{
    private $registry = [];

    /**
     * @inheritDoc
     */
    public function register($object)
    {
        $key = spl_object_hash($object);

        if (!isset($this->registry[$key])) {
            $this->registry[$key] = 0;
            return;
        }

        $this->registry[$key]++;
    }

    /**
     * @inheritDoc
     */
    public function isRegistered($object)
    {
        return isset($this->registry[spl_object_hash($object)]);
    }

    /**
     * @inheritDoc
     */
    public function countRegisterTime($object)
    {
        return $this->isRegistered($object) ? $this->registry[spl_object_hash($object)] : 0;
    }
}
