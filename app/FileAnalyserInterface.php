<?php

//Create an Interface based on the FileAnalyser.php file
interface FileAnalyserInterface
{
    public function runAnalysis(string $parentPath);

    public function printResults();
}