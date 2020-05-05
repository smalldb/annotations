<?php

// namespace Smalldb\Annotations\Tests\Fixtures;
namespace Smalldb\Annotations\Tests\Fixtures\Foo {

    use Smalldb\Annotations\Tests\Fixtures\Annotation\Secure;

    // class NamespaceAndClassCommentedOut {}
}

namespace Smalldb\Annotations\Tests\Fixtures {

    // class NamespaceAndClassCommentedOut {}
    use Smalldb\Annotations\Tests\Fixtures\Annotation\Route;

    // namespace Smalldb\Annotations\Tests\Fixtures;
    use Smalldb\Annotations\Tests\Fixtures\Annotation\Template;

    class NamespaceAndClassCommentedOut {}
}
