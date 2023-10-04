<?php

use App\Exports\ExportClass;
use App\Services\Excel\Exporter\Excel;

$exportClass = new ExportClass($data);

return (new Excel($exportClass))->export($filename);