<?php

namespace Smalldb\Annotations\Tests\Fixtures;

// Include a class named Api
require_once __DIR__ . '/Api.php';

use Smalldb\Annotations\Tests\DummyAnnotationWithIgnoredAnnotation;

/**
 * @DummyAnnotationWithIgnoredAnnotation(dummyValue="hello")
 */
class ClassWithRequire
{
}
