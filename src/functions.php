<?php

function re_test(string $pattern, string $subject, string $modifiers = null): bool {
    return \preg_match("/$pattern/$modifiers", $subject);
}
