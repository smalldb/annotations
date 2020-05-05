<?php

namespace Smalldb\Annotations\Tests\Ticket;

use Smalldb\Annotations\Tests\Fixtures\Controller;
use Smalldb\Annotations\AnnotationReader;
use PHPUnit\Framework\TestCase;

/**
 * @group
 */
class DCOM55Test extends TestCase
{
    /**
     * @expectedException \Smalldb\Annotations\AnnotationException
     * @expectedExceptionMessage [Semantical Error] The class "Smalldb\Annotations\Tests\Fixtures\Controller" is not annotated with @Annotation. Are you sure this class can be used as annotation? If so, then you need to add @Annotation to the _class_ doc comment of "Smalldb\Annotations\Tests\Fixtures\Controller". If it is indeed no annotation, then you need to add @IgnoreAnnotation("Controller") to the _class_ doc comment of class Smalldb\Annotations\Tests\Ticket\Dummy.
     */
    public function testIssue()
    {
        $class = new \ReflectionClass(__NAMESPACE__ . '\\Dummy');
        $reader = new AnnotationReader();
        $reader->getClassAnnotations($class);
    }

    public function testAnnotation()
    {
        $class = new \ReflectionClass(__NAMESPACE__ . '\\DCOM55Consumer');
        $reader = new AnnotationReader();
        $annots = $reader->getClassAnnotations($class);

        self::assertCount(1, $annots);
        self::assertInstanceOf(__NAMESPACE__.'\\DCOM55Annotation', $annots[0]);
    }

    public function testParseAnnotationDocblocks()
    {
        $class = new \ReflectionClass(__NAMESPACE__ . '\\DCOM55Annotation');
        $reader = new AnnotationReader();
        $annots = $reader->getClassAnnotations($class);

        self::assertEmpty($annots);
    }
}

/**
 * @Controller
 */
class Dummy
{

}

/**
 * @Annotation
 */
class DCOM55Annotation
{

}

/**
 * @DCOM55Annotation
 */
class DCOM55Consumer
{

}
