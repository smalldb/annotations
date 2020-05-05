<?php

namespace Smalldb\Annotations\Tests\Fixtures\Traits;

use Smalldb\Annotations\Tests\Fixtures\Annotation\Template;
use Smalldb\Annotations\Tests\Fixtures\Annotation\Route;

trait SecretRouteTrait
{
    /**
     * @Route("/secret", name="_secret")
     * @Template()
     */
    public function secretAction()
    {
        return [];
    }
}
