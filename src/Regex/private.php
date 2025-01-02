<?php
namespace Regex;

function _denoted(string $message, string $pattern, int $offset): string {
    $caret = \str_repeat(' ', $offset) . '^';
    return $message . "\n\n" . $pattern . "\n" . $caret . "\n";
}

function _pcre_pattern(string $pattern, ?string $modifiers): string {
    $delimiter = \str_contains($pattern, '/') ? "\1" : '/';
    return $delimiter . $pattern . $delimiter . $modifiers;
}

function _unprefixed(string $string, string $prefix): string {
    if (\str_starts_with($string, $prefix)) {
        return \subStr($string, \strLen($prefix));
    }
    return $string;
}
