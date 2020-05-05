<?php

namespace Smalldb\Annotations\Tests\Fixtures;


/**
 * @Annotation
 * @Target("METHOD")
 */
final class AnnotationTargetMethod
{
    public $data;
    public $name;
    public $target;
}
