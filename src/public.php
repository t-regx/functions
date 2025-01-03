<?php

use Regex\MalformedRegex;
use function Regex\_errorMessage;
use function Regex\_pcre_pattern;

function re_test(string $pattern, string $subject, string $modifiers = null): bool {
    $match = @\preg_match(_pcre_pattern($pattern, $modifiers), $subject);
    $error = \error_get_last();
    if ($error === null) {
        return $match;
    }
    \error_clear_last();
    throw new MalformedRegex(_errorMessage($error['message'], 'preg_match', $pattern));
}

function re_quote(string $pattern, array $literals = []): string {
    return quoteWith($pattern, $literals, "\1", '@');
}

function quoteWith(string $pattern, array $literals, string $delimiter, string $placeholder): string {
    $count = 0;
    while (($pos = \strPos($pattern, $placeholder)) !== false) {
        $quoted = \preg_quote($literals[$count], $delimiter);
        $pattern = \subStr_replace($pattern, $quoted, $pos, \strLen($placeholder));
        ++$count;
    }
    return $delimiter . $pattern . $delimiter;
}
