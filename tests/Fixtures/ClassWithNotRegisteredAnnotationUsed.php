<?php

namespace Smalldb\Annotations\Tests\Fixtures;

/**
 * Class ClassWithNotRegisteredAnnotationUsed
 * @package Smalldb\Annotations\Tests\Fixtures
 */
class ClassWithNotRegisteredAnnotationUsed
{
    /**
     * @notRegisteredCustomAnnotation
     * @return bool
     */
    public function methodWithNotRegisteredAnnotation()
    {
        return false;
    }
}
