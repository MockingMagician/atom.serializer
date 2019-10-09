<?php

namespace MockingMagician\Atom\Serializer\Register;


class ObjectRegister
{
    private $references = [];

    public function register($value): bool
    {
        if (!is_object($value)) {
            return false;
        }

        if ($this->isRegistered($value)) {
            return true;
        }

        $this->references[] = $value;

        return true;
    }

    public function isRegistered($value): bool
    {
        if (!is_object($value)) {
            return false;
        }

        return in_array($value, $this->references, true);
    }
}
