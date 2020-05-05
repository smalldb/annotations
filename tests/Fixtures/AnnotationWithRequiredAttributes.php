<?php

namespace Smalldb\Annotations\Tests\Fixtures;

/**
 * @Annotation
 * @Target("ALL")
 * @Attributes({
      @Attribute("value",   required = true ,   type = "string"),
      @Attribute("annot",   required = true ,   type = "Smalldb\Annotations\Tests\Fixtures\AnnotationTargetAnnotation"),
   })
 */
final class AnnotationWithRequiredAttributes
{

    public final function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * @var string
     */
    private $value;

    /**
     * @var \Smalldb\Annotations\Tests\Fixtures\AnnotationTargetAnnotation
     */
    private $annot;

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return \Smalldb\Annotations\Tests\Fixtures\AnnotationTargetAnnotation
     */
    public function getAnnot()
    {
        return $this->annot;
    }

}
