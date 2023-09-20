<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;
class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a new Client
        echo Client::factory()->modelName();
        Client::factory()->count(500)->create();
    }
}
