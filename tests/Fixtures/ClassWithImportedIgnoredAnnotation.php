<?php

namespace Smalldb\Annotations\Tests\Fixtures;

use Smalldb\Annotations\Tests\Fixtures\Annotation\Param;

class ClassWithImportedIgnoredAnnotation
{
    /**
     * @param string $foo
     */
    public function something($foo)
    {
    }
}
