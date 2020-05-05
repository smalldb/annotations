<?php

declare(strict_types=1);

namespace Smalldb\Annotations\Tests\Performance;

use Smalldb\Annotations\DocParser;
use Smalldb\Annotations\Tests\Fixtures\Annotation\Route;
use Smalldb\Annotations\Tests\Fixtures\Annotation\Template;

/**
 * @BeforeMethods({"initializeMethod", "initialize"})
 */
final class DocParserPerformanceBench
{
    use MethodInitializer;

    private const IMPORTS = [
        'ignorephpdoc'     => 'Annotations\Annotation\IgnorePhpDoc',
        'ignoreannotation' => 'Annotations\Annotation\IgnoreAnnotation',
        'route'            => Route::class,
        'template'         => Template::class,
        '__NAMESPACE__'    => 'Smalldb\Annotations\Tests\Fixtures',
    ];

    private const IGNORED = [
        'access', 'author', 'copyright', 'deprecated', 'example', 'ignore',
        'internal', 'link', 'see', 'since', 'tutorial', 'version', 'package',
        'subpackage', 'name', 'global', 'param', 'return', 'staticvar',
        'static', 'var', 'throws', 'inheritdoc',
    ];

    /** @var DocParser */
    private $parser;

    public function initialize() : void
    {
        $this->parser = new DocParser();

        $this->parser->setImports(self::IMPORTS);
        $this->parser->setIgnoredAnnotationNames(array_fill_keys(self::IGNORED, true));
        $this->parser->setIgnoreNotImportedAnnotations(true);
    }

    /**
     * @Revs(200)
     * @Iterations(5)
     */
    public function benchMethodParsing() : void
    {
        $this->parser->parse($this->methodDocBlock);
    }

    /**
     * @Revs(200)
     * @Iterations(5)
     */
    public function benchClassParsing() : void
    {
        $this->parser->parse($this->classDocBlock);
    }
}
