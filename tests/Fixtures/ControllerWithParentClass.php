<?php

namespace Smalldb\Annotations\Tests\Fixtures;

use Smalldb\Annotations\Tests\Fixtures\Annotation\Template;
use Smalldb\Annotations\Tests\Fixtures\Annotation\Route;

/**
 * @Route("/someprefix")
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */
class ControllerWithParentClass extends AbstractController
{
    /**
     * @Route("/", name="_demo")
     * @Template()
     */
    public function indexAction()
    {
        return [];
    }
}
