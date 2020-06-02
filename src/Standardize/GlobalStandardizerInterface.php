<?php


namespace MockingMagician\Atom\Serializer\Standardize;


use MockingMagician\Atom\Serializer\Registry\RegistryInterface;
use MockingMagician\Atom\Serializer\Standardize\Options\StandardizeOptionsInterface;

interface GlobalStandardizerInterface extends StandardizerInterface
{
    /**
     * @return RegistryInterface
     */
    public function getRegistry();
    /**
     * @return StandardizeOptionsInterface
     */
    public function getOptions();
    /**
     * @return int
     */
    public function getDeep();
    /**
     * @return int
     */
    public function goDeeper();
    /**
     * @return int
     */
    public function goHigher();
}
