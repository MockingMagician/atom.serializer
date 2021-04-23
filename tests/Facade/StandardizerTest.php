<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/atom.serializer/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/atom.serializer/blob/master/README.md
 */

namespace MockingMagician\Atom\Serializer\Tests\Facade;

use MockingMagician\Atom\Serializer\Facade\Standardizer;
use MockingMagician\Atom\Serializer\Standardize\Natural\ObjectStandardizer;
use MockingMagician\Atom\Serializer\Standardize\Options\CircularReferenceHandler;
use MockingMagician\Atom\Serializer\Standardize\Options\StandardizerOptions;
use MockingMagician\Atom\Serializer\Tests\TestHelper\ObjectA;
use MockingMagician\Atom\Serializer\Tests\TestHelper\ObjectB;
use PHPUnit\Framework\TestCase;
use Throwable;

/**
 * @internal
 */
class StandardizerTest extends TestCase
{
    private $standardizeTests;

    public function setUp(): void
    {
        parent::setUp();
        $this->standardizeTests = [];

        $this->standardizeTests[] = [
            'is' => new class() {
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
                    return new class() {
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
            ],
        ];

        $commonObjectOne = new ObjectA();
        $commonObjectTwo = new ObjectB($commonObjectOne);

        $this->standardizeTests[] = [
            'is' => [
                'i' => [
                    'am' => [
                        'firsts' => [
                            $commonObjectOne,
                            $commonObjectTwo,
                        ],
                    ],
                ],
            ],
            'should' => [
                'i' => [
                    'am' => [
                        'firsts' => [
                            [
                                'iAmObject' => 'A',
                                'reference' => null,
                            ],
                            [
                                'iAmObject' => 'B',
                                'reference' => \get_class($commonObjectOne),
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * @throws Throwable
     */
    public function testStandardize()
    {
        static::assertSame(
            $this->standardizeTests[0]['should'],
            Standardizer::getDefaultStandardizer()->standardize($this->standardizeTests[0]['is'])
        );
    }

    /**
     * @throws Throwable
     */
    public function testCircular()
    {
        $options = new StandardizerOptions(1, [
            new CircularReferenceHandler(
                function ($value) {return $value instanceof ObjectA; },
                function ($value) {return \get_class($value); }
            ),
            new CircularReferenceHandler(
                function ($value) {return $value instanceof ObjectB; },
                function ($value) {return \get_class($value); }
            ),
        ]);
        $standardizer = Standardizer::createStandardizer([ObjectStandardizer::class], $options);

        static::assertSame(
            $this->standardizeTests[1]['should'],
            $standardizer->standardize($this->standardizeTests[1]['is'])
        );
    }
}
