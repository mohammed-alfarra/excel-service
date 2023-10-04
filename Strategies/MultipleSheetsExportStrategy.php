<?php

namespace App\Services\Excel\Exporter\Strategies;

use App\Services\Excel\Exporter\Concerns\Exporter;
use App\Services\Excel\Exporter\Concerns\ExportStrategy;
use App\Services\Excel\Exporter\Concerns\WithHeaders;
use App\Services\Excel\Exporter\Concerns\WithMap;
use Generator;
use Illuminate\Support\LazyCollection;

class MultipleSheetsExportStrategy implements ExportStrategy
{
    public function __construct(
        private Exporter $exporter
    ) {
    }

    public function getHeaders(): array|Generator
    {
        if ($this->exporter instanceof WithHeaders) {
            return $this->exporter->headers();
        }
    }

    public function getData(): Generator
    {
        foreach ($this->groupData() as $key => $data) {
            yield $key => $this->getDataToExport($data);
        }
    }

    public function getDataToExport(mixed $data): mixed
    {
        if ($this->exporter instanceof WithMap) {
            return array_map([$this->exporter, 'rows'], $data);
        }

        return $data;
    }

    public function getSource(): LazyCollection
    {
        return $this->exporter
            ->data()
            ->cursor();
    }

    private function groupData(): Generator
    {
        $groupedData = [];

        foreach ($this->getSource() as $data) {
            $key = $data->{$this->exporter->groupKey()};

            if (! isset($groupedData[$key])) {
                $groupedData[$key] = [];
            }

            $groupedData[$key][] = $data;
        }

        yield from $groupedData;
    }
}
