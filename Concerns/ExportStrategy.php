<?php

namespace App\Services\Excel\Exporter\Concerns;

use Generator;
use Illuminate\Support\LazyCollection;

interface ExportStrategy
{
    public function getData(): Generator;

    public function getHeaders(): array|Generator;

    public function getDataToExport(mixed $data): mixed;

    public function getSource(): LazyCollection;
}
