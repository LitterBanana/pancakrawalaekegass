<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Package;
use App\Models\PackagePrice;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Panggil UserSeeder agar akun admin terbuat
        $this->call([
            UserSeeder::class,
        ]);
        DB::table('branches')->insert([
            'name' => 'Kantor Pusat Bogor',
            'address' => 'Ruko Bali resort, Jln. Pendidikan Raya Rawakalong, Gunung Sindur Bogor',
            'phone' => '(021) 2983-6008',
            'email' => 'hijrahmadaniistiqomah@gmail.com',
            'is_headquarter' => true
        ]);

        // 2. Buat Master Hotel
        $movenpick = DB::table('hotels')->insertGetId([
            'name' => 'Movenpick',
            'city' => 'Makkah',
            'rating' => 5
        ]);

        $dallah = DB::table('hotels')->insertGetId([
            'name' => 'Dallah Taibah',
            'city' => 'Madinah',
            'rating' => 5
        ]);

        // 3. Buat Kategori (Logika Pintar: Cek dulu slug-nya, jika tidak ada, baru buat)
        $kategoriUmroh = Category::firstOrCreate(
            ['slug' => 'umroh'], // Ini yang dicari oleh sistem
            ['name' => 'Umroh', 'description' => 'Paket Perjalanan Umroh Reguler dan Plus'] // Ini yang diisi jika tidak ketemu
        );

        // 4. Buat Paket (Perhatikan kita sekarang pakai ID hotel, bukan teks)
        $paket1 = Package::create([
            'category_id' => $kategoriUmroh->id,
            'name' => 'Umroh Reguler 9 Hari',
            'slug' => 'umroh-reguler-9-hari',
            'description' => 'Fokus ibadah dengan kenyamanan fasilitas bintang 5.',
            'departure_date' => '2026-04-10',
            'return_date' => '2026-04-19',
            'duration' => 9,
            'quota' => 45,
            'hotel_makkah_id' => $movenpick,
            'hotel_madinah_id' => $dallah,
            'thumbnail' => 'packege-1.jpg'
        ]);

        // 5. Buat Harga
        PackagePrice::create(['package_id' => $paket1->id, 'type' => 'Quad', 'price' => 28000000]);
    }
}