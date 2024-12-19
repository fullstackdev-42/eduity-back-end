<?php
namespace App\IO\Reader;

use App\IO\Strategy\StrategyInterface;

use Doctrine\Common\Collections\ArrayCollection;

class StrategyReader extends AbstractReader {

    protected $strategy;
    protected $data;
    protected $isIterator;

    public function __construct(StrategyInterface $strategy, array $data) {
        $this->strategy = $strategy;
        $this->data = $data;

        if (!($this->data instanceof ArrayCollection || $this->data instanceof \Iterator)) {
            throw new \Exception('Strategy data must be an ArrayCollection or Iterator');
        } elseif ($this->data instanceof \Iterator) {
            $this->isIterator = true;
        }

    }

    public function prepare() : self {
        return $this;
    }

    public function next() {
        return $this->data->next();
    }

    public function rewind() : self {
        if ($this->isIterator) {
            $this->data->rewind();
        } else {
            $this->data->first();
        }
        
        return $this;
    }

    public function valid() : bool {
        if ($this->isIterator) {
            return $this->data->valid();
        } else {
            $this->data->containsKey($this->key());
        }
    }

    public function key() {
        return $this->data->key();
    }

    public function count() : int {
        return $this->data->count();
    }

    public function current() : array {
        $c = $this->data->current();
        if (is_object($c)) {
            return $this->strategy->setObject($c)->toArray();
        } elseif (!is_array($c)) {
            return [$c];
        } else {
            return $c;
        }
    }

}