<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'last_name' => 'El Alaoui',
                'first_name' => 'Yassine',
                'role_id' => 1,
                'email' => 'admin1@demo.com',
                'password' => bcrypt('secret'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'last_name' => 'Gathy',
                'first_name' => 'Anne-Sophie',
                'role_id' => 2,
                'email' => 'manager1@demo.com',
                'password' => bcrypt('secret'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'last_name' => 'Pupien',
                'first_name' => 'Cédric',
                'role_id' => 2,
                'email' => 'manager2@demo.com',
                'password' => bcrypt('secret'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'last_name' => 'Lallemand',
                'first_name' => 'Dorothée',
                'role_id' => 2,
                'email' => 'manager3@demo.com',
                'password' => bcrypt('secret'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'last_name' => 'Garlic',
                'first_name' => 'Peter',
                'role_id' => 3,
                'email' => 'user1@demo.com',
                'password' => bcrypt('secret'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'last_name' => 'Balthasart',
                'first_name' => 'Virginie',
                'role_id' => 3,
                'email' => 'user2@demo.com',
                'password' => bcrypt('secret'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'last_name' => 'Avarello',
                'first_name' => 'Frédéric',
                'role_id' => 3,
                'email' => 'user3@demo.com',
                'password' => bcrypt('secret'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'last_name' => 'Michel',
                'first_name' => 'Nicolas',
                'role_id' => 3,
                'email' => 'user4@demo.com',
                'password' => bcrypt('secret'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'last_name' => 'Jonckers',
                'first_name' => 'Jeoffrey',
                'role_id' => 3,
                'email' => 'user5@demo.com',
                'password' => bcrypt('secret'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'last_name' => 'Daussogne',
                'first_name' => 'Jean-Christophe',
                'role_id' => 3,
                'email' => 'user6@demo.com',
                'password' => bcrypt('secret'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
        ]);
    }
}
