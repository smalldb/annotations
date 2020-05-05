<?php

namespace Smalldb\Annotations\Tests\Fixtures;

use Smalldb\Annotations\Tests\Bar2\Autoload;

class ClassOverwritesTrait {
    use TraitWithAnnotatedMethod;

    /**
     * @Autoload
     */
    public function traitMethod()
    {

    }
}


namespace Smalldb\Annotations\Tests\Bar2;

/** @Annotation */
class Autoload
{
}
