<?php

namespace MockingMagician\Atom\Serializer\Register;


class ObjectRegister
{
    private $references = [];
    private $referencesCounter = [];

    public function register($value): bool
    {
        if (!is_object($value)) {
            return false;
        }

        if ($this->isRegistered($value)) {
            $this->incrementCounter($value);

            return true;
        }

        $this->references[] = $value;
        $this->referencesCounter[] = 1;

        return true;
    }

    public function isRegistered($value): bool
    {
        if (!is_object($value)) {
            return false;
        }

        return in_array($value, $this->references, true);
    }

    public function getRegisteredTimes($value): int
    {
        if (!is_object($value)) {
            return 0;
        }

        $key = array_search($value, $this->references, true);

        if (false === $key) {
            return 0;
        }

        return $this->referencesCounter[$key];
    }

    private function incrementCounter($value): self
    {
        if (!is_object($value)) {
            return $this;
        }

        $key = array_search($value, $this->references, true);

        if (false === $key) {
            return $this;
        }

        if (!isset($this->referencesCounter[$key])) {
            $this->referencesCounter[$key] = 0;

            return $this;
        }

        $this->referencesCounter[$key]++;

        return $this;
    }
}
