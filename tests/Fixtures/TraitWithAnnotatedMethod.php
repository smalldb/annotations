<?php
namespace Smalldb\Annotations\Tests\Fixtures;

use Smalldb\Annotations\Tests\Fixtures\Annotation\Autoload;

trait TraitWithAnnotatedMethod {

    /**
     * @Autoload
     */
    public $traitProperty;

    /**
     * @Autoload
     */
    public function traitMethod()
    {
    }
}
