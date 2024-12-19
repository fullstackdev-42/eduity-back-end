<?php
namespace App\IO\Destination;

interface DestinationInterface {
    public function addFile(string $sourcePath, string $fileOutputName);
    public function getFiles() : array;
    public function write();
    public function getDestinationFullPath() : string;
    public function getDestinationPath() : string;
    public function getDestinationFilename() : string;
}