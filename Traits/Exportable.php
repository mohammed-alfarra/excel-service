<?php

namespace App\Services\Excel\Exporter\Traits;

use InvalidArgumentException;
use OpenSpout\Common\Entity\Row;
use Rap2hpoutre\FastExcel\Exportable as FastExcelExportable;

trait Exportable
{
    use FastExcelExportable;

    private $withHeader = false;

    private $headers;

    public function setHeader($headers)
    {
        $this->withHeader = true;

        $this->headers = $headers;

        return $this;
    }

    protected function writeHeader($writer, $first_row)
    {
        if (null === $first_row) {
            return;
        }

        $keys = $this->getHeaderKeys($first_row);

        // TODO
        // $this->checkRowCountMatchesHeaderCount($first_row, $keys);

        $writer->addRow(Row::fromValues($keys, $this->header_style));
    }

    private function getHeaderKeys($row): array
    {
        if (!$this->withHeader) {
            return $this->getDefaultHeaderKeys($row);
        }
    
        return $this->getCustomHeaderKeys();
    }
    
    private function getDefaultHeaderKeys($row): array
    {
        return array_keys(is_array($row) ? $row : $row->toArray());
    }
    
    private function getCustomHeaderKeys(): array
    {
        return array_values(is_array($this->headers) ? $this->headers : $this->headers->toArray());
    }

    private function checkRowCountMatchesHeaderCount($row, $keys)
    {
        if (count($row) !== count($keys)) {
            throw new InvalidArgumentException('Headers should match rows number');
        }
    }
}
