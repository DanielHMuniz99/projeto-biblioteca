<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LibraryUser;

class LibraryUserSeeder extends Seeder
{
    public function run(): void
    {
        LibraryUser::factory()->createMany([
            [
                'name' => 'Daniel Muniz',
                'email' => 'daniel@test.com',
                'registration_number' => 'U-001',
            ],
            [
                'name' => 'Maria Souza',
                'email' => 'maria@test.com',
                'registration_number' => 'U-002',
            ],
            [
                'name' => 'Carlos Lima',
                'email' => 'carlos@test.com',
                'registration_number' => 'U-003',
            ],
        ]);
    }
}
