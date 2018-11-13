<?php
/**
 * Created by PhpStorm.
 * User: szyman
 * Date: 11.11.18
 * Time: 16:05
 */

class GraphLoader
{
    public static function load($path): Graph
    {
        $graph = new Graph;

        // Open file
        $file = fopen($path, 'r');
        $lineNumber = 0;

        // Load header
        $header = fgets($file);
        $lineNumber++;
        list($vertexNumber) = explode(' ', $header);

        // Missing header with number of vertex and edges
        if (!isset($vertexNumber)) {
            throw new InvalidFileException($lineNumber);
        }

        // Set variables
        $graph->setVertexNumber((int) $vertexNumber);
        $graph->renderMatrix();

        // Load next lines
        while(!feof($file)) {
            $line = fgets($file);
            $lineNumber++;

            $data = explode(' ', $line);
            for ($i = 0; $i < count($data); $i += 2) {

                if (!isset($data[$i]) || !isset($data[$i+1])) {
                    throw new InvalidFileException($lineNumber);
                }

                $graph->addEdge((int) $data[$i], (int) $data[$i+1]);
            }
        }

        // Close file
        fclose($file);

        return $graph;
    }
}

class Graph
{
    private $matrix = [], $vertexNumber;

    public function getMatrix()
    {
        return $this->matrix;
    }

    public function getVertexNumber()
    {
        return $this->vertexNumber;
    }

    public function setVertexNumber(int $value)
    {
        $this->vertexNumber = $value;
    }

    public function renderMatrix()
    {
        $vertexNumber = $this->vertexNumber;

        for ($i = 0; $i < $vertexNumber; $i++) {
            $this->matrix[$i] = [];
            for ($j = 0; $j < $vertexNumber; $j++)  {
                $this->matrix[$i][$j] = 0;
            }
        }
    }

    public function addEdge(int $vertex1, int $vertex2)
    {
        $this->matrix[$vertex1][$vertex2] = 1;
        $this->matrix[$vertex2][$vertex1] = 1;
    }

    public function removeEdge(int $vertex1, int $vertex2)
    {
        $this->matrix[$vertex1][$vertex2] = 0;
        $this->matrix[$vertex2][$vertex1] = 0;
    }

    public function getVertexEdges(int $vertex)
    {
        $vertexMatrix = $this->matrix[$vertex];

        return array_reduce($vertexMatrix, function($count, $vertex) {
            return $count += $vertex;
        });
    }

    public function printMatrix()
    {
        $vertexNumber = $this->vertexNumber;

        for ($i = 0; $i < $vertexNumber; $i++) {
            echo "\n";
            for ($j = 0; $j < $vertexNumber; $j++)  {
                echo $this->matrix[$i][$j] . ' ';
            }
        }
        echo "\n";
    }
}

class EulerPathFinder
{
    private $graph;

    private $path = [];

    function __construct(Graph $graph)
    {
        $this->setGraph($graph);
    }

    public function setGraph(Graph $graph)
    {
        $this->graph = $graph;
    }

    public function hasPath()
    {
        $odd = 0;

        for ($i = 0; $i < $this->graph->getVertexNumber(); $i++)
            if($this->graph->getVertexEdges($i) % 2)
                $odd++;

        return $odd <= 2;
    }

    public function findPath()
    {
        // If odd vertex
        $vertex = $this->hasOddVertex();
        if ($vertex !== false) {
            $this->DFS($vertex);
        } else {
            $this->DFS(0);
        }

        return $this->path;
    }

    private function DFS($startVertex = 0)
    {
        $vertexNumber = $this->graph->getVertexNumber();

        for ($i = 0; $i < $vertexNumber; $i++) {
            $matrix = $this->graph->getMatrix();
            if ($matrix[$startVertex][$i]) {
                $this->graph->removeEdge($startVertex, $i);
                $this->DFS($i);
            }
        }

        $this->path[] = $startVertex;
    }

    private function hasOddVertex()
    {
        for ($i = 0; $i < $this->graph->getVertexNumber(); $i++) {
            if ($this->graph->getVertexEdges($i) % 2) {
                return $i;
            }
        }

        return false;
    }
}

class InvalidFileException extends Exception
{
    public function __construct(int $line = 0, int $code = 0, Throwable $previous = null)
    {
        $message = "File do not contain valid edges list. Error in line $line";
        parent::__construct($message, $code, $previous);
    }
}

try {
    $graph = GraphLoader::load('./graph');
    $pathFinder = new EulerPathFinder($graph);

    $graph->printMatrix();

    if ($pathFinder->hasPath()) {
        $path = $pathFinder->findPath();
        echo "Euler path: ";
        echo implode(' ', $path) . "\n";
    } else {
        echo "This graph has no Euler path";
    }

} catch(InvalidFileException $e) {
    print_r($e->getMessage());
}