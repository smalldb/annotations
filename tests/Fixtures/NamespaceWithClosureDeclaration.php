<?php

namespace Smalldb\Annotations\Tests\Fixtures;

use Smalldb\Annotations\Tests\Fixtures\Annotation\Secure;
use Smalldb\Annotations\Tests\Fixtures\Annotation\Route;
use Smalldb\Annotations\Tests\Fixtures\Annotation\Template;

$var = 1;
function () use ($var) {};

class NamespaceWithClosureDeclaration {}
