<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('companies')->insert([
            ['name' => 'NONE', 'created_at' => Carbon::now()->format('Y-m-d H:i:s')],
        ]);

        DB::table('departments')->insert([
            ['name' => 'Geschäftsleitung', 'created_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['name' => 'Produktion', 'created_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['name' => 'Produktentwicklung / Konstruktion', 'created_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['name' => 'Marketing', 'created_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['name' => 'Vertrieb', 'created_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['name' => 'Buchhaltung', 'created_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['name' => 'Personalwesen', 'created_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['name' => 'EDV / IT', 'created_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['name' => 'Materialwirtschaft', 'created_at' => Carbon::now()->format('Y-m-d H:i:s')],
        ]);

        DB::table('roles')->insert([
            ['name' => 'SUPERADMIN', 'created_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['name' => 'ADMIN', 'created_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['name' => 'MANAGER', 'created_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['name' => 'USER', 'created_at' => Carbon::now()->format('Y-m-d H:i:s')],
        ]);

        DB::table('users')->insert([
            'name' => $_ENV['APP_USER'],
            'email' => $_ENV['APP_USER_MAIL'],
            'password' => bcrypt($_ENV['APP_PASSWORD']),
            'company_id' => 1,
            'role_id' => '1',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
