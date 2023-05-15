<?php

require_once 'app/FileAnalyser.php';

$analyser = new FileAnalyser();

$analyser->runAnalysis(__DIR__ . '/testFolder');
$analyser->printResults();