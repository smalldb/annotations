<?php

namespace Smalldb\Annotations\Tests\Fixtures;

class ClassWithPhpCsSuppressAnnotation
{
    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
     */
    public function foo($parameterWithoutTypehint) {
    }
}
