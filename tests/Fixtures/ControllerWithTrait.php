<?php

namespace Smalldb\Annotations\Tests\Fixtures;

use Smalldb\Annotations\Tests\Fixtures\Annotation\Template;
use Smalldb\Annotations\Tests\Fixtures\Annotation\Route;
use Smalldb\Annotations\Tests\Fixtures\Traits\SecretRouteTrait;

/**
 * @Route("/someprefix")
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */
class ControllerWithTrait
{
    use SecretRouteTrait;

    /**
     * @Route("/", name="_demo")
     * @Template()
     */
    public function indexAction()
    {
        return [];
    }
}
