<?php

namespace Smalldb\Annotations\Tests\Fixtures;

use Smalldb\Annotations\Tests\Fixtures\AnnotationEnum;

class ClassWithAnnotationEnum
{
    /**
     * @AnnotationEnum(AnnotationEnum::ONE)
     */
    public $foo;

    /**
     * @AnnotationEnum("TWO")
     */
    public function bar(){}


    /**
     * @AnnotationEnum("FOUR")
     */
    public $invalidProperty;

    /**
     * @AnnotationEnum(5)
     */
    public function invalidMethod(){}
}
