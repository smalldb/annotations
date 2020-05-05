<?php

namespace Smalldb\Annotations\Tests\Fixtures;

use Smalldb\Annotations\Tests\Fixtures\Annotation\Route;

/**
 * @Route("/someprefix")
 */
interface InterfaceThatExtendsAnInterface extends EmptyInterface
{
}
