<?php

namespace Smalldb\Annotations\Tests\Fixtures\IgnoredNamespaces;

class AnnotatedAtConstantLevel
{
    /**
     * @SomeConstantAnnotationNamespace\Subnamespace\Name
     */
    const SOME_CONSTANT = "foo";
}
