<?php

namespace MockingMagician\Atom\Serializer\Standardizer;


use MockingMagician\Atom\Serializer\Exception\StandardizeValueImplementationException;
use MockingMagician\Atom\Serializer\Register\ObjectRegister;

class ObjectStandardizer implements ObjectStandardizerInterface
{
    private $register;
    private $config;

    public function __construct(ObjectRegister $register, StandardizerConfig $config)
    {
        $this->register = $register;
        $this->config = $config;
    }

    /**
     * Standardize the input object and return an array
     *
     * @param array|object|\Traversable $value
     * @return array
     * @throws \Exception
     */
    public function standardize($value): array
    {
        $this->register->register($value);

        if (is_object($value)) {
            return $this->standardizeObject($value);
        }

        if (is_iterable($value)) {
            return $this->standardizeIterable($value);
        }

        throw new \Exception();
    }

    /**
     * @param $value
     * @return array
     * @throws \ReflectionException
     * @throws \Exception
     * @throws \Throwable
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

            $vs = new ValueStandardizer($this->register, $this->config);
            try {
                $val = $vs->standardize($property->getValue($value));
            } catch (\Throwable $e) {
                if (in_array(get_class($e), $this->config->getContinueOnException(), true)) {
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
     * @param $value
     * @return array
     * @throws \Exception
     */
    private function standardizeIterable($value): array
    {
        $toReturn = [];

        foreach ($value as $k => $v) {
            if ($this->register->isRegistered($v)) {
                continue;
            }

            $vs = new ValueStandardizer($this->register, $this->config);
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
