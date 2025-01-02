<?php
namespace Regex;

function _denoted(string $message, string $pattern, int $offset): string {
    $caret = \str_repeat(' ', $offset) . '^';
    return $message . "\n\n" . $pattern . "\n" . $caret . "\n";
}

function _pcre_pattern(string $pattern, ?string $modifiers): string {
    $delimiter = \str_contains($pattern, '/') ? "\1" : '/';
    return $delimiter . $pattern . $delimiter . "D$modifiers";
}

function _errorMessage(string $phpMessage, string $methodName, string $errorPattern): string {
    $errorMessage = _unprefixed($phpMessage, "$methodName(): ");
    [$pcreMessage, $offset] = \explode(' at offset ', $errorMessage);
    $compilationPrefix = 'Compilation failed: ';
    if (\str_starts_with($pcreMessage, $compilationPrefix)) {
        return _denoted(
            \subStr($pcreMessage, \strLen($compilationPrefix)),
            $errorPattern, $offset);
    }
    return $errorMessage;
}

function _unprefixed(string $string, string $prefix): string {
    if (\str_starts_with($string, $prefix)) {
        return \subStr($string, \strLen($prefix));
    }
    return $string;
}
