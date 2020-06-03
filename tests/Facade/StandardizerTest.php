<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/atom.serializer/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/atom.serializer/blob/master/README.md
 */

namespace MockingMagician\Atom\Serializer\Tests\Facade;

use MockingMagician\Atom\Serializer\Facade\Standardizer;
use MockingMagician\Atom\Serializer\Tests\TestHelper\ObjectBuilder;
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

        $this->standardizeTests[] = new class() {
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

            public function __construct()
            {
                $this->iterable['go_deeper'] = new class() {
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

                    public function __construct()
                    {
                        $this->iterable['go_deeper'] = new class() {
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

                            public function __construct()
                            {
                                $this->iterable['go_deeper'] = new class() {
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

                                    public function __construct()
                                    {
                                        $this->iterable['go_deeper'] = new class() {
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

                                            public function __construct()
                                            {
                                                $this->iterable['go_deeper'] = new class() {
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

                                                    public function __construct()
                                                    {
                                                        $this->iterable['go_deeper'] = new class() {
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

                                                            public function __construct()
                                                            {
                                                                $this->iterable['go_deeper'] = [];
                                                            }

                                                            public function getObject()
                                                            {
                                                                return new class() {
                                                                    public function getNull()
                                                                    {
                                                                        return null;
                                                                    }
                                                                };
                                                            }
                                                        };
                                                    }

                                                    public function getObject()
                                                    {
                                                        return new class() {
                                                            public function getNull()
                                                            {
                                                                return null;
                                                            }
                                                        };
                                                    }
                                                };
                                            }

                                            public function getObject()
                                            {
                                                return new class() {
                                                    public function getNull()
                                                    {
                                                        return null;
                                                    }
                                                };
                                            }
                                        };
                                    }

                                    public function getObject()
                                    {
                                        return new class() {
                                            public function getNull()
                                            {
                                                return null;
                                            }
                                        };
                                    }
                                };
                            }

                            public function getObject()
                            {
                                return new class() {
                                    public function getNull()
                                    {
                                        return null;
                                    }
                                };
                            }
                        };
                    }

                    public function getObject()
                    {
                        return new class() {
                            public function getNull()
                            {
                                return null;
                            }
                        };
                    }
                };
            }

            public function getObject()
            {
                return new class() {
                    public function getNull()
                    {
                        return null;
                    }
                };
            }
        };
    }

    /**
     * @throws Throwable
     */
    public function testStandardize()
    {
        dump(Standardizer::getDefaultStandardizer()->standardize(new ObjectBuilder(true, true)));

        static::assertSame(
            $this->standardizeTests[0]['should'],
            Standardizer::getDefaultStandardizer()->standardize($this->standardizeTests[0]['is'])
        );
    }
}
