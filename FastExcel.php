<?php

namespace App\Services\Excel\Exporter;

use App\Services\Excel\Exporter\Traits\Exportable;
use Rap2hpoutre\FastExcel\FastExcel as FastExcelFastExcel;

class FastExcel extends FastExcelFastExcel
{
    use Exportable;

    private bool $with_header = true;

    private bool $transpose = false;
}
