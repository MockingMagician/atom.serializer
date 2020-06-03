<?php


namespace MockingMagician\Atom\Serializer\Tests\TestHelper;


use Faker\Factory;
use Faker\Generator;

class ObjectBuilder
{
    /**
     * @var Generator
     */
    private $faker;
    /**
     * @var bool
     */
    private $getObjectReturnObject;
    /**
     * @var bool
     */
    private $randomDataReferenceThis;

    public function __construct($getObjectReturnObject = false, $randomDataReferenceThis = false)
    {
        $this->faker = Factory::create();
        $this->getObjectReturnObject = $getObjectReturnObject;
        $this->randomDataReferenceThis = $randomDataReferenceThis;
    }

    private function array($length = 5, $deep = 10)
    {
        $array = [];
        $lengthCopy = $length;
        while ($lengthCopy--) {
            if ($deep > 1) {
                $array[$this->faker->uuid] = $this->array($length, ($deep - 1));
                continue;
            }
            $array[$this->faker->uuid] = $this->randomData($this->randomDataReferenceThis);
        }

        return $array;
    }

    private function randomData($referenceThis = false)
    {
        $list = [
            $this->faker->text,
            $this->faker->randomDigit,
            $this->faker->randomFloat(),
            $this->faker->boolean,
            null,
        ];

        if ($referenceThis) {
            $list[] = new $this();
        }

        return $list[rand(0, count($list) - 1)];
    }

    public function getInt()
    {
        return $this->faker->randomDigit;
    }

    public function getFloat()
    {
        return $this->faker->randomFloat();
    }

    public function getText()
    {
        return $this->faker->text();
    }

    public function getNull()
    {
        return null;
    }

    public function getObjectOrNull()
    {
        return $this->getObjectReturnObject ? new self([true, false][rand(0, 1)]) : null;
    }

    public function getArray()
    {
        return $this->array(2, 2);
    }
}
