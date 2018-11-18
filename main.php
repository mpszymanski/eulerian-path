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

$path = readline("Path to graph: ");

try {
    $graph = GraphLoader::load($path);
    $pathFinder = new EulerPathFinder($graph);

    $graph->printMatrix();

    $startPoint = $pathFinder->findStartPoint();

    if ($startPoint !== null) {
        $path = $pathFinder->findPath($startPoint);
        if ($path) {
            echo "Euler path: ";
            echo implode(' ', $path) . "\n";
            return;
        }
    }

    echo "This graph has no Euler path";
    return;

} catch(Exception $e) {
    echo $e->getMessage() . "\n";
}
