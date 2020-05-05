<?php

namespace Smalldb\Annotations\Tests\Fixtures {
    use Smalldb\Annotations\Tests\Fixtures\Annotation\Secure;

    class DifferentNamespacesPerFileWithClassAsFirst {}
}

namespace {
    use Smalldb\Annotations\Tests\Fixtures\Annotation\Route;
}

namespace Smalldb\Annotations\Tests\Fixtures\Foo {
    use Smalldb\Annotations\Tests\Fixtures\Annotation\Template;
}
