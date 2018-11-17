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
