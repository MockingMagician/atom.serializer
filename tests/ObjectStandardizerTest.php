<?php

namespace MockingMagician\Atom\Serializer\Tests;

use MockingMagician\Atom\Serializer\Register\ObjectRegister;
use MockingMagician\Atom\Serializer\Standardizer\ObjectStandardizer;
use MockingMagician\Atom\Serializer\Standardizer\StandardizerConfig;
use PHPUnit\Framework\TestCase;

class ObjectStandardizerTest extends TestCase
{

    /**
     * @throws \Exception
     */
    public function test standardize simple array()
    {
        $os = new ObjectStandardizer(new ObjectRegister(), new StandardizerConfig());

        $array = [
            'string',
            15,
            0.2,
        ];

        $this->assertEquals($array, $os->standardize($array));
    }

    /**
     * @throws \Exception
     */
    public function test standardize keys values array()
    {
        $os = new ObjectStandardizer(new ObjectRegister(), new StandardizerConfig());

        $array = [
            'string with no key',
            'key' => 'string with a key',
            10 => 'string',
            15 => 5,
            20 => 3.45,
        ];

        $this->assertEquals($array, $os->standardize($array));
    }

    /**
     * @throws \Exception
     */
    public function test standardize simple object()
    {
        $os = new ObjectStandardizer(new ObjectRegister(), new StandardizerConfig());

        $object = new class {
            public $public;
            protected $protected;
            private $private;

            public function __construct()
            {
                $this->public = 'public';
                $this->protected = 'protected';
                $this->private = 'private';
            }
        };

        $this->assertEquals(
            [
                'public' => 'public',
                'protected' => 'protected',
                'private' => 'private',
            ],
            $os->standardize($object)
        );
    }

    /**
     * @throws \Exception
     */
    public function test standardize object infinite circular reference()
    {
        $os = new ObjectStandardizer(new ObjectRegister(), new StandardizerConfig());

        $object = new class {
            public $banalReference;
            public $selfReference;

            public function __construct()
            {
                $this->banalReference = 'banal_reference';
                $this->selfReference = $this;
            }
        };

        $this->assertEquals(
            [
                'banalReference' => 'banal_reference',
            ],
            $os->standardize($object)
        );
    }

    /**
     * @throws \Exception
     */
    public function test standardize object infinite circular reference accept most than one()
    {
        $sc = new StandardizerConfig();
        $sc->setMaxCircularReference(3);

        $os = new ObjectStandardizer(new ObjectRegister(), $sc);

        $object = new class {
            public $banalReference;
            public $selfReference;

            public function __construct()
            {
                $this->banalReference = 'banal_reference';
                $this->selfReference = $this;
            }
        };

        $this->assertEquals(
            [
                'banalReference' => 'banal_reference',
                'selfReference' => [
                    'banalReference' => 'banal_reference',
                    'selfReference' => [
                        'banalReference' => 'banal_reference',
                    ],
                ],
            ],
            $os->standardize($object)
        );
    }

    /**
     * @throws \Exception
     */
    public function test standardize object infinite circular reference with resolver()
    {
        $object = new class {
            public $banalReference;
            public $selfReference;

            public function __construct()
            {
                $this->banalReference = 'banal_reference';
                $this->selfReference = $this;
            }
        };

        $sc = new StandardizerConfig();
        $sc->addCircularReferenceResolver(get_class($object), function ($object) { return get_class($object); });

        $os = new ObjectStandardizer(new ObjectRegister(), $sc);

        $this->assertEquals(
            [
                'banalReference' => 'banal_reference',
                'selfReference' => get_class($object),
            ],
            $os->standardize($object)
        );
    }
}
