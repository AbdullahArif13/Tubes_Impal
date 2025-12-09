<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = [
            [
                'nama'          => 'Café Latte',
                'deskripsi'     => 'Kopi susu klasik creamy.',
                'harga'         => 23000,
                'gambar_produk' => 'latte.jpg',
                'kategori'      => 'hot',
                'tersedia'      => true,
            ],
            [
                'nama'          => 'Americano',
                'deskripsi'     => 'Kopi hitam dengan rasa bold.',
                'harga'         => 20000,
                'gambar_produk' => 'americano.jpg',
                'kategori'      => 'hot',
                'tersedia'      => true,
            ],
            [
                'nama'          => 'Espresso',
                'deskripsi'     => 'Single shot espresso aromatik.',
                'harga'         => 18000,
                'gambar_produk' => 'espresso.jpg',
                'kategori'      => 'hot',
                'tersedia'      => true,
            ],
            [
                'nama'          => 'Cappuccino',
                'deskripsi'     => 'Perpaduan espresso dan milk foam.',
                'harga'         => 24000,
                'gambar_produk' => 'cappuccino.jpg',
                'kategori'      => 'hot',
                'tersedia'      => true,
            ],
            [
                'nama'          => 'Iced Latte',
                'deskripsi'     => 'Café latte dingin, creamy dan fresh.',
                'harga'         => 24000,
                'gambar_produk' => 'iced_latte.jpg',
                'kategori'      => 'cold',
                'tersedia'      => true,
            ],
            [
                'nama'          => 'Aren Latte',
                'deskripsi'     => 'Kopi susu + gula aren premium.',
                'harga'         => 25000,
                'gambar_produk' => 'aren_latte.jpg',
                'kategori'      => 'cold',
                'tersedia'      => true,
            ],
            [
                'nama'          => 'Iced Americano',
                'deskripsi'     => 'Americano dingin menyegarkan.',
                'harga'         => 20000,
                'gambar_produk' => 'iced_americano.jpg',
                'kategori'      => 'cold',
                'tersedia'      => true,
            ],
            [
                'nama'          => 'Buttercream Latte',
                'deskripsi'     => 'Kopi susu dengan foam buttercream.',
                'harga'         => 26000,
                'gambar_produk' => 'buttercream_latte.jpg',
                'kategori'      => 'cold', // bebas, bisa kamu ubah
                'tersedia'      => true,
            ],
            [
                'nama'          => 'Brownie Slice',
                'deskripsi'     => 'Brownies moist pekat.',
                'harga'         => 18000,
                'gambar_produk' => 'brownie.jpg',
                'kategori'      => 'small_bites',
                'tersedia'      => true,
            ],
            [
                'nama'          => 'Banana Bread',
                'deskripsi'     => 'Banana bread lembut wangi.',
                'harga'         => 15000,
                'gambar_produk' => 'banana_bread.jpg',
                'kategori'      => 'small_bites',
                'tersedia'      => true,
            ],
            [
                'nama'          => 'Croissant',
                'deskripsi'     => 'Croissant buttery flaky.',
                'harga'         => 20000,
                'gambar_produk' => 'croissant.jpg',
                'kategori'      => 'small_bites',
                'tersedia'      => true,
            ],
        ];

        foreach ($menus as $menu) {
            Menu::create($menu);
        }
    }
}
