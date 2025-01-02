<?php

use Regex\MalformedRegex;

function re_test(string $pattern, string $subject, string $modifiers = null): bool {
    $delimiter = \str_contains($pattern, '/') ? "\1" : '/';
    $pregMatch = \preg_match($delimiter . $pattern . $delimiter . $modifiers, $subject);
    $error = \error_get_last();
    if ($error) {
        [$message, $offset] = \explode(' at offset ', $error['message']);
        $compilationPrefix = 'preg_match(): Compilation failed: ';
        if (\str_starts_with($message, $compilationPrefix)) {
            $errorMessage = \subStr($message, \strLen($compilationPrefix));
            $caret = \str_repeat(' ', $offset) . '^';
            throw new MalformedRegex($errorMessage . "\n\n" . $pattern . "\n" . $caret . "\n");
        }
        $prefix = 'preg_match(): ';
        if (\str_starts_with($message, $prefix)) {
            throw new MalformedRegex(\subStr($message, \strLen($prefix)));
        }
        throw new MalformedRegex($error['message']);
    }
    return $pregMatch;
}
