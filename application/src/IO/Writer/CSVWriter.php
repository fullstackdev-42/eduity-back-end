<?php
namespace App\IO\Writer;

class CSVWriter extends AbstractWriter {

    protected $headerRowNumber;
    protected $file;
    protected $columnHeaders;
    protected $count;
    

    public function __construct(\SplFileObject $file, $delimiter = ',', $enclosure= '"', $escape= '\\')
    {
        $this->file = $file;
        $this->file->setCsvControl($delimiter, $enclosure, $escape);
    }

    public function getColumnHeaders() : array {
        return $this->columnHeaders;
    }

    public function setColumnHeaders($columnHeaders) : self {
        $this->columnHeaders = $columnHeaders;

        return $this;
    }

    public function prepare() : self {
        if (!empty($this->columnHeaders)) {
            $this->file->fputcsv($this->columnHeaders);
        }

        return $this;
    }

    public function writeItem($item, $originalItem) : self {
        foreach ($item as $row) {
            if (!empty($this->columnHeaders)) {
                if (count($row) === count($this->columnHeaders)) {
                    //our row length should match the length of headers, otherwise data will be  misinterpreted! 
                    $this->file->fputcsv($row);
                } else {
                    //skip row and log an error for reporting
                    $this->errors[] = $row;
                    continue;
                }
            } else {
                $this->file->fputcsv($row);
            }
        }

        return $this;
    }

    public function finish() : AbstractWriter {
        $this->file = null;

        return $this;
    }

}