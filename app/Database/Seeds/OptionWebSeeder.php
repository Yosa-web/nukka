<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class OptionWebSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'key'          => 'Logo',
                'seting_type' => 'Image',
                'value'        => 'Logo Balitbang',
                'modified_by'  => 1, // Ganti dengan ID pengguna yang sesuai
            ],
            [
                'key'          => 'Warna',
                'seting_type' => 'Kode Warna',
                'value'        => ' #0000ff',
                'modified_by'  => 1, // Ganti dengan ID pengguna yang sesuai
            ],
            [
                'key'          => 'Nama',
                'seting_type' => 'Text',
                'value'        => 'Rumah Inovasi',
                'modified_by'  => 1, // Ganti dengan ID pengguna yang sesuai
            ],
            [
                'key'          => 'Regulasi',
                'seting_type' => 'Text',
                'value'        => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                Donec erat elit, gravida eget nisi ut, bibendum commodo urna. Praesent sollicitudin mi eu turpis iaculis, 
                et luctus purus rhoncus. Morbi interdum diam viverra lorem laoreet vestibulum. Fusce lobortis dignissim ex, at egestas purus
                . Vestibulum facilisis fermentum nunc, in dignissim purus luctus et. Pellentesque quis egestas diam, et vulputate nunc
                . Nullam consectetur vestibulum cursus. Proin porttitor turpis id lectus ultricies suscipit. Sed vitae tellus mattis, 
                tincidunt erat sed, consequat arcu. Nulla laoreet lacus ut urna sollicitudin interdum.',
                'modified_by'  => 1, // Ganti dengan ID pengguna yang sesuai
            ],
            [
                'key'          => 'Visi',
                'seting_type' => 'Text',
                'value'        => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                Donec erat elit, gravida eget nisi ut, bibendum commodo urna. Praesent sollicitudin mi eu turpis iaculis, 
                et luctus purus rhoncus. Morbi interdum diam viverra lorem laoreet vestibulum. Fusce lobortis dignissim ex, at egestas purus
                . Vestibulum facilisis fermentum nunc, in dignissim purus luctus et. Pellentesque quis egestas diam, et vulputate nunc
                . Nullam consectetur vestibulum cursus. Proin porttitor turpis id lectus ultricies suscipit. Sed vitae tellus mattis, 
                tincidunt erat sed, consequat arcu. Nulla laoreet lacus ut urna sollicitudin interdum.',
                'modified_by'  => 1, // Ganti dengan ID pengguna yang sesuai
            ],
            [
                'key'          => 'Misi',
                'seting_type' => 'Text',
                'value'        => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                Donec erat elit, gravida eget nisi ut, bibendum commodo urna. Praesent sollicitudin mi eu turpis iaculis, 
                et luctus purus rhoncus. Morbi interdum diam viverra lorem laoreet vestibulum. Fusce lobortis dignissim ex, at egestas purus
                . Vestibulum facilisis fermentum nunc, in dignissim purus luctus et. Pellentesque quis egestas diam, et vulputate nunc
                . Nullam consectetur vestibulum cursus. Proin porttitor turpis id lectus ultricies suscipit. Sed vitae tellus mattis, 
                tincidunt erat sed, consequat arcu. Nulla laoreet lacus ut urna sollicitudin interdum.',
                'modified_by'  => 1, // Ganti dengan ID pengguna yang sesuai
            ],
            [
                'key'          => 'Banner 1',
                'seting_type'  => 'Image',
                'value'        => 'banner_1.jpg', // Nama file gambar pertama
                'modified_by'  => 1,
            ],
            [
                'key'          => 'Banner 2',
                'seting_type'  => 'Image',
                'value'        => 'banner_2.jpg', // Nama file gambar kedua
                'modified_by'  => 1,
            ],
            [
                'key'          => 'Banner 3',
                'seting_type'  => 'Image',
                'value'        => 'banner_3.jpg', // Nama file gambar ketiga
                'modified_by'  => 1,
            ],
            [
                'key'          => 'Deskripsi',
                'seting_type' => 'Text',
                'value'        => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                Donec erat elit, gravida eget nisi ut, bibendum commodo urna. Praesent sollicitudin mi eu turpis iaculis, 
                et luctus purus rhoncus. Morbi interdum diam viverra lorem laoreet vestibulum. Fusce lobortis dignissim ex, at egestas purus
                . Vestibulum facilisis fermentum nunc, in dignissim purus luctus et. Pellentesque quis egestas diam, et vulputate nunc
                . Nullam consectetur vestibulum cursus. Proin porttitor turpis id lectus ultricies suscipit. Sed vitae tellus mattis, 
                tincidunt erat sed, consequat arcu. Nulla laoreet lacus ut urna sollicitudin interdum.',
                'modified_by'  => 1, // Ganti dengan ID pengguna yang sesuai
            ],
        ];

        // Memasukkan data ke dalam tabel option_web
        foreach ($data as $item) {
            $this->db->table('option_web')->insert($item);
        }
    }
}
