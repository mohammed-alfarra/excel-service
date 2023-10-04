<?php

namespace App\Exports;

use App\Services\Excel\Exporter\Concerns\Exporter;
use App\Services\Excel\Exporter\Concerns\WithHeaders;
use App\Services\Excel\Exporter\Concerns\WithMap;
use Generator;
use Illuminate\Database\Eloquent\Builder;

class ExportClass implements Exporter, WithMap, WithHeaders
{
    public function __construct(
        private Builder $data
    ) {
    }

    public function data(): Builder
    {
        return $this->data;
    }

    public function rows(mixed $row): array
    {
        return [
            $row->scheduled_inspection_name,
            $row->user_full_data,
            $row->location_name,
            $row->location_code,
            trans('inspection.'.$row->status),
            $row->form_data_points,
            $row->form_data_min_points,
            $row->score,
            $row->is_success ? trans('general.boolean.yes') : trans('general.boolean.no'),
            $row->comment,
        ];
    }

    public function headers(): array|Generator
    {
        return [
            'Inspection Name',
            'User Name',
            'Location Name',
            'Location Code',
            'Status',
            'Points',
            'Min Points',
            'Score',
            'IS Success',
            'Comment',
        ];
    }
}
