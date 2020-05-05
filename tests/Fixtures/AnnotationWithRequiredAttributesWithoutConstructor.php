<?php

namespace Smalldb\Annotations\Tests\Fixtures;

/**
 * @Annotation
 * @Target("ALL")
 */
final class AnnotationWithRequiredAttributesWithoutConstructor
{

    /**
     * @Required
     * @var string
     */
    public $value;

    /**
     * @Required
     * @var \Smalldb\Annotations\Tests\Fixtures\AnnotationTargetAnnotation
     */
    public $annot;

}
