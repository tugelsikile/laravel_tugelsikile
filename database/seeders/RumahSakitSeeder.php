<?php

namespace Database\Seeders;

use App\Models\RumahSakit;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class RumahSakitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        $this->command->getOutput()->progressStart(10);
        for ($i = 1; $i <= 10; $i++) {
            $rumkit = new RumahSakit();
            $rumkit->code = Str::random(6);
            $rumkit->address = $faker->address;
            $rumkit->name = $faker->company;
            $rumkit->email = $faker->email;
            $rumkit->telp = $faker->phoneNumber;
            $rumkit->saveOrFail();
            $this->command->getOutput()->progressAdvance(1);
        }
        $this->command->getOutput()->progressFinish();
    }
}
