<?php
namespace App\IO\Destination;

class ZipDestination extends AbstractDestination {
    protected $zipFile;

    public function write() {
        if (!$this->isFinished) {
            $this->zipFile = new \ZipArchive();
            $this->zipFile->open($this->getDestinationFullPath(),  \ZipArchive::CREATE);

            foreach ($this->files as $file) {
                if ($this->zipFile->locateName($file['fileOutputName']) === false) {
                    $this->zipFile->addFile($file['sourcePath'], $file['fileOutputName']);
                    $this->filesProcessed++;
                }

                //max files in a zip should be capped at 255
                if ($this->filesProcessed % 255 == 0) {
                    $this->zipFile->close();

                    $this->zipFile = new \ZipArchive();
                    $this->zipFile->open($this->getDestinationFullPath(),  \ZipArchive::CREATE);
                }

            }

            $this->isFinished = true;
        }
    }
}