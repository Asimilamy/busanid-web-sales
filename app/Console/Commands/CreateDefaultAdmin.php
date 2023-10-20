<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateDefaultAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:user-admin {email=admin@admin.com} {password=password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create default user for admin';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        $this->info('Start create default admin on users table');
        $this->newLine();
        if ($this->confirm('Email: ' . $email . ' | Password: ' . $password . ', continue?')) {
            $model = new User();
            $model->fill([
                'name' => $email,
                'email' => $email,
                'password' => Hash::make($password)
            ]);
            $model->save();
        }
        $this->newLine();
        $this->info('Successfully create admin!');

        return Command::SUCCESS;
    }
}
