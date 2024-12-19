<?php
namespace App\IO\Reader;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet;

class ExcelReader extends AbstractReader implements \SeekableIterator {

    protected $file;
    protected $headerRowIndex;
    protected $worksheetIndex;
    /** @var Spreadsheet $spreadsheet */
    protected $spreadsheet;
    /** @var Worksheet $worksheet */
    protected $worksheet;

    public function __construct(\SplFileObject $file, $headerRowIndex = null, $worksheetIndex = null) {
        $this->file = $file;
        $this->headerRowIndex = $headerRowIndex;
        $this->worksheetIndex = $worksheetIndex;
    }

    public function prepare() : AbstractReader {
        $this->spreadsheet = IOFactory::load($this->file->getPathname());

        if ($this->worksheetIndex !== null) {
            $this->spreadsheet->setActiveSheetIndex($this->worksheetIndex);
        }
        
        $this->worksheet = $this->spreadsheet->getActiveSheet();

        if ($this->headerRowIndex !== null) {
            $this->setHeaderRowNumber($this->headerRowIndex);
        }

        return $this;
    }

    public function current() : array {
        $row = iterator_to_array($this->worksheet->current()->getCellIterator());
        if (!empty($this->fieldsNames)) {
            return array_combine(array_values($row), array_intersect_key($row, $this->fieldsNames));
        }

        return $row;
    }

    public function next() {
        return $this->worksheet->getRowIterator()->next();
    }

    public function rewind() : AbstractReader {
        $this->worksheet->getRowIterator()->rewind();

        return $this;
    }

    public function key() {
        return $this->worksheet->getRowIterator()->key();
    }

    public function seek($position) {
        return $this->worksheet->getRowIterator()->seek($position);
    }

    public function valid() : bool {
        return $this->worksheet->getRowIterator()->valid();
    }

    public function finish() : AbstractReader {
        $this->worksheet = null;
        $this->spreadsheet = null;
        $this->file = null;

        return $this;
    }

    public function setHeaderRowNumber(int $rowNumber) : self {
        $this->headerRowIndex = $rowNumber;
        $this->fieldsNames = $this->readHeaderRow($rowNumber);
        
        return $this;
    }

    protected function readHeaderRow(int $rowNumber) : array {
        $this->seek($rowNumber);
        $headers = $this->file->current();
        
        return $headers;
    }
}