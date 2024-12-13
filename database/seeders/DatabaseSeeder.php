<?php

namespace Database\Seeders;

use App\Models\Dosen;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call(KBKSeeder::class);
        $this->call(ResultCriteriaSeeder::class);
        $this->call(ProposalCriteriaSeeder::class);


        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin'),
            'role' => 'admin',
        ]);

        //dosen
        $dosen = User::create([
            'name' => 'Dosen',
            'email' => 'dosen@dosen.com',
            'password' => bcrypt('dosen'),
            'role' => 'dosen',
        ]);

        Dosen::create([
            'user_id' => $dosen->id,
            'kbk_id' => 1,
            'nidn' => '1234567890',
            'role' => 'dosen',
        ]);

        $dosen_koordinatior = User::create([
            'name' => 'Dosen Koordinator',
            'email' => 'dosenkoor@dosen.com',
            'password' => bcrypt('dosenkoor'),
            'role' => 'dosen',
        ]);

        Dosen::create([
            'user_id' => $dosen_koordinatior->id,
            'nidn' => '0987654321',
            'kbk_id' => 1,
            'role' => 'dosen_koordinator',
        ]);

        $kaprodi = User::create([
            'name' => 'Kaprodi',
            'email' => 'kaprodi@dosen.com',
            'password' => bcrypt('kaprodi'),
            'role' => 'dosen',
        ]);

        Dosen::create([
            'user_id' => $kaprodi->id,
            'nidn' => '1234509876',
            'kbk_id' => 1,
            'role' => 'kaprodi',
        ]);

        Dosen::factory(10)->create();
    }
}
