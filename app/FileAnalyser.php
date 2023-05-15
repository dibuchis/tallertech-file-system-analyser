<?php

include_once 'FileAnalyserInterface.php';

/**
 * 
 * FileAnalyser Class
 * 
 */
class FileAnalyser implements FileAnalyserInterface{

    private $directory;
    private $totalFiles;
    private $totalDirectories;
    private $totalFilesSize;
    private $fileSizes = array();
    private $fileNames = array();
    private $largestFile;
    private $smallestFile;
    private $averageFilesSize;

    public function __construct(){
    }

    public function runAnalysis(string $parentPath){

        if(!is_dir($parentPath)){
            throw new ErrorException("The path is not a directory");
            return;
        }
        
        $this->directory = $parentPath;
        
        $files = scandir($parentPath);

        foreach($files as $file){
            
            if($file == '.' || $file == '..'){
                continue;
            }

            if(is_file($parentPath."/".$file)){
                $this->countFiles();
                array_push($this->fileSizes, filesize($parentPath."/".$file));
                array_push($this->fileNames, $parentPath."/".$file);
                $this->sumTotalFilesSize(filesize($parentPath."/".$file));
            }

            if(is_dir($parentPath."/".$file)){
                $this->runAnalysis($parentPath."/".$file);
                $this->countDirectories();
            }
        }
    }

    public function printResults(){
        echo 'Directory:' . $this->directory . PHP_EOL;
        echo "Total files analyzed: " . $this->totalFiles . PHP_EOL;
        echo "Total directories analyzed: " . $this->totalDirectories . PHP_EOL;
        echo "Total files size: " . $this->totalFilesSize . " bytes" . PHP_EOL;
        $this->calculateLargestFile();
        echo "Largest file: " . $this->largestFile . " bytes" . PHP_EOL;
        $this->calculateSmaletsFile();
        echo "Smallest file: " . $this->smallestFile . " bytes" . PHP_EOL;
        $this->calculateAverageFileSize();
        printf("Average file size: %.2f bytes \n", $this->averageFilesSize);
    }
    
    public function countFiles(){
        $this->totalFiles++;
    }

    public function countDirectories(){
        $this->totalDirectories++;
    }

    public function sumTotalFilesSize($sizeFile){
        $this->totalFilesSize += $sizeFile;
    }

    public function calculateLargestFile(){
        $this->largestFile = max($this->fileSizes);
    }

    public function calculateSmaletsFile(){
        $this->smallestFile = min($this->fileSizes);
    }

    public function calculateAverageFileSize(){
        $average = $this->totalFilesSize / $this->totalFiles;
        $this->averageFilesSize = $average;
    }

}