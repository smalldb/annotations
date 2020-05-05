<?php

namespace Smalldb\Annotations\Tests\Fixtures\Annotation;

/** @Annotation */
class Route
{
    /** @var string @Required */
    public $pattern;
    public $name;
}
