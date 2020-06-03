<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/atom.serializer/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/atom.serializer/blob/master/README.md
 */

use MockingMagician\Atom\Serializer\Facade\Standardizer;
use MockingMagician\Atom\Serializer\Standardize\GlobalStandardizer;
use PhpBench\Benchmark\Metadata\Annotations\BeforeMethods;
use PhpBench\Benchmark\Metadata\Annotations\Iterations;
use PhpBench\Benchmark\Metadata\Annotations\Revs;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @BeforeMethods({"init"})
 */
class StandardizeBench
{
    private $toStandardizeSimple;
    private $toStandardizeComplex;

    /**
     * @var GlobalStandardizer
     */
    private $standardizer;
    /**
     * @var Serializer
     */
    private $symSerial;

    public function init()
    {
        $this->toStandardizeSimple = new class() {
            public $scalar = 1;
            public $iterable = [
                'long way' => [
                    'to catch' => true,
                ],
                'i' => [
                    'am' => [
                        'float' => 2.5,
                        'int' => 45,
                    ],
                ],
                'false' => false,
                'go_deeper' => [],
            ];
        };

        $this->toStandardizeComplex = new \MockingMagician\Atom\Serializer\Tests\TestHelper\ObjectBuilder(true, true);

        $this->standardizer = Standardizer::getDefaultStandardizer();

        $this->symSerial = new Symfony\Component\Serializer\Serializer([new ObjectNormalizer()]);
    }

    /**
     * @throws Throwable
     * @Revs(128)
     * @Iterations(10)
     */
    public function benchStandardizeComplex()
    {
        $this->standardizer->standardize($this->toStandardizeComplex);
    }

    /**
     * @throws Throwable
     * @Revs(128)
     * @Iterations(10)
     */
    public function benchStandardizeSimple()
    {
        $this->standardizer->standardize($this->toStandardizeSimple);
    }

    /**
     * @throws ExceptionInterface
     * @Revs(128)
     * @Iterations(10)
     */
    public function benchSymfonyNormalizeComplex()
    {
        $this->symSerial->normalize($this->toStandardizeComplex);
    }

    /**
     * @throws ExceptionInterface
     * @Revs(128)
     * @Iterations(10)
     */
    public function benchSymfonyNormalizeSimple()
    {
        $this->symSerial->normalize($this->toStandardizeSimple);
    }
}
