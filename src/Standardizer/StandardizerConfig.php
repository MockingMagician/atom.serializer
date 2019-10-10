<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/atom.serializer/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/atom.serializer/blob/master/README.md
 */

namespace MockingMagician\Atom\Serializer\Standardizer;

use MockingMagician\Atom\Serializer\CircularReference\CircularReferenceResolver;
use MockingMagician\Atom\Serializer\Exception\StandardizeValueImplementationException;
use MockingMagician\Atom\Serializer\Filter\ObjectValueFilter;
use MockingMagician\Atom\Serializer\Filter\ValueFilterInterface;

class StandardizerConfig
{
    /** @var ValueFilterInterface[] */
    private $valueFilters = [];
    /** @var ObjectValueFilter[] */
    private $objectValueFilters = [];
    /** @var int */
    private $maxCircularReference = 1;
    /** @var CircularReferenceResolver */
    private $circularReferenceResolver;
    /** @var string[] containing class names for which we have to continue on exception */
    private $continueOnException = [
        StandardizeValueImplementationException::class,
    ];

    public function __construct()
    {
        $this->circularReferenceResolver = new CircularReferenceResolver();
    }

    public function addValueFilter(ValueFilterInterface $valueFilter): self
    {
        $this->valueFilters[] = $valueFilter;

        return $this;
    }

    public function addObjectValueFilter(ObjectValueFilter $objectValueFilter): self
    {
        $this->objectValueFilters[] = $objectValueFilter;
    }

    /**
     * @return ValueFilterInterface[]
     */
    public function getValueFilters(): array
    {
        return $this->valueFilters;
    }

    /**
     * @return ObjectValueFilter[]
     */
    public function getObjectValueFilters(): array
    {
        return $this->objectValueFilters;
    }

    public function setMaxCircularReference(int $maxCircularReference): self
    {
        if ($maxCircularReference < 1) {
            throw new \UnexpectedValueException('`$maxCircularReference` have to be greater or equal to 1');
        }

        $this->maxCircularReference = $maxCircularReference;

        return $this;
    }

    public function getMaxCircularReference(): int
    {
        return $this->maxCircularReference;
    }

    public function addCircularReferenceResolver(string $class, callable $resolver): self
    {
        $this->circularReferenceResolver->setResolver($class, $resolver);

        return $this;
    }

    public function getCircularReferenceResolver(): CircularReferenceResolver
    {
        return $this->circularReferenceResolver;
    }

    public function getContinueOnException(): array
    {
        return $this->continueOnException;
    }
}
