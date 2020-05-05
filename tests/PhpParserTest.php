<?php

namespace Smalldb\Annotations\Tests;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Smalldb\Annotations\PhpParser;

require_once __DIR__.'/Fixtures/NonNamespacedClass.php';
require_once __DIR__.'/Fixtures/GlobalNamespacesPerFileWithClassAsFirst.php';
require_once __DIR__.'/Fixtures/GlobalNamespacesPerFileWithClassAsLast.php';

class PhpParserTest extends TestCase
{
    public function testParseClassWithMultipleClassesInFile()
    {
        $class = new ReflectionClass(Fixtures\MultipleClassesInFile::class);
        $parser = new PhpParser();

        self::assertEquals([
            'route'  => Fixtures\Annotation\Route::class,
            'secure' => Fixtures\Annotation\Secure::class,
        ], $parser->parseClass($class));
    }

    public function testParseClassWithMultipleImportsInUseStatement()
    {
        $class = new ReflectionClass(Fixtures\MultipleImportsInUseStatement::class);
        $parser = new PhpParser();

        self::assertEquals([
            'route'  => Fixtures\Annotation\Route::class,
            'secure' => Fixtures\Annotation\Secure::class,
        ], $parser->parseClass($class));
    }

    /**
     * @requires PHP 7.0
     */
    public function testParseClassWithGroupUseStatement()
    {
        $class = new ReflectionClass(Fixtures\GroupUseStatement::class);
        $parser = new PhpParser();

        self::assertEquals([
            'route'  => Fixtures\Annotation\Route::class,
            'supersecure' => Fixtures\Annotation\Secure::class,
            'template' => Fixtures\Annotation\Template::class,
        ], $parser->parseClass($class));
    }

    public function testParseClassWhenNotUserDefined()
    {
        $parser = new PhpParser();
        self::assertEquals([], $parser->parseClass(new \ReflectionClass(\stdClass::class)));
    }

    public function testClassFileDoesNotExist()
    {
        /* @var $class ReflectionClass|\PHPUnit_Framework_MockObject_MockObject */
        $class = $this->getMockBuilder(ReflectionClass::class)
                ->disableOriginalConstructor()
                          ->getMock();
        $class->expects($this->once())
             ->method('getFilename')
             ->will($this->returnValue('/valid/class/Fake.php(35) : eval()d code'));

        $parser = new PhpParser();
        self::assertEquals([], $parser->parseClass($class));
    }

    public function testParseClassWhenClassIsNotNamespaced()
    {
        $parser = new PhpParser();
        $class = new ReflectionClass(\AnnotationsTestsFixturesNonNamespacedClass::class);

        self::assertEquals([
            'route'    => Fixtures\Annotation\Route::class,
            'template' => Fixtures\Annotation\Template::class,
        ], $parser->parseClass($class));
    }

    public function testParseClassWhenClassIsInterface()
    {
        $parser = new PhpParser();
        $class = new ReflectionClass(Fixtures\TestInterface::class);

        self::assertEquals([
            'secure' => Fixtures\Annotation\Secure::class,
        ], $parser->parseClass($class));
    }

    public function testClassWithFullyQualifiedUseStatements()
    {
        $parser = new PhpParser();
        $class = new ReflectionClass(Fixtures\ClassWithFullyQualifiedUseStatements::class);

        self::assertEquals([
            'secure'   => Fixtures\Annotation\Secure::class,
            'route'    => Fixtures\Annotation\Route::class,
            'template' => Fixtures\Annotation\Template::class,
        ], $parser->parseClass($class));
    }

    public function testNamespaceAndClassCommentedOut()
    {
        $parser = new PhpParser();
        $class = new ReflectionClass(Fixtures\NamespaceAndClassCommentedOut::class);

        self::assertEquals([
            'route'    => Fixtures\Annotation\Route::class,
            'template' => Fixtures\Annotation\Template::class,
        ], $parser->parseClass($class));
	}

    public function testEqualNamespacesPerFileWithClassAsFirst()
    {
        $parser = new PhpParser();
        $class = new ReflectionClass(Fixtures\EqualNamespacesPerFileWithClassAsFirst::class);

        self::assertEquals([
            'secure'   => Fixtures\Annotation\Secure::class,
            'route'    => Fixtures\Annotation\Route::class,
        ], $parser->parseClass($class));
    }

    public function testEqualNamespacesPerFileWithClassAsLast()
    {
        $parser = new PhpParser();
        $class = new ReflectionClass(Fixtures\EqualNamespacesPerFileWithClassAsLast::class);

        self::assertEquals([
            'route'    => Fixtures\Annotation\Route::class,
            'template' => Fixtures\Annotation\Template::class,
        ], $parser->parseClass($class));
    }

    public function testDifferentNamespacesPerFileWithClassAsFirst()
    {
        $parser = new PhpParser();
        $class = new ReflectionClass(Fixtures\DifferentNamespacesPerFileWithClassAsFirst::class);

        self::assertEquals([
            'secure'   => Fixtures\Annotation\Secure::class,
        ], $parser->parseClass($class));
    }

    public function testDifferentNamespacesPerFileWithClassAsLast()
    {
        $parser = new PhpParser();
        $class = new ReflectionClass(Fixtures\DifferentNamespacesPerFileWithClassAsLast::class);

        self::assertEquals([
            'template' => Fixtures\Annotation\Template::class,
        ], $parser->parseClass($class));
    }

    public function testGlobalNamespacesPerFileWithClassAsFirst()
    {
        $parser = new PhpParser();
        $class = new \ReflectionClass(\GlobalNamespacesPerFileWithClassAsFirst::class);

        self::assertEquals([
            'secure'   => Fixtures\Annotation\Secure::class,
            'route'    => Fixtures\Annotation\Route::class,
        ], $parser->parseClass($class));
    }

    public function testGlobalNamespacesPerFileWithClassAsLast()
    {
        $parser = new PhpParser();
        $class = new ReflectionClass(\GlobalNamespacesPerFileWithClassAsLast::class);

        self::assertEquals([
            'route'    => Fixtures\Annotation\Route::class,
            'template' => Fixtures\Annotation\Template::class,
        ], $parser->parseClass($class));
    }

    public function testNamespaceWithClosureDeclaration()
    {
        $parser = new PhpParser();
        $class = new ReflectionClass(Fixtures\NamespaceWithClosureDeclaration::class);

        self::assertEquals([
            'secure'   => Fixtures\Annotation\Secure::class,
            'route'    => Fixtures\Annotation\Route::class,
            'template' => Fixtures\Annotation\Template::class,
        ], $parser->parseClass($class));
    }

    public function testIfPointerResetsOnMultipleParsingTries()
    {
        $parser = new PhpParser();
        $class = new ReflectionClass(Fixtures\NamespaceWithClosureDeclaration::class);

        self::assertEquals([
            'secure'   => Fixtures\Annotation\Secure::class,
            'route'    => Fixtures\Annotation\Route::class,
            'template' => Fixtures\Annotation\Template::class,
        ], $parser->parseClass($class));

        self::assertEquals([
            'secure'   => Fixtures\Annotation\Secure::class,
            'route'    => Fixtures\Annotation\Route::class,
            'template' => Fixtures\Annotation\Template::class,
        ], $parser->parseClass($class));
    }

    /**
     * @group DCOM-97
     * @group regression
     */
    public function testClassWithClosure()
    {
        $parser = new PhpParser();
        $class  = new ReflectionClass(Fixtures\ClassWithClosure::class);

        self::assertEquals([
          'annotationtargetall'         => Fixtures\AnnotationTargetAll::class,
          'annotationtargetannotation'  => Fixtures\AnnotationTargetAnnotation::class,
        ], $parser->parseClass($class));
    }
}
