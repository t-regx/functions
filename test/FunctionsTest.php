<?php
namespace Test;

use PHPUnit\Framework\Attributes\Before;
use PHPUnit\Framework\Attributes\DoesNotPerformAssertions;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Regex\MalformedRegex;

class FunctionsTest extends TestCase
{
    #[Before]
    public function initialize(): void {
        \error_reporting(\E_ALL);
    }

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

    #[Test]
    public function denotedPositionOfSyntaxError(): void {
        $this->expectExceptionMessage('[a-z');
        $this->expectExceptionMessage('    ^');
        re_test('[a-z', 'word');
    }

    #[Test]
    public function throwsForInvalidModifier(): void {
        $this->expectException(MalformedRegex::class);
        re_test('', '', modifiers:'K');
    }

    #[Test]
    public function invalidModifierExceptionMessage(): void {
        $this->expectExceptionMessage("Unknown modifier 'K'");
        re_test('', '', modifiers:'K');
    }

    #[Test]
    public function doesNotLeakImplementationDetail(): void {
        try {
            re_test('foo', 'word', 'K');
        } catch (MalformedRegex $exception) {
            $this->assertStringNotContainsString('preg_match():', $exception->getMessage());
        }
    }

    #[Test]
    #[DoesNotPerformAssertions]
    public function slashIsValidInPattern(): void {
        re_test('a/b', 'a/b');
    }

    #[Test]
    public function afterRegexCall_phpState_isNotPolluted(): void {
        \error_clear_last();
        try {
            re_test(')', '');
        } catch (MalformedRegex) {
        }
        $this->assertNull(\error_get_last());
    }

    #[Test]
    public function dollarAssertion_failsTrailingNewline(): void {
        $this->assertFalse(re_test('foo$', "foo\n"));
    }
}
