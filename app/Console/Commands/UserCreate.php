<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class UserCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:user-create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $username = $this->ask('Username?');
        $password = $this->ask('Password?');
        $email = $this->ask('email?');

        $user = new User();
        $user->uuid = Str::uuid();
        $user->name = $username;
        $user->email = $email;
        $user->password = bcrypt($password);
        $user->save();
    }
}
