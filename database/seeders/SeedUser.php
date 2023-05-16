<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SeedUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dumps = collect();
        $dumps->push((object)[
            'username' => 'admin', 'password' => 'password', 'name' => 'admin'
        ]);
        $this->command->getOutput()->progressStart($dumps->count());
        foreach ($dumps as $dump) {
            $user = User::where('username', $dump->username)->first();
            if ($user == null) {
                $user = new User();
                $user->name = $dump->name;
                $user->username = $dump->username;
                $user->password = Hash::make($dump->password);
                $user->saveOrFail();
            }
            $this->command->getOutput()->progressAdvance();
        }
        $this->command->getOutput()->progressFinish();
    }
}
