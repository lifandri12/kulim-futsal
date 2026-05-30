<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat akun admin
        DB::table('users')->insert([
            'nama'       => 'Admin Kulim',
            'email'      => 'admin@kulimfutsal.com',
            'password'   => Hash::make('admin123'),
            'no_hp'      => '081234567890',
            'role'       => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Buat akun user biasa untuk testing
        DB::table('users')->insert([
            'nama'       => 'User Test',
            'email'      => 'user@test.com',
            'password'   => Hash::make('user123'),
            'no_hp'      => '089876543210',
            'role'       => 'user',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Tambah 3 lapangan contoh
        DB::table('fields')->insert([
            [
                'nama_lapangan' => 'Lapangan A',
                'lokasi'        => 'Gedung Utama - Lantai 1',
                'harga_per_jam' => 100000,
                'status'        => 'tersedia',
                'deskripsi'     => 'Lapangan standar dengan rumput sintetis berkualitas tinggi.',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'nama_lapangan' => 'Lapangan B',
                'lokasi'        => 'Gedung Utama - Lantai 2',
                'harga_per_jam' => 120000,
                'status'        => 'tersedia',
                'deskripsi'     => 'Lapangan premium dengan pencahayaan LED dan AC.',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'nama_lapangan' => 'Lapangan C (VIP)',
                'lokasi'        => 'Gedung VIP',
                'harga_per_jam' => 150000,
                'status'        => 'tersedia',
                'deskripsi'     => 'Lapangan VIP dengan tribun penonton dan loker.',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
        ]);
    }
}
