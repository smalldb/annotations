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

namespace Smalldb\Annotations;

use ReflectionClass;
use ReflectionClassConstant;
use ReflectionMethod;
use ReflectionProperty;


/**
 * A reader for docblock annotations that resolves class inheritance
 * and collects annotations from the parent classes.
 *
 * @author Josef Kufner <josef@kufner.cz>
 */
class RecursiveAnnotationReader extends AnnotationReader
{

    public function getClassAnnotations(ReflectionClass $class)
    {
        $annotations = [parent::getClassAnnotations($class)];
        while (($class = $class->getParentClass())) {
            $annotations[] = parent::getClassAnnotations($class);
        }
        return array_merge(...array_reverse($annotations));
    }


    public function getPropertyAnnotations(ReflectionProperty $property)
    {
        $annotations = [parent::getPropertyAnnotations($property)];
        $class = $property->getDeclaringClass();
        $propertyName = $property->getName();
        while (($class = $class->getParentClass()) !== false && $class->hasProperty($propertyName)) {
            $property = $class->getProperty($propertyName);
            $annotations[] = parent::getPropertyAnnotations($property);
        }
        return array_merge(...array_reverse($annotations));
    }


    public function getMethodAnnotations(ReflectionMethod $method)
    {
        $annotations = [parent::getMethodAnnotations($method)];
        $class = $method->getDeclaringClass();
        $methodName = $method->getName();
        while (($class = $class->getParentClass()) && $class->hasMethod($methodName)) {
            $method = $class->getMethod($methodName);
            $annotations[] = parent::getMethodAnnotations($method);
        }
        return array_merge(...array_reverse($annotations));
    }


    public function getConstantAnnotations(ReflectionClassConstant $constant): array
    {
        $annotations = [parent::getConstantAnnotations($constant)];
        $class = $constant->getDeclaringClass();
        $constantName = $constant->getName();
        while (($class = $class->getParentClass()) && $class->hasConstant($constantName)) {
            $constant = $class->getReflectionConstant($constantName);
            $annotations[] = parent::getConstantAnnotations($constant);
        }
        return array_merge(...array_reverse($annotations));
    }

}

