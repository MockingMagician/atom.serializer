<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/atom.serializer/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/atom.serializer/blob/master/README.md
 */

namespace MockingMagician\Atom\Serializer\Standardizer;

use MockingMagician\Atom\Serializer\Depth\DepthWatcher;
use MockingMagician\Atom\Serializer\Register\ObjectRegister;

class Standardizer implements ValueStandardizerInterface
{
    private $config;

    public function __construct(StandardizerConfig $config = null)
    {
        if (null === $config) {
            $config = new StandardizerConfig();
        }

        $this->config = $config;
    }

    /**
     * Standardize the input value and can return scalars type list:
     * - bool
     * - integer
     * - float
     * - string
     * - array.
     *
     * @param mixed $value
     *
     * @throws \Exception
     * @throws \Throwable
     *
     * @return array|bool|float|int|string
     */
    public function standardize($value)
    {
        $vs = new ValueStandardizer(new ObjectRegister(), $this->config, new DepthWatcher());

        return $vs->standardize($value);
    }
}
