<?php

namespace MockingMagician\Atom\Serializer\Tests\Facade;


use MockingMagician\Atom\Serializer\Facade\Standardizer;
use PhpBench\Tests\Unit\Benchmark\Remote\reflector\Class2;
use PHPUnit\Framework\TestCase;

class StandardizerTest extends TestCase
{
    private $class;

    public function setUp(): void
    {
        parent::setUp();
        $this->class = new Class {

            public $scalar = 1;
            public $iterable = [
                'long way' => [
                    'to catch' => true
                ]
            ];

            public function getObject()
            {
                return new class {
                    public function getSomeScalar()
                    {
                        return null;
                    }
                };
            }

        };
    }

    public function testStandardize()
    {
        var_dump(Standardizer::getDefault()->standardize($this->class));
    }
}
