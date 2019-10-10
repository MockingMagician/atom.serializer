<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/atom.serializer/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/atom.serializer/blob/master/README.md
 */

namespace MockingMagician\Atom\Serializer\Filter;

class CallbackValueFilter implements ValueFilterInterface
{
    /**
     * @var callable as is function($value) that SHOULD return true for valid and false for to filter
     */
    private $validator;

    public function __construct(callable $validator)
    {
        $this->validator = $validator;
    }

    public function isValid($value): bool
    {
        return ($this->validator)($value);
    }
}
