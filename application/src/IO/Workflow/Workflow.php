<?php
namespace App\IO\Workflow;

use App\IO\Reader\ReaderInterface;
use App\IO\Writer\WriterInterface;

class Workflow {
    protected $reader;
    protected $writers = [];
    protected $preItemFilters;
    protected $postConversionItemFilters;
    protected $postMappingItemFilters;
    protected $itemConverters;
    protected $mappings;

    public function __construct(ReaderInterface $reader = null) {
        $this->reader = $reader;
    }

    public function addWriter(WriterInterface $writer) : self {
        $this->writers[] = $writer;

        return $this;
    }

    public function getWriters() : array {
        return $this->writers;
    }

    public function addPreItemFilters(FilterInterface $filter) : self {
        $this->preItemFilters[] = $filter;
        
        return $this;
    }

    public function getPreItemFilters() : array {
        return $this->preItemFilters;
    }

    public function addPostConversionItemFilters(FilterInterface $filter) : self {
        $this->postConversionItemFilters[] = $filter;
        
        return $this;
    }

    public function getPostConversionItemFilters() : array {
        return $this->postConversionItemFilters;
    }

    public function addPostMappingItemFilters(FilterInterface $filter) : self {
        $this->postMappingItemFilters[] = $filter;
        
        return $this;
    }

    public function getPostMappingItemFilters() : array {
        return $this->postMappingItemFilters;
    }

    public function addItemConverter(ItemConverterInterface $converter) : self {
        $this->itemConverters[] = $converter;
        
        return $this;
    }

    public function getItemConverters() : array {
        return $this->itemConverters;
    }

    public function addMapping($fromField, $toField, $mustExist = true) : self {
        $this->mappings[$fromField] = $toField;

        return $this;
    }

    public function getMappings() : array {
        return $this->mappings;
    }

    public function getMapping(string $fromField) {
        return isset($this->mappings[$fromField]) ? $this->mappings[$fromField] : null;
    }

    /**
     * Processes a workflow by reading items and then writing to writers
     * 
     * @return int Number of written items
     */
    public function process() {
        $count = 0;
        foreach ($this->writers as $writer) {
            $writer->prepare();
        }

        foreach ($this->reader as $item) {
            if ($this->filterItem($item, $this->preItemFilters) === false) {
                continue;
            }

            $convertedItem = $this->convertItem($item);
            if (!$convertedItem) {
                continue;
            }

            if ($this->filterItem($item, $this->postConversionItemFilters) === false) {
                continue;
            }

            $mapItem = $this->mapItem($item);
            if (!$mapItem) {
                continue;
            }

            if ($this->filterItem($item, $this->postMappingItemFilters) === false) {
                continue;
            }

            foreach ($this->writers as $writer) {
                $writer->writeItem($mapItem, $item);
            }

            $count++;
        }

        foreach ($this->writers as $writer) {
            $writer->finish();
        }

        return $count;
    }

    /**
     * Filters items from the final results
     * 
     * @return boolean Returns false if item is filtered
     */
    public function filterItem(array $item, array $filters) : boolean {
        foreach ($filters as $filter) {
            if ($filter->filter($item) === false) {
                return false;
            }
        }

        return true;
    }

    public function convertItem($item) : array {
        foreach ($this->itemConverters as $converter) {
            $item = $converter->convert($item);

            if (!$item) {
                return $item;
            }
        }

        return $item;
    }

    public function mapItem($item) : array {
        $mapItem = [];
        foreach ($item as $key => $value) {
            if (isset($this->mappings[$key])) {
                $mapItem[$this->mappings[$key]] = $value;
            } else {
                $mapItem[$key] = $value;
            }
        }


        return $mapItem;
    }



}