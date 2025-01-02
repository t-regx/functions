<?php
namespace Test;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Regex\MalformedRegex;

class FunctionsTest extends TestCase
{
    #[Test]
    public function matchingSubject_testsTrue() {
        $this->assertTrue(re_test('\w', 'word'));
    }

    #[Test]
    public function unmatchedSubject_testsFalse() {
        $this->assertFalse(re_test('\d', 'word'));
    }

    #[Test]
    public function matchingCaseInsensitive_testsTrue() {
        $this->assertTrue(re_test('[a-z]', 'WORD', modifiers:'i'));
    }

    #[Test]
    public function malformedPatternException(): void {
        $this->expectException(MalformedRegex::class);
        re_test('[a-z', 'word');
    }

    #[Test]
    public function malformedPatternExceptionMessage(): void {
        $this->expectExceptionMessage('missing terminating ] for character class');
        re_test('[a-z', 'word');
    }
}
