<?php

namespace App\Services\Excel\Exporter\Concerns;

use Generator;

interface WithHeaders
{
    public function headers(): array|Generator;
}
