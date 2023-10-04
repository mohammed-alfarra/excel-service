<?php

namespace App\Services\Excel\Exporter\Concerns;

interface WithMap
{
    public function rows(mixed $row): array;
}
