<?php

namespace Smalldb\Annotations\Tests\Fixtures;

use Smalldb\Annotations\Tests\Fixtures\Annotation\Route;
use Smalldb\Annotations\Tests\Fixtures\Traits\TraitThatUsesAnotherTrait;

/**
 * @Route("/someprefix")
 */
class ClassThatUsesTraitThatUsesAnotherTrait
{
    use TraitThatUsesAnotherTrait;
}
