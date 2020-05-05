<?php

namespace Smalldb\Annotations\Tests\Fixtures;

use Smalldb\Annotations\Tests\Fixtures\Annotation\Secure;

interface TestInterface
{
    /**
     * @Secure
     */
    public function foo();
}
