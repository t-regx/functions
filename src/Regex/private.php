<?php
namespace Regex;

function _denoted(string $message, string $pattern, int $offset): string {
    $caret = \str_repeat(' ', $offset) . '^';
    return $message . "\n\n" . $pattern . "\n" . $caret . "\n";
}

function _pcre_pattern(string $pattern, ?string $modifiers): string {
    $delimiter = _pcre_delimiter($pattern);
    return $delimiter . $pattern . $delimiter . "D$modifiers";
}

function _pcre_delimiter(string $pattern): string {
    if ($pattern[0] === "\1") {
        return '';
    }
    return "\1";
}

function _errorMessage(string $phpMessage, string $methodName, string $errorPattern): string {
    $errorMessage = _unprefixed($phpMessage, "$methodName(): ");
    $tuple = \explode(' at offset ', $errorMessage);
    $compilationPrefix = 'Compilation failed: ';
    if (\str_starts_with($tuple[0], $compilationPrefix)) {
        return _denoted(
            \subStr($tuple[0], \strLen($compilationPrefix)),
            $errorPattern, $tuple[1]);
    }
    return $errorMessage;
}

function _unprefixed(string $string, string $prefix): string {
    if (\str_starts_with($string, $prefix)) {
        return \subStr($string, \strLen($prefix));
    }
    return $string;
}
