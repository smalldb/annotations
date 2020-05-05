<?php

declare(strict_types=1);

namespace Smalldb\Annotations\Tests\Performance;

use Smalldb\Annotations\DocLexer;

/**
 * @BeforeMethods({"initializeMethod", "initialize"})
 */
final class DocLexerPerformanceBench
{
    use MethodInitializer;

    /** @var DocLexer */
    private $lexer;

    public function initialize() : void
    {
        $this->lexer = new DocLexer();
    }

    /**
     * @Revs(500)
     * @Iterations(5)
     */
    public function benchMethod() : void
    {
        $this->lexer->setInput($this->methodDocBlock);
    }

    /**
     * @Revs(500)
     * @Iterations(5)
     */
    public function benchClass() : void
    {
        $this->lexer->setInput($this->classDocBlock);
    }
}
