<?php

namespace Smalldb\Annotations\Tests\Fixtures\IgnoredNamespaces;

class AnnotatedAtPropertyLevel
{
    /**
     * @SomePropertyAnnotationNamespace\Subnamespace\Name
     */
    private $property;
}
