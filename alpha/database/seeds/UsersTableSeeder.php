<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        \DB::table(app(User::class)->getTable())->truncate();
        $data = [];
        for ($i = 0; $i < 100; $i++) {
            $data[] = [
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'email_verified_at' => now(),
                'password' => Hash::make('123456'),
            ];
        }
        User::insert($data);
    }
}
