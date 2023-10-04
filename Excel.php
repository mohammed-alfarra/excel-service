<?php

namespace App\Services\Excel\Exporter;

use App\Services\Excel\Exporter\Concerns\Exporter;
use App\Services\Excel\Exporter\Concerns\ExportStrategy;
use App\Services\Excel\Exporter\Concerns\WithHeaders;
use App\Services\Excel\Exporter\Concerns\WithMultipleSheetsExport;
use App\Services\Excel\Exporter\Strategies\MultipleSheetsExportStrategy;
use App\Services\Excel\Exporter\Strategies\SingleSheetExportStrategy;
use Generator;
use Rap2hpoutre\FastExcel\SheetCollection;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Excel
{
    public function __construct(
        private Exporter $exporter
    ) {
    }

    public function export(string $filename): string
    {
        $excel = $this->createExcel();

        return $excel->export($filename);
    }

    public function download(string $filename): StreamedResponse|string
    {
        $excel = $this->createExcel();

        return $excel->download($filename);
    }

    private function createExcel(): FastExcel
    {
        $exportStrategy = $this->resolveExportStrategy();

        $data = $exportStrategy->getData();

        $export = $this->createExportObject($data, $exportStrategy);

        $this->applyHeaders($export, $exportStrategy);

        return $export;
    }

    private function resolveExportStrategy(): ExportStrategy
    {
        if ($this->exporter instanceof WithMultipleSheetsExport) {
            return new MultipleSheetsExportStrategy($this->exporter);
        }

        return new SingleSheetExportStrategy($this->exporter);
    }

    private function createExportObject(Generator $data, ExportStrategy $exportStrategy): FastExcel
    {
        if ($exportStrategy instanceof MultipleSheetsExportStrategy) {
            return new FastExcel(new SheetCollection($data));
        }

        return new FastExcel($data);
    }

    private function applyHeaders(FastExcel $excel, ExportStrategy $exportStrategy): void
    {
        if ($this->exporter instanceof WithHeaders) {
            $headers = $exportStrategy->getHeaders();

            $excel->setHeader($headers);
        }
    }
}
