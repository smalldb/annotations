<?php declare(strict_types = 1);
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license. For more information, see
 * <http://www.doctrine-project.org>.
 */

namespace Smalldb\Annotations\Tests;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;
use Smalldb\Annotations\AnnotationException;
use Smalldb\Annotations\RecursiveAnnotationReader;


/**
 * Test the reader for docblock annotations that resolves class inheritance
 * and collects annotations from the parent classes.
 *
 * @author Josef Kufner <josef@kufner.cz>
 */
class RecursiveAnnotationReaderTest extends TestCase
{

    private function assertAnnotations1to4(array $annotations): void
    {
        $annotationClassNames = array_map(function ($a) {
            return get_class($a);
        }, $annotations);
        $this->assertEquals([Annotation1::class, Annotation2::class, Annotation3::class, Annotation4::class], $annotationClassNames);
    }


    /**
     * @throws AnnotationException
     * @throws ReflectionException
     */
    public function testRecursiveReader()
    {
        $reader = new RecursiveAnnotationReader();

        $class = new ReflectionClass(ChildAnnotatedClass::class);
        $this->assertAnnotations1to4($reader->getClassAnnotations($class));

        $method = $class->getMethod('foo');
        $this->assertAnnotations1to4($reader->getMethodAnnotations($method));

        $property = $class->getProperty('foo');
        $this->assertAnnotations1to4($reader->getPropertyAnnotations($property));

        $constant = $class->getReflectionConstant('FOO');
        $this->assertAnnotations1to4($reader->getConstantAnnotations($constant));
    }

}

/**
 * @Annotation
 */
class Annotation1
{
}

/**
 * @Annotation
 */
class Annotation2
{
}

/**
 * @Annotation
 */
class Annotation3
{
}

/**
 * @Annotation
 */
class Annotation4
{
}

/**
 * Class ParentAnnotatedClass
 *
 * @Annotation1
 * @Annotation2
 */
abstract class ParentAnnotatedClass
{
    /**
     * @Annotation1
     * @Annotation2
     */
    const FOO = 1;

    /**
     * @Annotation1
     * @Annotation2
     */
    public $foo;


    /**
     * @Annotation1
     * @Annotation2
     */
    abstract public function foo();

}

/**
 * Class ChildAnnotatedClass
 *
 * @Annotation3
 * @Annotation4
 */
abstract class ChildAnnotatedClass extends ParentAnnotatedClass
{
    /**
     * @Annotation3
     * @Annotation4
     */
    const FOO = 2;

    /**
     * @Annotation3
     * @Annotation4
     */
    public $foo;


    /**
     * @Annotation3
     * @Annotation4
     */
    abstract public function foo();

}

