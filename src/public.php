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
