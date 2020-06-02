<?php


namespace MockingMagician\Atom\Serializer\Standardize\Natural;


use MockingMagician\Atom\Serializer\Standardize\AbstractCertifiedStandardizer;
use MockingMagician\Atom\Serializer\Standardize\GlobalStandardizerDependant;
use MockingMagician\Atom\Serializer\Standardize\GlobalStandardizerInterface;

class IterableStandardizer extends AbstractCertifiedStandardizer implements  GlobalStandardizerDependant
{
    /**
     * @var GlobalStandardizerInterface|null
     */
    private $globalStandardizer;

    public function __construct(GlobalStandardizerInterface $globalStandardizer)
    {
        $this->globalStandardizer = $globalStandardizer;
    }

    /**
     * @inheritDoc
     */
    public function canStandardize($valueToStandardize)
    {
        return is_iterable($valueToStandardize);
    }

    /**
     * @inheritDoc
     */
    public function getGlobalStandardizer()
    {
        return $this->globalStandardizer;
    }

    public function standardize($valueToStandardize)
    {
        parent::standardize($valueToStandardize);

        $toReturn= [];

        foreach ($valueToStandardize as $k => $v) {
            $toReturn[$k] = $this->globalStandardizer->standardize($v);
        }

        return $toReturn;
    }


}
