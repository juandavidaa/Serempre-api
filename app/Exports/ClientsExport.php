<?php

namespace App\Exports;

use App\Models\Client;

use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;


class ClientsExport implements FromQuery, WithHeadings, WithMapping, ShouldQueue
{
    use Exportable;

    public function query()
    {
        return Client::query();

    }

    public function headings(): array
    {
        return ['name', 'city_id'];
    }

    public function map($client): array
    {
        return [
            $client->name,
            $client->city_id
        ];
    }
}
