<?php

namespace Smalldb\Annotations\Tests\Fixtures;

use Smalldb\Annotations\Tests\Fixtures\AnnotationTargetClass;
use Smalldb\Annotations\Tests\Fixtures\AnnotationTargetAnnotation;

/**
 * @AnnotationTargetClass("Some data")
 */
class ClassWithInvalidAnnotationTargetAtProperty
{

    /**
     * @AnnotationTargetClass("Bar")
     */
    public $foo;


    /**
     * @AnnotationTargetAnnotation("Foo")
     */
    public $bar;
}
