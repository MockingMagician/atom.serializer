<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/atom.serializer/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/atom.serializer/blob/master/README.md
 */

namespace MockingMagician\Atom\Serializer\Standardize\Natural;

use MockingMagician\Atom\Serializer\Standardize\AbstractCertifiedStandardizer;
use MockingMagician\Atom\Serializer\Standardize\GlobalStandardizerDependant;
use MockingMagician\Atom\Serializer\Standardize\GlobalStandardizerInterface;

class IterableStandardizer extends AbstractCertifiedStandardizer implements GlobalStandardizerDependant
{
    /**
     * @var null|GlobalStandardizerInterface
     */
    private $globalStandardizer;

    public function __construct(GlobalStandardizerInterface $globalStandardizer)
    {
        $this->globalStandardizer = $globalStandardizer;
    }

    /**
     * {@inheritdoc}
     */
    public function canStandardize($valueToStandardize)
    {
        return \is_iterable($valueToStandardize);
    }

    /**
     * {@inheritdoc}
     */
    public function getGlobalStandardizer()
    {
        return $this->globalStandardizer;
    }

    public function standardize($valueToStandardize)
    {
        parent::standardize($valueToStandardize);

        $toReturn = [];

        foreach ($valueToStandardize as $k => $v) {
            $toReturn[$k] = $this->globalStandardizer->standardize($v);
        }

        return $toReturn;
    }
}
