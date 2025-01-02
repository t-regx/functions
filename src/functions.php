<?php

use Regex\MalformedRegex;

function re_test(string $pattern, string $subject, string $modifiers = null): bool {
    $pregMatch = \preg_match("/$pattern/$modifiers", $subject);
    $error = \error_get_last();
    if ($error) {
        $message = $error['message'];
        $prefix = 'preg_match(): Compilation failed: ';
        if (str_starts_with($message, $prefix)) {
            throw new MalformedRegex(\subStr($message, \strLen($prefix)));
        }
    }
    return $pregMatch;
}
