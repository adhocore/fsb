<?php

namespace Ahc\Fsb;

/**
 * F**king simple bench. See example.php in the root folder.
 *
 * For benchmarking, you know!
 *
 * @license WTFPL
 * @author  Jitendra Adhikari <jiten.adhikary@gmail.com>
 */
class Bench
{
    protected $iter  = 1000;
    protected $title = 'FSB';
    protected $data  = [];

    const METRICS = [
        'time'        => ['Time (s)', 'Fastest', 'Slowest'],
        'memory'      => ['Memory (kb)', 'Least Memory', 'Most Memory'],
        'memory.real' => ['RealMemory (kb)', 'Least RealMemory', 'Most RealMemory'],
        'memory.peak' => ['PeakMemory (kb)', 'Least PeakMemory', 'Most PeakMemory'],
    ];

    public function title(string $title)
    {
        $this->title = $title;

        return $this;
    }

    public function iter(int $iter)
    {
        $this->iter = max($iter, 1);

        return $this;
    }

    public function data(...$data)
    {
        $this->data = $data;

        return $this;
    }

    public function run(callable ...$fns)
    {
        $final = static::stat();
        $dash  = str_pad('-', strlen($this->title) + 6, '-');

        echo "{$dash}\n-- {$this->title} --\n-- ";
        echo str_pad("Total Iterations {$this->iter}", strlen($this->title), ' ', STR_PAD_BOTH);
        echo " --\n{$dash}\n\n";

        // Grab each fn title.
        if (substr_count($title = str_ireplace(' vs ', ' | ', $this->title), ' | ') >= count($fns) - 1) {
            $titles = explode(' | ', $title);
        }

        $stat = [];
        foreach ($fns as $i => $fn) {
            $title = $titles[$i] ?? 'fn #' . ($i + 1);
            echo "Benchmarking: {$title} ...\n";

            $iter         = $this->iter;
            $stat[$title] = static::stat();

            ob_start();
            while ($iter--) {
                $fn(...$this->data);
            }

            ob_end_clean();
            static::report($stat[$title]);
        }

        static::report($final, 'Total ');

        echo "Verdict\n";
        static::verdict($stat);
    }

    private static function verdict(array $stat, string $pad = '  ')
    {
        $metrics    = static::METRICS;
        $labelWidth = max(array_map('strlen', array_merge(...array_values($metrics))));

        foreach ($metrics as $key => $labels) {
            uasort($stat, function ($a, $b) use ($key) {
                return $a[$key] <=> $b[$key];
            });

            foreach (array_slice($labels, 1) as $index => $label) {
                $index ? end($stat) : reset($stat);
                $fnName = key($stat);
                $label  = str_pad($label, $labelWidth);
                echo "{$pad}{$label} {$fnName} @ {$stat[key($stat)][$key]}\n";
            }
        }

        echo "\nPowered by FSB <https://github.com/adhocore/fsb>\n\n";
    }

    private static function stat() : array
    {
        return [
            'time'        => microtime(true),
            'memory'      => memory_get_usage(),
            'memory.real' => memory_get_usage(true),
            'memory.peak' => memory_get_peak_usage(),
        ];
    }

    private static function report(array &$stat, string $pad = '  ')
    {
        $current = static::stat();

        foreach ($stat as $key => &$value) {
            if ($key !== 'memory.peak') {
                $value = $current[$key] - $value;
            }
            $value = $key === 'time' ? $value : $value / 1024;
            $label = str_pad(static::METRICS[$key][0], 16);

            echo "{$pad}{$label}{$value}\n";
        }

        echo "\n";
    }
}
