<?php

namespace App\Services\Excel\Exporter\Strategies;

use App\Services\Excel\Exporter\Concerns\Exporter;
use App\Services\Excel\Exporter\Concerns\ExportStrategy;
use App\Services\Excel\Exporter\Concerns\WithHeaders;
use App\Services\Excel\Exporter\Concerns\WithMap;
use Generator;
use Illuminate\Support\LazyCollection;

class SingleSheetExportStrategy implements ExportStrategy
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
        foreach ($this->getSource() as $data) {
            yield $this->getDataToExport($data);
        }
    }

    public function getDataToExport(mixed $data): mixed
    {
        if ($this->exporter instanceof WithMap) {
            return $this->exporter->rows($data);
        }

        return $data;
    }

    public function getSource(): LazyCollection
    {
        return $this->exporter
            ->data()
            ->cursor();
    }
}
