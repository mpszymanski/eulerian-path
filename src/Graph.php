<?php

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
