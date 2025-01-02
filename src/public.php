<?php

use Regex\MalformedRegex;
use function Regex\_errorMessage;
use function Regex\_pcre_pattern;

function re_test(string $pattern, string $subject, string $modifiers = null): bool {
    $match = \preg_match(_pcre_pattern($pattern, $modifiers), $subject);
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
    $result = \implode('', \array_map(
        fn(string $p, ?string $v) => $p . $v,
        \explode($placeholder, $pattern),
        \array_map(fn(string $value) => preg_quote($value, $delimiter), $literals),
    ));
    return $delimiter . $result . $delimiter;
}
