<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var list<string>
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------
    public $registration = [
        'id_opd' => [
            'label' => 'ID OPD',
            'rules' => [
                'required',
                'is_not_unique[opd.id_opd]',  // Pastikan id_opd ada di tabel opd
            ],
            'errors' => [
                'required' => 'ID OPD wajib diisi.',
                'is_not_unique' => 'ID OPD tidak valid atau tidak ditemukan.',
            ],
        ],
        
        'no_telepon' => [
            'label' => 'Nomor Telepon',
            'rules' => [
                'max_length[15]',
                'min_length[10]',
                'regex_match[/^[0-9]+$/]',  // Hanya angka yang diperbolehkan
                'is_unique[users.no_telepon]',  // Cek keunikan di kolom users.no_telepon
            ],
            'errors' => [
                'max_length' => 'Nomor telepon maksimal 15 digit.',
                'min_length' => 'Nomor telepon minimal 10 digit.',
                'regex_match' => 'Nomor telepon hanya boleh berisi angka.',
                'is_unique' => 'Nomor telepon ini sudah terdaftar.',
            ],
        ],
        
        'name' => [
            'label' => 'Nama',
            'rules' => [
                'max_length[50]',  
                'min_length[3]',   
            ],
            'errors' => [
                'max_length' => 'Nama tidak boleh lebih dari 50 karakter.',
                'min_length' => 'Nama harus memiliki minimal 3 karakter.',
            ],
        ],
        
        'NIP' => [
            'label' => 'NIP',
            'rules' => [
                'required',
                'exact_length[18]',  // NIP di Indonesia biasanya memiliki panjang 18 digit
                'regex_match[/^[0-9]+$/]',  // Hanya angka yang diperbolehkan
                'is_unique[users.NIP]',  // Cek keunikan di kolom users.NIP
            ],
            'errors' => [
                'required' => 'NIP wajib diisi.',
                'exact_length' => 'NIP harus memiliki panjang tepat 18 digit.',
                'regex_match' => 'NIP hanya boleh berisi angka.',
                'is_unique' => 'NIP ini sudah terdaftar.',
            ],
        ],
        
        'email' => [
            'label' => 'Email',
            'rules' => [
                'required',
                'max_length[254]',
                'valid_email',
                'is_unique[auth_identities.secret]',
            ],
            'errors' => [
                'required' => 'Email wajib diisi.',
                'max_length' => 'Email tidak boleh lebih dari 254 karakter.',
                'valid_email' => 'Format email tidak valid.',
                'is_unique' => 'Email ini sudah digunakan.',
            ],
        ],
        
        'password' => [
            'label' => 'Password',
            'rules' => [
                'required',
                'max_byte[72]',
                'strong_password[]',
            ],
            'errors' => [
                'required' => 'Password wajib diisi.',
                'max_byte' => 'Password terlalu panjang.',
                'strong_password' => 'Password harus kuat dan memenuhi kriteria keamanan.',
            ],
        ],
        
        'password_confirm' => [
            'label' => 'Konfirmasi Password',
            'rules' => 'required|matches[password]',
            'errors' => [
                'required' => 'Konfirmasi password wajib diisi.',
                'matches' => 'Konfirmasi password tidak sesuai dengan password.',
            ],
        ],
    ];

    public $registrationUser = [
        
        'no_telepon' => [
            'label' => 'Nomor Telepon',
            'rules' => [
                'max_length[15]',
                'min_length[10]',
                'regex_match[/^[0-9]+$/]',  // Hanya angka yang diperbolehkan
                'is_unique[users.no_telepon]',  // Cek keunikan di kolom users.no_telepon
            ],
            'errors' => [
                'max_length' => 'Nomor telepon maksimal 15 digit.',
                'min_length' => 'Nomor telepon minimal 10 digit.',
                'regex_match' => 'Nomor telepon hanya boleh berisi angka.',
                'is_unique' => 'Nomor telepon ini sudah terdaftar.',
            ],
        ],
        
        'name' => [
            'label' => 'Nama',
            'rules' => [
                'max_length[50]',  
                'min_length[3]',   
            ],
            'errors' => [
                'max_length' => 'Nama tidak boleh lebih dari 50 karakter.',
                'min_length' => 'Nama harus memiliki minimal 3 karakter.',
            ],
        ],
        
        
        'NIK' => [
            'label' => 'NIK',
            'rules' => [
                'exact_length[16]',  // NIP di Indonesia biasanya memiliki panjang 18 digit
                'regex_match[/^[0-9]+$/]',  // Hanya angka yang diperbolehkan
                'is_unique[users.NIK]',  // Cek keunikan di kolom users.NIP
            ],
            'errors' => [
                'exact_length' => 'NIK harus memiliki panjang tepat 16 digit.',
                'regex_match' => 'NIK hanya boleh berisi angka.',
                'is_unique' => 'NIK ini sudah terdaftar.',
            ],
        ],
        
        'email' => [
            'label' => 'Email',
            'rules' => [
                'required',
                'max_length[254]',
                'valid_email',
                'is_unique[auth_identities.secret]',
            ],
            'errors' => [
                'required' => 'Email wajib diisi.',
                'max_length' => 'Email tidak boleh lebih dari 254 karakter.',
                'valid_email' => 'Format email tidak valid.',
                'is_unique' => 'Email ini sudah digunakan.',
            ],
        ],
        
        'password' => [
            'label' => 'Password',
            'rules' => [
                'required',
                'max_byte[72]',
                'strong_password[]',
            ],
            'errors' => [
                'required' => 'Password wajib diisi.',
                'max_byte' => 'Password terlalu panjang.',
                'strong_password' => 'Password harus kuat dan memenuhi kriteria keamanan.',
            ],
        ],
        
        'password_confirm' => [
            'label' => 'Konfirmasi Password',
            'rules' => 'required|matches[password]',
            'errors' => [
                'required' => 'Konfirmasi password wajib diisi.',
                'matches' => 'Konfirmasi password tidak sesuai dengan password.',
            ],
        ],
    ];

    public $createUser = [
        'id_opd' => [
            'label' => 'ID OPD',
            'rules' => [
                'permit_empty', // Izinkan kolom kosong
                'is_not_unique[opd.id_opd]',  // Pastikan id_opd ada di tabel opd
            ],
            'errors' => [
                'is_not_unique' => 'ID OPD tidak valid atau tidak ditemukan.',
            ],
        ],
    
        'no_telepon' => [
            'label' => 'Nomor Telepon',
            'rules' => [
                'max_length[15]',
                'min_length[10]',
                'regex_match[/^[0-9]+$/]',  // Hanya angka yang diperbolehkan
                'is_unique[users.no_telepon]',  // Cek keunikan di kolom users.no_telepon
            ],
            'errors' => [
                'max_length' => 'Nomor telepon maksimal 15 angka.',
                'min_length' => 'Nomor telepon minimal 10 angka.',
                'regex_match' => 'Nomor telepon hanya boleh berisi angka.',
                'is_unique' => 'Nomor telepon ini sudah digunakan.',
            ],
        ],
    
        'name' => [
            'label' => 'Nama',
            'rules' => [
                'max_length[50]',
                'min_length[3]',
            ],
            'errors' => [
                'max_length' => 'Nama maksimal 50 karakter.',
                'min_length' => 'Nama minimal 3 karakter.',
            ],
        ],
    
        'NIP' => [
            'label' => 'NIP',
            'rules' => [
                'permit_empty',
                'exact_length[18]',  // Panjang NIP adalah 18 digit
                'regex_match[/^[0-9]+$/]',  // Hanya angka yang diperbolehkan
                'is_unique[users.NIP]',  // Cek keunikan di kolom users.NIP
            ],
            'errors' => [
                'exact_length' => 'NIP harus terdiri dari 18 angka.',
                'regex_match' => 'NIP hanya boleh berisi angka.',
                'is_unique' => 'NIP ini sudah terdaftar.',
            ],
        ],
    
        'email' => [
            'label' => 'Email',
            'rules' => [
                'required',
                'max_length[254]',
                'valid_email',
                'is_unique[auth_identities.secret]',
            ],
            'errors' => [
                'required' => 'Email wajib diisi.',
                'max_length' => 'Email maksimal 254 karakter.',
                'valid_email' => 'Format email tidak valid.',
                'is_unique' => 'Email ini sudah digunakan.',
            ],
        ],
    
        'password' => [
            'label' => 'Kata Sandi',
            'rules' => [
                'required',
                'max_byte[72]',
                'strong_password[]',
            ],
            'errors' => [
                'required' => 'Kata sandi wajib diisi.',
                'max_byte' => 'Kata sandi terlalu panjang.',
                'strong_password' => 'Kata sandi harus mengandung huruf besar, huruf kecil, angka, dan simbol.',
            ],
        ],
    
        'password_confirm' => [
            'label' => 'Konfirmasi Kata Sandi',
            'rules' => 'required|matches[password]',
            'errors' => [
                'required' => 'Konfirmasi kata sandi wajib diisi.',
                'matches' => 'Konfirmasi kata sandi harus sama dengan kata sandi.',
            ],
        ],
    ];
    
    public $editUser = [
        'id_opd' => [
            'label' => 'ID OPD',
            'rules' => [
                'permit_empty',
                'is_not_unique[opd.id_opd]',
            ],
            'errors' => [
                'is_not_unique' => 'ID OPD tidak valid atau tidak ditemukan.',
            ],
        ],
        'no_telepon' => [
            'label' => 'Nomor Telepon',
            'rules' => [
                'permit_empty',
                'max_length[15]',
                'min_length[10]',
                'regex_match[/^[0-9]+$/]',
            ],
            'errors' => [
                'max_length' => 'Nomor telepon maksimal 15 angka.',
                'min_length' => 'Nomor telepon minimal 10 angka.',
                'regex_match' => 'Nomor telepon hanya boleh berisi angka.',
            ],
        ],
        'name' => [
            'label' => 'Nama',
            'rules' => [
                'permit_empty',
                'max_length[50]',
                'min_length[3]',
            ],
            'errors' => [
                'max_length' => 'Nama maksimal 50 karakter.',
                'min_length' => 'Nama minimal 3 karakter.',
            ],
        ],
        'NIP' => [
            'label' => 'NIP',
            'rules' => [
                'permit_empty',
                'exact_length[18]',
                'regex_match[/^[0-9]+$/]',
            ],
            'errors' => [
                'exact_length' => 'NIP harus terdiri dari 18 angka.',
                'regex_match' => 'NIP hanya boleh berisi angka.',
            ],
        ],
        'email' => [
            'label' => 'Email',
            'rules' => [
                'permit_empty',
                'max_length[254]',
                'valid_email',
            ],
            'errors' => [
                'max_length' => 'Email maksimal 254 karakter.',
                'valid_email' => 'Format email tidak valid.',
            ],
        ],
        'password' => [
            'label' => 'Kata Sandi',
            'rules' => [
                'permit_empty',
                'max_byte[72]',
                'strong_password[]',
            ],
            'errors' => [
                'max_byte' => 'Kata sandi terlalu panjang.',
                'strong_password' => 'Kata sandi harus mengandung huruf besar, huruf kecil, angka, dan simbol.',
            ],
        ],
    ];
      


    public $createUserUmum = [
        'no_telepon' => [
            'label' => 'Nomor Telepon',
            'rules' => [
                'max_length[15]',
                'min_length[10]',
                'regex_match[/^[0-9]+$/]',  // Hanya angka yang diperbolehkan
                'is_unique[users.no_telepon]',  // Cek keunikan di kolom users.no_telepon
            ],
            'errors' => [
                'max_length' => 'Nomor telepon maksimal 15 angka.',
                'min_length' => 'Nomor telepon minimal 10 angka.',
                'regex_match' => 'Nomor telepon hanya boleh berisi angka.',
                'is_unique' => 'Nomor telepon ini sudah digunakan.',
            ],
        ],
        
        'name' => [
            'label' => 'Nama',
            'rules' => [
                'max_length[50]',  // Nama biasanya bisa lebih panjang dari 15 karakter
                'min_length[3]',   // Minimum 3 karakter agar tidak terlalu pendek
            ],
            'errors' => [
                'max_length' => 'Nama maksimal 50 karakter.',
                'min_length' => 'Nama minimal 3 karakter.',
            ],
        ],
    
        'NIK' => [
            'label' => 'NIK',
            'rules' => [
                'exact_length[16]',  // NIK memiliki panjang 16 digit
                'regex_match[/^[0-9]+$/]',  // Hanya angka yang diperbolehkan
                'is_unique[users.NIK]',  // Cek keunikan di kolom users.NIK
            ],
            'errors' => [
                'exact_length' => 'NIK harus terdiri dari 16 angka.',
                'regex_match' => 'NIK hanya boleh berisi angka.',
                'is_unique' => 'NIK ini sudah terdaftar.',
            ],
        ],
    
        'email' => [
            'label' => 'Email',
            'rules' => [
                'required',
                'max_length[254]',
                'valid_email',
                'is_unique[auth_identities.secret]',
            ],
            'errors' => [
                'required' => 'Email wajib diisi.',
                'max_length' => 'Email maksimal 254 karakter.',
                'valid_email' => 'Format email tidak valid.',
                'is_unique' => 'Email ini sudah digunakan.',
            ],
        ],
        'password' => [
            'label' => 'Kata Sandi',
            'rules' => [
                'required',
                'max_byte[72]',
                'strong_password[]',
            ],
            'errors' => [
                'required' => 'Kata sandi wajib diisi.',
                'max_byte' => 'Kata sandi terlalu panjang.',
                'strong_password' => 'Kata sandi harus mengandung huruf besar, huruf kecil, angka, dan simbol.',
            ],
        ],
        'password_confirm' => [
            'label' => 'Konfirmasi Kata Sandi',
            'rules' => 'required|matches[password]',
            'errors' => [
                'required' => 'Konfirmasi kata sandi wajib diisi.',
                'matches' => 'Konfirmasi kata sandi harus sama dengan kata sandi.',
            ],
        ],
    ];
    
    public $editUserUmum = [
        'no_telepon' => [
            'label' => 'Nomor Telepon',
            'rules' => [
                'permit_empty',
                'max_length[15]',
                'min_length[10]',
                'regex_match[/^[0-9]+$/]',  // Hanya angka yang diperbolehkan
            ],
            'errors' => [
                'max_length' => 'Nomor telepon maksimal 15 angka.',
                'min_length' => 'Nomor telepon minimal 10 angka.',
                'regex_match' => 'Nomor telepon hanya boleh berisi angka.',
            ],
        ],
        'name' => [
            'label' => 'Nama',
            'rules' => [
                'permit_empty',
                'max_length[50]',
                'min_length[3]',
            ],
            'errors' => [
                'max_length' => 'Nama maksimal 50 karakter.',
                'min_length' => 'Nama minimal 3 karakter.',
            ],
        ],
        'NIK' => [
            'label' => 'NIK',
            'rules' => [
                'permit_empty',
                'exact_length[16]',
                'regex_match[/^[0-9]+$/]',  // Hanya angka yang diperbolehkan
            ],
            'errors' => [
                'exact_length' => 'NIK harus terdiri dari 16 angka.',
                'regex_match' => 'NIK hanya boleh berisi angka.',
            ],
        ],
        'email' => [
            'label' => 'Email',
            'rules' => [
                'permit_empty',
                'max_length[254]',
                'valid_email',
            ],
            'errors' => [
                'max_length' => 'Email maksimal 254 karakter.',
                'valid_email' => 'Format email tidak valid.',
            ],
        ],
        'password' => [
            'label' => 'Kata Sandi',
            'rules' => [
                'permit_empty',
                'max_byte[72]',
                'strong_password[]',
            ],
            'errors' => [
                'max_byte' => 'Kata sandi terlalu panjang.',
                'strong_password' => 'Kata sandi harus mengandung huruf besar, huruf kecil, angka, dan simbol.',
            ],
        ],
    ];
    
    
    
    // public $opd = [
    //     'nama_opd' => [
    //         'label' => 'Nama OPD',
    //         'rules' => 'required|min_length[3]|max_length[100]|is_unique[opd.nama_opd,id,{id_opd}]',
    //         'errors' => [
    //             'required' => 'Nama OPD harus diisi.',
    //             'min_length' => 'Nama OPD harus memiliki minimal 3 karakter.',
    //             'max_length' => 'Nama OPD tidak boleh lebih dari 100 karakter.',
    //             'is_unique' => 'Nama OPD ini sudah terdaftar.',
    //         ]
    //     ],
    //     'alamat' => [
    //         'label' => 'Alamat',
    //         'rules' => 'required|min_length[10]|max_length[255]',
    //         'errors' => [
    //             'required' => 'Alamat harus diisi.',
    //             'min_length' => 'Alamat harus memiliki minimal 10 karakter.',
    //             'max_length' => 'Alamat tidak boleh lebih dari 255 karakter.',
    //         ]
    //     ],
    //     'email' => [
    //         'label' => 'Email',
    //         'rules' => 'required|valid_email|max_length[100]',
    //         'errors' => [
    //             'required' => 'Email harus diisi.',
    //             'valid_email' => 'Masukkan email yang valid.',
    //             'max_length' => 'Email tidak boleh lebih dari 100 karakter.',
    //         ]
    //     ],
    //     'telepon' => [
    //         'label' => 'No. Telepon',
    //         'rules' => 'required|numeric|min_length[10]|max_length[15]',
    //         'errors' => [
    //             'required' => 'Nomor telepon harus diisi.',
    //             'numeric' => 'Nomor telepon hanya boleh berupa angka.',
    //             'min_length' => 'Nomor telepon harus memiliki minimal 10 digit.',
    //             'max_length' => 'Nomor telepon tidak boleh lebih dari 15 digit.',
    //         ]
    //     ],
    // ];
    
}
