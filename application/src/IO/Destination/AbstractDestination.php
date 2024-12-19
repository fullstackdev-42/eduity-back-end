<?php
namespace App\IO\Destination;

abstract class AbstractDestination implements DestinationInterface {
    protected $sourcePath;
    protected $destinationPath;
    protected $destinationFilename;
    protected $isFinished = false;
    protected $files = [];
    protected $filesProcessed = 0;

    public function __construct(string $destinationPath, string $destinationFilename) {
        $this->destinationPath = ($destinationPath[strlen($destinationPath) - 1] == "/")
            ? substr($destinationPath, 0, -1)
            : $destinationPath;
        
        $this->destinationFilename = $destinationFilename;
    }

    public function getDestinationFullPath() : string {
        return $this->destinationPath."/".$this->destinationFilename;
    }

    public function getDestinationPath() : string {
        return $this->destinationPath;
    }

    public function getDestinationFilename() : string {
        return $this->destinationFilename;
    }

    public function getFiles() : array {
        return $this->files;
    }

    public function addFile(string $sourcePath, string $fileOutputName) : self {
        $files[] = ['sourcePath' => $sourcePath, 'fileOutputName' => $fileOutputName];

        return $this;
    }

    abstract function write();
}