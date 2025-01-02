<p align="center"><img src=".github/assets/t.regx.png" alt="T-Regx"></p>

<p align="center">
    <a href="https://github.com/t-regx/functions/actions/">
        <img src="https://github.com/t-regx/functions/workflows/build/badge.svg" alt="Build status"/>
    </a>
</p>

# Regex | Set of function helpers

![PHP Version](https://img.shields.io/badge/PHP-8.2-blue.svg)
![PHP Version](https://img.shields.io/badge/PHP-8.3-blue.svg)
![PHP Version](https://img.shields.io/badge/PHP-8.4-blue.svg)

A set of helper functions with modern interface for built-in PHP `preg_` functions. Revamped approach, all the goodies
extracted from [T-Regx](https://github.com/T-Regx/T-Regx) library, waste removed.

[Buy me a coffee!](https://www.buymeacoffee.com/danielwilkowski)

## Examples

Testing string subject against regex pattern:
```php
re_test('[a-z]+', 'word');
// bool (true)

re_test('[a-z]+', 'WORD', modifiers:'i');
// bool (true)
```

Helpful error message for syntax errors in regex patterns:
```php
try {
    re_test('[a-z', 'word');
} catch (\Regex\MalformedRegex $exception) {
    // 'missing terminating ] for character class'
}
```

Exceptions with positions of syntax errors in the pattern:
```php
re_test('(Foo:[a-z]))\w+', 'word');
```
```
Regex\MalformedRegex: unmatched closing parenthesis

(Foo:[a-z]))\w+
           ^
```
