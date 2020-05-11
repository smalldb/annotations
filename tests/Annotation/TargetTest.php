<?php

namespace Smalldb\Annotations\Tests\Annotation;

use Smalldb\Annotations\Annotation\Target;
use PHPUnit\Framework\TestCase;

/**
 * Tests for {@see \Smalldb\Annotations\Annotation\Target}
 *
 * @covers \Smalldb\Annotations\Annotation\Target
 */
class TargetTest extends TestCase
{
    /**
     * @group DDC-3006
     */
    public function testValidMixedTargets()
    {
        $target = new Target(['value' => ['ALL']]);
        self::assertEquals(Target::TARGET_ALL, $target->targets);

        $target = new Target(['value' => ['METHOD', 'METHOD']]);
        self::assertEquals(Target::TARGET_METHOD, $target->targets);
        self::assertNotEquals(Target::TARGET_PROPERTY, $target->targets);

        $target = new Target(['value' => ['PROPERTY', 'METHOD']]);
        self::assertEquals(Target::TARGET_METHOD | Target::TARGET_PROPERTY, $target->targets);
    }
}

