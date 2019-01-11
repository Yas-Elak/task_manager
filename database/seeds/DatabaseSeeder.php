<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(ComponentsTableSeeder::class);
        $this->call(OptionsTableSeeder::class);
        $this->call(PrioritiesTableSeeder::class);
        $this->call(RolesTableSeeder::class);
//        $this->call(NotificationsTableSeeder::class);
        $this->call(StatusesTableSeeder::class);



    }
}
