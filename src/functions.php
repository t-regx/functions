<?php

use Regex\MalformedRegex;

function re_test(string $pattern, string $subject, string $modifiers = null): bool {
    $pregMatch = \preg_match("/$pattern/$modifiers", $subject);
    $error = \error_get_last();
    if ($error) {
        [$message, $offset] = \explode(' at offset ', $error['message']);
        $prefix = 'preg_match(): Compilation failed: ';
        if (\str_starts_with($message, $prefix)) {
            $errorMessage = \subStr($message, \strLen($prefix));
            $caret = \str_repeat(' ', $offset) . '^';
            throw new MalformedRegex($errorMessage . "\n\n" . $pattern . "\n" . $caret . "\n");
        }
    }
    return $pregMatch;
}
