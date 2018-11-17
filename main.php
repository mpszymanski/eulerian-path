<?php
/**
 * Created by PhpStorm.
 * User: szyman
 * Date: 11.11.18
 * Time: 16:05
 */

require 'src/Graph.php';
require 'src/GraphLoader.php';
require 'src/EulerPathFinder.php';
require 'src/exceptions/InvalidFileException.php';

try {
    $graph = GraphLoader::load('./graphs/graph2');
    $pathFinder = new EulerPathFinder($graph);

    $graph->printMatrix();

    if ($pathFinder->hasPath()) {
        $path = $pathFinder->findPath();
        echo "Euler path: ";
        echo implode(' ', $path) . "\n";
    } else {
        echo "This graph has no Euler path";
    }

} catch(Exception $e) {
    echo $e->getMessage() . "\n";
}
