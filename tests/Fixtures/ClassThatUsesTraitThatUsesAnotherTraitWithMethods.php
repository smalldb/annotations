<?php

namespace Smalldb\Annotations\Tests\Fixtures;

use Smalldb\Annotations\Tests\Fixtures\Annotation\Route;
use Smalldb\Annotations\Tests\Fixtures\Traits\TraitThatUsesAnotherTrait;

class ClassThatUsesTraitThatUsesAnotherTraitWithMethods
{
    use TraitThatUsesAnotherTrait;

    /**
     * @Route("/someprefix")
     */
    public function method1()
    {
    }

    /**
     * @Route("/someotherprefix")
     */
    public function method2()
    {
    }
}
