<?php

namespace Smalldb\Annotations\Tests\Fixtures;

use Smalldb\Annotations\Tests\Bar\Autoload;

class ClassUsesTrait {
    use TraitWithAnnotatedMethod;

    /**
     * @Autoload
     */
    public $aProperty;

    /**
     * @Autoload
     */
    public function someMethod()
    {

    }
}


namespace Smalldb\Annotations\Tests\Bar;

/** @Annotation */
class Autoload
{
}
