<?php

namespace MockingMagician\Atom\Serializer\Tests\Facade;


use MockingMagician\Atom\Serializer\Exceptions\StandardizeException;
use MockingMagician\Atom\Serializer\Facade\Standardizer;
use PhpBench\Tests\Unit\Benchmark\Remote\reflector\Class2;
use PHPUnit\Framework\TestCase;

class StandardizerTest extends TestCase
{
    private $standardizeTests;

    public function setUp(): void
    {
        parent::setUp();
        $this->standardizeTests = [];

        $this->standardizeTests[] = [
            'is' => new class {
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
                ];
                public function getObject()
                {
                    return new class {
                        public function getNull()
                        {
                            return null;
                        }
                    };
                }
            },
            'should' => [
                'scalar' => 1,
                'iterable' => [
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
                ],
                'getObject' => [
                    'getNull' => null,
                ],
            ]
        ];
    }

    /**
     * @throws StandardizeException
     */
    public function testStandardize()
    {
        static::assertSame($this->standardizeTests[0]['should'], Standardizer::getDefault()->standardize($this->standardizeTests[0]['is']));
    }
}
