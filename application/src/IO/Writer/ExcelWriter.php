<?php
namespace App\IO\Writer;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use App\IO\Destination\DestinationInterface;

class ExcelWriter extends AbstractWriter {

    protected $destination;
    protected $filename;
    protected $templatePath;
    protected $headerRowIndex;
    protected $startRowIndex;
    protected $worksheetIndex;
    protected $multisheet;
    protected $fileExt;

    /** @var Spreadsheet $spreadsheet */
    protected $spreadsheet;
    /** @var Worksheet $worksheet */
    protected $worksheet;

    protected $tempfile;
    protected $fields = [];
    protected $currentRow = 0;

    public function __construct(DestinationInterface $destination, string $filename, string $templatePath, 
        int $headerRowIndex = null, int $startRowIndex = 0, int $worksheetIndex = null, bool $multiSheet = false) {
        $this->destination = $destination;
        $this->filename = $filename;
        $this->templatePath = $templatePath;
        $this->headerRowIndex = $headerRowIndex;
        $this->startRowIndex = $startRowIndex;
        $this->worksheetIndex = $worksheetIndex;
        $this->multisheet = $multiSheet;

        preg_match('/^.+\.(\w+)$/', $this->filename, $matches);
        $this->fileExt = isset($matches[1]) ? $matches[1] : '';

        $this->tempfile = '/tmp/'. sha1(time() . rand(11111,99999)) . $this->fileExt;
    }

    public function prepare() : self {
        $this->spreadsheet = IOFactory::load($this->file->getPathname());

        if ($this->worksheetIndex !== null) {
            $this->spreadsheet->setActiveSheetIndex($this->worksheetIndex);
        }
        
        $this->worksheet = $this->spreadsheet->getActiveSheet();

        if ($this->headerRowIndex !== null) {
            $row = iterator_to_array($this->worksheet->seek($this->headerRowIndex)->getCellIterator());
            $this->fields = array_map([$this, 'normalizeFieldName'], array_values($row));
        }

        $this->destination->prepare();

        return $this;
    }

    public function writeItem(array $item, array $originalItem) : self {
        foreach ($item as $field => $val) {
            if (is_integer($field)) {
                $this->writeValueToCell($field, $this->currentRow, $val);
            } else {
                $columnIndexs = array_keys($this->fields, $this->normalizeFieldName($field));
                foreach ($columnIndexs as $colIndex) {
                    $this->writeValueToCell($colIndex, $this->currentRow, $val);
                }
            }
        }

        $this->currentRow++;

        return $this;
    }

    public function finish() : AbstractWriter {
        $excelWriter = IOFactory::createFactory($this->spreadsheet, $this->fileExt);

        $excelWriter->save($this->tempfile);

        //if not processing a multisheet, then go ahead and add to the desination
        if (!$this->multisheet && $this->currentRow > 0) {
            $this->destination->addFile($this->tempfile, $this->filename);
        }

        $this->worksheet = null;
        $this->spreadsheet = null;

        return $this;
    }

    public function getTempfileName() : string {
        return $this->tempfile;
    }

    public function normalizeFieldName(string $fieldName) : string {
        return preg_match('/\s+/', ' ', strtolower(trim($fieldName)));
    }

    protected function writeValueToCell($index, $row, $val, DataType $dataType = DataType::TYPE_STRING) {
        if (is_array($val)) {
            $val = trim(implode('; ', $val), " ;\n");
        }

        $this->worksheet->setCellValueExplicitByColumnAndRow($index, $row, $val, $dataType);
    }

}