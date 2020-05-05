<?php

namespace Smalldb\Annotations\Tests\Fixtures;

use Smalldb\Annotations\Tests\Fixtures\AnnotationTargetClass;
use Smalldb\Annotations\Tests\Fixtures\AnnotationTargetAll;
use Smalldb\Annotations\Tests\Fixtures\AnnotationTargetPropertyMethod;

/**
 * @AnnotationTargetClass("Some data")
 */
class ClassWithValidAnnotationTarget
{

    /**
     * @AnnotationTargetPropertyMethod("Some data")
     */
    public $foo;


    /**
     * @AnnotationTargetAll("Some data",name="Some name")
     */
    public $name;

    /**
     * @AnnotationTargetPropertyMethod("Some data",name="Some name")
     */
    public function someFunction()
    {

    }


    /**
     * @AnnotationTargetAll(@AnnotationTargetAnnotation)
     */
    public $nested;

}
