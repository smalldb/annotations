<?php

namespace Smalldb\Annotations\Tests\Fixtures\IgnoredNamespaces;

class AnnotatedAtMethodLevel
{
    /**
     * @SomeMethodAnnotationNamespace\Subnamespace\Name
     */
    public function test() {}
}
