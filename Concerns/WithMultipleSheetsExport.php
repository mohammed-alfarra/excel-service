<?php

namespace App\Services\Excel\Exporter\Concerns;

interface WithMultipleSheetsExport
{
    public function groupKey(): string;
}
