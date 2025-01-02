<?php

use Regex\MalformedRegex;
use function Regex\_denoted;
use function Regex\_pcre_pattern;

function re_test(string $pattern, string $subject, string $modifiers = null): bool {
    $match = \preg_match(_pcre_pattern($pattern, $modifiers), $subject);
    $error = \error_get_last();
    if (!$error) {
        return $match;
    }
    [$message, $offset] = \explode(' at offset ', $error['message']);
    $compilationPrefix = 'preg_match(): Compilation failed: ';
    if (\str_starts_with($message, $compilationPrefix)) {
        $errorMessage = \subStr($message, \strLen($compilationPrefix));
        throw new MalformedRegex(_denoted($errorMessage, $pattern, $offset));
    }
    $prefix = 'preg_match(): ';
    if (\str_starts_with($message, $prefix)) {
        throw new MalformedRegex(\subStr($message, \strLen($prefix)));
    }
    throw new MalformedRegex($error['message']);
}
