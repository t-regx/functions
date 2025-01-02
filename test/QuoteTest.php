<?php
namespace Test;

use PHPUnit\Framework\Attributes\DoesNotPerformAssertions;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class QuoteTest extends TestCase
{
    #[Test]
    public function replacePlaceholder_withQuoteValue(): void {
        $this->assertSamePattern('Foo:Bar', re_quote('Foo:@', ['Bar']));
    }

    #[Test]
    public function quoteValue(): void {
        $this->assertSamePattern('\{2\}', re_quote('@', ['{2}']));
    }

    #[Test]
    public function quoteMultipleValues(): void {
        $this->assertSamePattern('One,Two', re_quote('@,@', ['One', 'Two']));
    }

    private function assertSamePattern(string $expected, string $actual): void {
        $expectedPattern = chr(1) . $expected . chr(1);
        $this->assertSame($expectedPattern, $actual);
    }

    #[Test]
    public function quotedPattern_isMatched(): void {
        $this->assertTrue(re_test(re_quote('foo'), 'foo'));
    }

    #[Test]
    public function quotedPattern_isMatched_withModifiers(): void {
        $this->assertTrue(re_test(re_quote('[a-z]'), 'FOO', modifiers:'i'));
    }

    #[Test]
    public function quotedValue_isQuotedWithDelimiter(): void {
        $delimiter = "\1";
        $this->assertSamePattern("foo\\$delimiter", re_quote('@', ["foo$delimiter"]));
    }

    #[Test]
    #[DoesNotPerformAssertions]
    public function leadingSlash_isNotNaivelyMistookForDelimitedPattern(): void {
        re_test('/abc', '/abc');
    }
}
