<?php

namespace Smalldb\Annotations\Tests\Fixtures\IgnoredNamespaces;

use SomePropertyAnnotationNamespace\Subnamespace as SomeAlias;

class AnnotatedWithAlias
{
    /**
     * @SomeAlias\Name
     */
    private $property;
}
