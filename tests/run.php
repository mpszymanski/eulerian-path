<?php

require 'src/Graph.php';
require 'src/GraphLoader.php';
require 'src/EulerPathFinder.php';
require 'src/exceptions/InvalidFileException.php';

function callback($path) {
  $graph = GraphLoader::load($path);
  $pathFinder = new EulerPathFinder($graph);

  $startPoint = $pathFinder->findStartPoint();
  if ($startPoint !== false) {
      return $pathFinder->findPath($startPoint);
  } else {
      return null;
  }
}

$tests = [
    'graphs/graph1' => [0, 5, 4, 2, 5, 1, 3, 2, 1, 4, 0],
    'graphs/graph2' => [4, 3, 2, 0, 1, 3],
    'graphs/graph3' => [1, 4, 9, 7, 11, 5, 7, 6, 4, 7, 2, 5, 4, 2, 1],
    'graphs/graph4' => [3, 2, 7, 11, 5, 10, 9, 7, 4, 9, 6, 4, 5, 2, 4, 1, 0],
    'graphs/graph5' => null,
    'graphs/graph6' => [4, 5, 2, 3, 4, 1, 5, 0, 1, 2],
    'graphs/graph7' => [1, 6, 7, 8, 4, 6, 5, 4, 7, 3, 5, 2, 3, 4, 1],
    'graphs/graph8' => [7, 8, 5, 7, 6, 4, 7, 2, 8, 1, 6, 0, 1, 4],
    'graphs/graph9' => [0, 3, 7, 8, 5, 7, 4, 6, 3, 4, 5, 2, 4, 1, 3, 2, 1, 0],
    'graphs/graph10' => null
];

foreach ($tests as $path => $expected) {
  try {
      if(callback($path) === $expected) {
          echo "\033[0;32m [OK] Test for $path\033[0m\n";
      } else {
          echo "\e[0;31m [FAIL] Test for $path\e[0m\n";
      }
  } catch(Exception $e) {
      echo $e->getMessage() . "\n";
  }
}
