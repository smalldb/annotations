<?php

namespace Smalldb\Annotations\Tests;

use Smalldb\Annotations\AnnotationException;
use Smalldb\Annotations\AnnotationReader;
use Smalldb\Annotations\DocParser;
use Smalldb\Annotations\Reader;
use Smalldb\Annotations\Tests\Fixtures\Annotation\SingleUseAnnotation;
use Smalldb\Annotations\Tests\Fixtures\ClassWithFullPathUseStatement;
use Smalldb\Annotations\Tests\Fixtures\ClassWithImportedIgnoredAnnotation;
use Smalldb\Annotations\Tests\Fixtures\ClassWithPHPCodeSnifferAnnotation;
use Smalldb\Annotations\Tests\Fixtures\ClassWithPhpCsSuppressAnnotation;
use Smalldb\Annotations\Tests\Fixtures\ClassWithPHPStanGenericsAnnotations;
use Smalldb\Annotations\Tests\Fixtures\IgnoredNamespaces\AnnotatedAtClassLevel;
use Smalldb\Annotations\Tests\Fixtures\IgnoredNamespaces\AnnotatedAtMethodLevel;
use Smalldb\Annotations\Tests\Fixtures\IgnoredNamespaces\AnnotatedAtPropertyLevel;
use Smalldb\Annotations\Tests\Fixtures\IgnoredNamespaces\AnnotatedAtConstantLevel;
use Smalldb\Annotations\Tests\Fixtures\IgnoredNamespaces\AnnotatedWithAlias;

class AnnotationReaderTest extends AbstractReaderTest
{
    /**
     * @return AnnotationReader
     */
    protected function getReader(DocParser $parser = null): Reader
    {
        return new AnnotationReader($parser);
    }

    public function testMethodAnnotationFromTrait()
    {
        $reader = $this->getReader();
        $ref = new \ReflectionClass(Fixtures\ClassUsesTrait::class);

        $annotations = $reader->getMethodAnnotations($ref->getMethod('someMethod'));
        self::assertInstanceOf(Bar\Autoload::class, $annotations[0]);

        $annotations = $reader->getMethodAnnotations($ref->getMethod('traitMethod'));
        self::assertInstanceOf(Fixtures\Annotation\Autoload::class, $annotations[0]);
    }

    public function testMethodAnnotationFromOverwrittenTrait()
    {
        $reader = $this->getReader();
        $ref = new \ReflectionClass(Fixtures\ClassOverwritesTrait::class);

        $annotations = $reader->getMethodAnnotations($ref->getMethod('traitMethod'));
        self::assertInstanceOf(Bar2\Autoload::class, $annotations[0]);
    }

    public function testPropertyAnnotationFromTrait()
    {
        $reader = $this->getReader();
        $ref = new \ReflectionClass(Fixtures\ClassUsesTrait::class);

        $annotations = $reader->getPropertyAnnotations($ref->getProperty('aProperty'));
        self::assertInstanceOf(Bar\Autoload::class, $annotations[0]);

        $annotations = $reader->getPropertyAnnotations($ref->getProperty('traitProperty'));
        self::assertInstanceOf(Fixtures\Annotation\Autoload::class, $annotations[0]);
    }

    public function testConstantAnnotation()
    {
        $reader = $this->getReader();
        $ref = new \ReflectionClass(Fixtures\ClassUsesTrait::class);

        $annotations = $reader->getConstantAnnotations($ref->getReflectionConstant('SOME_CONSTANT'));
        self::assertInstanceOf(Bar\Autoload::class, $annotations[0]);
    }

    public function testOmitNotRegisteredAnnotation()
    {
        $parser = new DocParser();
        $parser->setIgnoreNotImportedAnnotations(true);

        $reader = $this->getReader($parser);
        $ref = new \ReflectionClass(Fixtures\ClassWithNotRegisteredAnnotationUsed::class);

        $annotations = $reader->getMethodAnnotations($ref->getMethod('methodWithNotRegisteredAnnotation'));
        self::assertEquals([], $annotations);
    }

    /**
     * @group 45
     *
     * @runInSeparateProcess
     */
    public function testClassAnnotationIsIgnored()
    {
        $reader = $this->getReader();
        $ref = new \ReflectionClass(AnnotatedAtClassLevel::class);

        $reader::addGlobalIgnoredNamespace('SomeClassAnnotationNamespace');

        self::assertEmpty($reader->getClassAnnotations($ref));
    }

    /**
     * @group 45
     *
     * @runInSeparateProcess
     */
    public function testMethodAnnotationIsIgnored()
    {
        $reader = $this->getReader();
        $ref = new \ReflectionClass(AnnotatedAtMethodLevel::class);

        $reader::addGlobalIgnoredNamespace('SomeMethodAnnotationNamespace');

        self::assertEmpty($reader->getMethodAnnotations($ref->getMethod('test')));
    }

    /**
     * @group 45
     *
     * @runInSeparateProcess
     */
    public function testPropertyAnnotationIsIgnored()
    {
        $reader = $this->getReader();
        $ref = new \ReflectionClass(AnnotatedAtPropertyLevel::class);

        $reader::addGlobalIgnoredNamespace('SomePropertyAnnotationNamespace');

        self::assertEmpty($reader->getPropertyAnnotations($ref->getProperty('property')));
    }

    /**
     * @group 45
     *
     * @runInSeparateProcess
     */
    public function testConstantAnnotationIsIgnored()
    {
        $reader = $this->getReader();
        $ref = new \ReflectionClass(AnnotatedAtConstantLevel::class);

        $reader::addGlobalIgnoredNamespace('SomeConstantAnnotationNamespace');

        self::assertEmpty($reader->getConstantAnnotations($ref->getReflectionConstant('SOME_CONSTANT')));
    }

    /**
     * @group 244
     *
     * @runInSeparateProcess
     */
    public function testAnnotationWithAliasIsIgnored(): void
    {
        $reader = $this->getReader();
        $ref = new \ReflectionClass(AnnotatedWithAlias::class);

        $reader::addGlobalIgnoredNamespace('SomePropertyAnnotationNamespace');

        self::assertEmpty($reader->getPropertyAnnotations($ref->getProperty('property')));
    }

    public function testClassWithFullPathUseStatement()
    {
        if (class_exists(SingleUseAnnotation::class, false)) {
            throw new \LogicException(
                'The SingleUseAnnotation must not be used in other tests for this test to be useful.' .
                'If the class is already loaded then the code path that finds the class to load is not used and ' .
                'this test becomes useless.'
            );
        }

        $reader = $this->getReader();
        $ref = new \ReflectionClass(ClassWithFullPathUseStatement::class);

        $annotations = $reader->getClassAnnotations($ref);

        self::assertInstanceOf(SingleUseAnnotation::class,$annotations[0]);
    }

    public function testPhpCsSuppressAnnotationIsIgnored()
    {
        $reader = $this->getReader();
        $ref = new \ReflectionClass(ClassWithPhpCsSuppressAnnotation::class);

        self::assertEmpty($reader->getMethodAnnotations($ref->getMethod('foo')));
    }

    public function testGloballyIgnoredAnnotationNotIgnored() : void
    {
        $reader = $this->getReader();
        $class  = new \ReflectionClass(Fixtures\ClassDDC1660::class);
        $testLoader = static function (string $className) : bool {
            if ($className === 'since') {
                throw new \InvalidArgumentException('Globally ignored annotation names should never be passed to an autoloader.');
            }
            return false;
        };
        spl_autoload_register($testLoader, true, true);
        try {
            self::assertEmpty($reader->getClassAnnotations($class));
        } finally {
            spl_autoload_unregister($testLoader);
        }
    }

    public function testPHPCodeSnifferAnnotationsAreIgnored()
    {
        $reader = $this->getReader();
        $ref = new \ReflectionClass(ClassWithPHPCodeSnifferAnnotation::class);

        self::assertEmpty($reader->getClassAnnotations($ref));
    }

    public function testPHPStanGenericsAnnotationsAreIgnored()
    {
        $reader = $this->getReader();
        $ref = new \ReflectionClass(ClassWithPHPStanGenericsAnnotations::class);

        self::assertEmpty($reader->getClassAnnotations($ref));
        self::assertEmpty($reader->getPropertyAnnotations($ref->getProperty('bar')));
        self::assertEmpty($reader->getMethodAnnotations($ref->getMethod('foo')));

        $this->expectException(\Smalldb\Annotations\AnnotationException::class);
        $this->expectExceptionMessage('[Semantical Error] The annotation "@Template" in method Smalldb\Annotations\Tests\Fixtures\ClassWithPHPStanGenericsAnnotations::twigTemplateFunctionName() was never imported.');
        self::assertEmpty($reader->getMethodAnnotations($ref->getMethod('twigTemplateFunctionName')));
    }

    public function testImportedIgnoredAnnotationIsStillIgnored()
    {
        $reader = $this->getReader();
        $ref = new \ReflectionClass(ClassWithImportedIgnoredAnnotation::class);

        self::assertEmpty($reader->getMethodAnnotations($ref->getMethod('something')));
    }
}
