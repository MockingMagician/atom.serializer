<?php


namespace MockingMagician\Atom\Serializer\Registry;


interface RegistryInterface
{
    /**
     * @param object $object
     * @return void
     */
    public function register($object);

    /**
     * @param object $object
     * @return bool
     */
    public function isRegistered($object);

    /**
     * @param object $object
     * @return int
     */
    public function countRegisterTime($object);
}
