<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
class seedDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate DB, seed data and create an admin user';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        //db migrate
        $this->call('migrate:fresh');
        //seed fake data
        $this->call('db:seed');
        //create admin user
        $this->call('orchid:admin', [
            'name' => env('ADMIN_USER_NAME'),
            'email' => env('ADMIN_USER_EMAIL'),
            'password' => env('ADMIN_USER_PASSWORD')
        ]);
        return Command::SUCCESS;
    }
}
