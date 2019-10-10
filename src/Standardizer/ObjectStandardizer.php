<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/atom.serializer/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/atom.serializer/blob/master/README.md
 */

namespace MockingMagician\Atom\Serializer\Standardizer;

use MockingMagician\Atom\Serializer\Depth\DepthWatcher;
use MockingMagician\Atom\Serializer\Register\ObjectRegister;

class ObjectStandardizer implements ObjectStandardizerInterface
{
    private $register;
    private $config;
    private $depthWatcher;

    public function __construct(ObjectRegister $register, StandardizerConfig $config, DepthWatcher $depthWatcher)
    {
        $this->register = $register;
        $this->config = $config;
        $this->depthWatcher = $depthWatcher;
    }

    /**
     * Standardize the input object and return an array.
     *
     * @param array|object|\Traversable $value
     *
     * @throws \Exception
     * @throws \Throwable
     *
     * @return array
     */
    public function standardize($value): array
    {
        $this->register->register($value);

        if (\is_iterable($value)) {
            return $this->standardizeIterable($value);
        }

        if (\is_object($value)) {
            return $this->standardizeObject($value);
        }

        throw new \Exception();
    }

    /**
     * @param object $value
     *
     * @throws \ReflectionException
     * @throws \Exception
     * @throws \Throwable
     *
     * @return array
     */
    private function standardizeObject($value): array
    {
        $toReturn = [];

        $rc = new \ReflectionClass($value);

        /** @var \ReflectionProperty[] $pp */
        $rps = $rc->getProperties();

        foreach ($rps as $property) {
            if ($property->isStatic()) {
                continue;
            }

            $property->setAccessible(true);

            if ($this->register->getRegisteredTimes($property->getValue($value))
                >=
                $this->config->getMaxCircularReference()
            ) {
                if ($this->config->getCircularReferenceResolver()->haveResolver($property->getValue($value))) {
                    $toReturn[$property->getName()] =
                        $this->config->getCircularReferenceResolver()->resolve($property->getValue($value))
                    ;
                }

                continue;
            }

            $depthClone = clone $this->depthWatcher;
            $depthClone->goDeeper();

            if ($depthClone->getDepth() > $this->config->getMaxDepth()) {
                continue;
            }

            $vs = new ValueStandardizer($this->register, $this->config, $depthClone);

            try {
                $val = $vs->standardize($property->getValue($value));
            } catch (\Throwable $e) {
                if (\in_array(\get_class($e), $this->config->getContinueOnException(), true)) {
                    continue;
                }

                throw $e;
            }

            foreach ($this->config->getValueFilters() as $valueFilter) {
                if (!$valueFilter->isValid($val)) {
                    continue;
                }
            }

            foreach ($this->config->getObjectValueFilters() as $objectValueFilter) {
                $filter = $objectValueFilter->getFilter($val);
                if (!$filter->isValid($val)) {
                    continue;
                }
            }

            $toReturn[$property->getName()] = $val;
        }

        return $toReturn;
    }

    /**
     * @param array|\Traversable $value
     *
     * @throws \Exception
     * @throws \Throwable
     *
     * @return array
     */
    private function standardizeIterable($value): array
    {
        $toReturn = [];

        foreach ($value as $k => $v) {
            $depthClone = clone $this->depthWatcher;
            $depthClone->goDeeper();

            if ($depthClone->getDepth() > $this->config->getMaxDepth()) {
                continue;
            }

            $vs = new ValueStandardizer($this->register, $this->config, $depthClone);
            $val = $vs->standardize($v);

            foreach ($this->config->getValueFilters() as $valueFilter) {
                if (!$valueFilter->isValid($val)) {
                    continue;
                }
            }

            $toReturn[$k] = $val;
        }

        return $toReturn;
    }
}
