<?php
namespace Test;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

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
}
