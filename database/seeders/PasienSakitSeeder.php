<?php

namespace Database\Seeders;

use App\Models\Pasien;
use App\Models\RumahSakit;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class PasienSakitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        $this->command->getOutput()->progressStart(100);
        $rumkits = RumahSakit::orderBy('name', 'asc')->get('id')->map(function ($d) { return $d->id; })->toArray();

        for ($i = 1; $i <= 100; $i++) {
            $pasien = new Pasien();
            $pasien->rumah_sakit = $faker->randomElement($rumkits);
            $pasien->address = $faker->address;
            $pasien->name = $faker->name;
            $pasien->telp = $faker->phoneNumber;
            $pasien->saveOrFail();
            $this->command->getOutput()->progressAdvance(1);
        }
        $this->command->getOutput()->progressFinish();
    }
}
