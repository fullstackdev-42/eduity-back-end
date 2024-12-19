<?php
namespace App\IO\Reader;

class CSVReader extends AbstractReader implements \SeekableIterator {

    protected $headerRowNumber;
    protected $file;
    
    public function __construct(\SplFileObject $file, $delimiter = ',', $enclosure= '"', $escape= '\\') {
        $this->file = $file;
        $this->file->setFlags(
            \SplFileObject::READ_CSV |
            \SplFileObject::SKIP_EMPTY |
            \SplFileObject::READ_AHEAD |
            \SplFileObject::DROP_NEW_LINE
        );
        $this->file->setCsvControl($delimiter, $enclosure, $escape);
    }

    public function prepare() : self {
        return $this;
    }
    
    public function current() : array {
        $row = $this->file->current();
        if (!empty($this->fieldsNames)) {
            if (count($row) === count($this->fieldsNames)) {
                //our row length should match the length of headers, otherwise data will be  misinterpreted! 
                return array_combine(array_values($this->fieldsNames), $row);
            } else {
                //skip row and log an error for reporting
                $this->errors[$this->key()] = $row;
                $this->next();
                return $this->current();
            }
        } else {
            return $row;
        }
    }

    public function next() {
        return $this->file->next();
    }

    public function rewind() : self {
        $this->file->rewind();

        return $this;
    }

    public function valid() : bool {
        return $this->file->valid();
    }

    public function key() {
        return $this->file->key();
    }

    public function seek($position) {
        return $this->file->seek($position);
    }

    public function setHeaderRowNumber($rowNumber) : self
    {
        $this->headerRowNumber = $rowNumber;
        $this->fieldsNames = $this->readHeaderRow($rowNumber);
        
        return $this;
    }

    protected function readHeaderRow(int $rowNumber) : array
    {
        $this->seek($rowNumber);
        $headers = $this->file->current();
        
        return $headers;
    }

    public function finish() : AbstractReader {
        $this->file = null;

        return $this;
    }

}
