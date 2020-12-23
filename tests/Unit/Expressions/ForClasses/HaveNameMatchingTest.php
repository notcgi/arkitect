<?php
declare(strict_types=1);

namespace Arkitect\Tests\Unit\Expressions\ForClasses;

use Arkitect\Analyzer\ClassDescription;
use Arkitect\Expression\ForClasses\HaveNameMatching;
use PHPUnit\Framework\TestCase;

class HaveNameMatchingTest extends TestCase
{
    public function testCheckClassNameMatch(): void
    {
        $expression = new HaveNameMatching('*Class');

        $goodClass = ClassDescription::build('\App\MyClass')->get();

        $this->assertTrue($expression->evaluate($goodClass));
    }

    public function testShowViolationWhenClassNameDoesNotMatch(): void
    {
        $expression = new HaveNameMatching('*GoodName*');

        $badClass = ClassDescription::build('\App\BadNameClass')->get();

        $this->assertFalse($expression->evaluate($badClass));
        $this->assertEquals('\App\BadNameClass has a name that matches *GoodName*', $expression->describe($badClass)->toString());
    }
}
