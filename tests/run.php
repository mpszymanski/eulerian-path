<?php

require 'src/Graph.php';
require 'src/GraphLoader.php';
require 'src/EulerPathFinder.php';
require 'src/exceptions/InvalidFileException.php';

function callback($path) {
  $graph = GraphLoader::load($path);
  $pathFinder = new EulerPathFinder($graph);

  if ($pathFinder->hasPath()) {
      return $pathFinder->findPath();
  } else {
      return null;
  }
}

$tests = [
  'graphs/graph' => [0, 5, 4, 2, 5, 1, 3, 2, 1, 4, 0],
  'graphs/graph2' => [4, 3, 2, 0, 1, 3],
];

foreach ($tests as $path => $expected) {
  try {
      if(callback($path) === $expected) {
        echo "Test for $path is succesfull!\n";
      } else {
        echo "Test for $path is failed!\n";
      }
  } catch(Exception $e) {
      echo $e->getMessage() . "\n";
  }
}
