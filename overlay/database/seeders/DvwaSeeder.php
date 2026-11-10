<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DvwaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('dvwa_users')->truncate();
        DB::table('guestbook')->truncate();

        foreach ([
            ['admin', 'admin', 'admin', 'password'],
            ['Gordon', 'Brown', 'gordonb', 'abc123'],
            ['Hack', 'Me', '1337', 'charley'],
            ['Pablo', 'Picasso', 'pablo', 'letmein'],
            ['Bob', 'Smith', 'smithy', 'password'],
        ] as [$fn, $ln, $u, $p]) {
            DB::table('dvwa_users')->insert([
                'first_name' => $fn, 'last_name' => $ln, 'user' => $u, 'password' => md5($p),
            ]);
        }
        DB::table('guestbook')->insert(['comment' => 'Ini komentar uji coba.', 'name' => 'test']);
    }
}
