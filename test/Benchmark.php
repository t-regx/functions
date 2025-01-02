<?php
namespace Test;

use PHPUnit\Framework\Assert;

class Benchmark
{
    public static function run(int $iterations, callable $block): void {
        $values = \array_map(
            fn() => self::benchmarkSample($iterations, $block),
            range(1, 10));
        Assert::fail(
            "Avg: " . (array_sum($values) / count($values)) . "\n" .
            "Samples: " . var_export($values, true) . "\n",
        );
    }

    private static function benchmarkSample(int $iterations, callable $block): float {
        $start = \microTime(true);
        foreach (range(0, $iterations) as $_) {
            $block();
        }
        $end = \microTime(true);
        \usleep(1000 * 50);
        return $end - $start;
    }
}
