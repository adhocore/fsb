<?php

/*
 * This file is part of the FSB package.
 *
 * (c) Jitendra Adhikari <jiten.adhikary@gmail.com>
 *     <https//:github.com/adhocore>
 *
 * Licensed under MIT license.
 */

use Ahc\Fsb\Bench;

require_once __DIR__ . '/src/Bench.php';

(new Bench)
// Set title: separate the benchmark functions with ` vs ` or ` | `.
->title('closure.strict | closure.loose | Compare->strict | Compare->loose | Compare::strict | Compare::loose')
// Number of iterations.
->iter(10000)
// Set the common input data for benchmarks.
// The data will be available to benchmarked functions in the order they are set here.
->data('1st', '2nd' /*, 3rd... */)
// Benchmark all the callables!
->run(
    // As closure.
    function ($first, $second /*, $third... */) {
        echo $first === $second;
    },
    function ($first, $second) {
        echo $first == $second;
    },

    // As instance method
    [new Compare, 'strict'],
    [new Compare, 'loose'],

    // As static method
    ['Compare', 'strict'],
    ['Compare', 'loose']

    // Add another callable (and append to title above)...
);

class Compare
{
    public function strict($first, $second)
    {
        echo $first === $second;
    }

    public function loose($first, $second)
    {
        echo $first == $second;
    }
}
