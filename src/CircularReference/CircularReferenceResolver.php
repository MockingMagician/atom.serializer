<?php

namespace MockingMagician\Atom\Serializer\CircularReference;


class CircularReferenceResolver
{
    /** @var callable[] */
    private $resolvers = [];

    public function setResolver(string $class, callable $resolver): self
    {
        $this->resolvers[$class] = $resolver;

        return $this;
    }

    public function haveResolver($object): bool
    {
        if (!is_object($object)) {
            return false;
        }

        return isset($this->resolvers[get_class($object)]);
    }

    /**
     * @param $value
     * @return mixed
     * @throws \Exception
     */
    public function resolve($value)
    {
        if (!$this->haveResolver($value)) {
            throw new \Exception();
        }

        return ($this->resolvers[get_class($value)])($value);
    }
}
