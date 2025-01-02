<?php

use Regex\MalformedRegex;
use function Regex\_denoted;
use function Regex\_pcre_pattern;
use function Regex\_unprefixed;

function re_test(string $pattern, string $subject, string $modifiers = null): bool {
    $match = \preg_match(_pcre_pattern($pattern, $modifiers), $subject);
    $error = \error_get_last();
    if ($error === null) {
        return $match;
    }
    \error_clear_last();
    $errorMessage = _unprefixed($error['message'], 'preg_match(): ');
    [$pcreMessage, $offset] = \explode(' at offset ', $errorMessage);
    $compilationPrefix = 'Compilation failed: ';
    if (\str_starts_with($pcreMessage, $compilationPrefix)) {
        throw new MalformedRegex(_denoted(
            \subStr($pcreMessage, \strLen($compilationPrefix)),
            $pattern, $offset));
    }
    throw new MalformedRegex($errorMessage);
}
