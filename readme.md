# adhocore/fsb

- f**king simple bench(marking) for php7

# usage

see [example.php](./example.php) for sample code.


# report

Sample of benchmark report given below:

```
-------------------------------------
-- strict compare vs loose compare --
--     Total Iterations 10000      --
-------------------------------------

Benchmarking: strict compare ...
  Time (s)        0.0071568489074707
  Memory (kb)     0.8828125
  RealMemory (kb) 0
  PeakMemory (kb) 528.4453125

Benchmarking: loose compare ...
  Time (s)        0.0072379112243652
  Memory (kb)     0.390625
  RealMemory (kb) 0
  PeakMemory (kb) 528.4453125

Total Time (s)        0.01452898979187
Total Memory (kb)     2.40625
Total RealMemory (kb) 0
Total PeakMemory (kb) 528.4453125

Verdict
  Fastest          strict compare @ 0.0071568489074707
  Slowest          loose compare @ 0.0072379112243652
  Least Memory     loose compare @ 0.390625
  Most Memory      strict compare @ 0.8828125
  Least RealMemory loose compare @ 0
  Most RealMemory  strict compare @ 0
  Least PeakMemory loose compare @ 528.4453125
  Most PeakMemory  strict compare @ 528.4453125

Powered by FSB <https://github.com/adhocore/fsb>
```
