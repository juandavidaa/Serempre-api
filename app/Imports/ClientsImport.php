<?php

namespace App\Imports;

use App\Models\Client;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ClientsImport implements
    ToModel,
    WithChunkReading,
    ShouldQueue,
    WithHeadingRow,
    WithValidation,
    WithBatchInserts
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row):Client
    {
        return new Client([
            'name' => $row['name'],
            'city_id' => $row['city_id']
        ]);
    }

    public function chunkSize(): int
    {
        return 100;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string'
            ],
            'city_id' => [
                'required',
                'exists:cities,id',
            ],
        ];
    }

    public function batchSize(): int
    {
        return 1000;
    }
}
