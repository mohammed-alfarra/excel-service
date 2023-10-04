<?php

namespace App\Services\Excel\Exporter\Concerns;

use Illuminate\Database\Eloquent\Builder;

interface Exporter
{
    public function data(): Builder;
}
