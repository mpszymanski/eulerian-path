<?php

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

    public function findStartPoint()
    {
        $firstOdd = null;
        $firstWithEdges = null;
        $oddCount = 0;

        for ($i = 0; $i < $this->graph->getVertexNumber(); $i++) {
            $edgesCount = $this->graph->getVertexEdges($i);

            if ($edgesCount % 2) { // If to many odd point, then we have no Euler's path
                if ($firstOdd === null) $firstOdd = $i; // Store first odd point
                if (++$oddCount > 2) return false;
            } elseif($edgesCount > 0 && $firstWithEdges === null) {
                $firstWithEdges = $i; // Store first point with edges
            }
        }

        // If we have odd point we will use it. Otherwise we will take first point with edges.
        return $firstOdd === null ? $firstWithEdges : $firstOdd;
    }

    public function findPath($startPoint)
    {
        $this->DFS($startPoint);

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
}
