<?php

namespace Smalldb\Annotations\Tests\Fixtures\Annotation;

/** @Annotation */
class Template
{
    private $name;

    public function __construct(array $values)
    {
        $this->name = $values['value'] ?? null;
    }
}
