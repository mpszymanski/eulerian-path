<?php

class GraphLoader
{
    public static function load($path): Graph
    {
        $graph = new Graph;

        // Open file
        if (!file_exists($path)) {
          throw new Exception("File not found: $path");
        }
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
