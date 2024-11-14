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
        // 'username' => [
        //     'label' => 'Auth.username',
        //     'rules' => [
        //         'required',
        //         'max_length[30]',
        //         'min_length[3]',
        //         'regex_match[/\A[a-zA-Z0-9\.]+\z/]',
        //         'is_unique[users.username]',
        //     ],
        // ],
        'id_opd' => [
                'label' => 'ID OPD',
                'rules' => [
                    'required',
                    'is_not_unique[opd.id_opd]',  // Pastikan id_opd ada di tabel opd
                ],
            ],
        
        'no_telepon' => [
            'label' => 'no_telepon',
            'rules' => [
                'max_length[15]',
                'min_length[10]',
                'regex_match[/^[0-9]+$/]',  // Hanya angka yang diperbolehkan
                'is_unique[users.no_telepon]',  // Cek keunikan di kolom users.no_telepon
            ],
        ],
        
        'name' => [
            'label' => 'name',
            'rules' => [
                'max_length[50]',  // Nama biasanya bisa lebih panjang dari 15 karakter
                'min_length[3]',   // Minimum 3 karakter agar tidak terlalu pendek
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
        ],
        
        
        'email' => [
            'label' => 'Auth.email',
            'rules' => [
                'required',
                'max_length[254]',
                'valid_email',
                'is_unique[auth_identities.secret]',
            ],
        ],
        'password' => [
            'label' => 'Auth.password',
            'rules' => [
                'required',
                'max_byte[72]',
                'strong_password[]',
            ],
            'errors' => [
                'max_byte' => 'Auth.errorPasswordTooLongBytes',
            ]
        ],
        'password_confirm' => [
            'label' => 'Auth.passwordConfirm',
            'rules' => 'required|matches[password]',
        ],
    ];

    public $registrationUser = [
        // 'username' => [
        //     'label' => 'Auth.username',
        //     'rules' => [
        //         'required',
        //         'max_length[30]',
        //         'min_length[3]',
        //         'regex_match[/\A[a-zA-Z0-9\.]+\z/]',
        //         'is_unique[users.username]',
        //     ],
        // ],
        
        'no_telepon' => [
            'label' => 'no_telepon',
            'rules' => [
                'max_length[15]',
                'min_length[10]',
                'regex_match[/^[0-9]+$/]',  // Hanya angka yang diperbolehkan
                'is_unique[users.no_telepon]',  // Cek keunikan di kolom users.no_telepon
            ],
        ],
        
        'name' => [
            'label' => 'name',
            'rules' => [
                'max_length[50]',  // Nama biasanya bisa lebih panjang dari 15 karakter
                'min_length[3]',   // Minimum 3 karakter agar tidak terlalu pendek
            ],
        ],
        
        
        'NIK' => [
            'label' => 'NIK',
            'rules' => [
                'exact_length[16]',  // NIK memiliki panjang 16 digit
                'regex_match[/^[0-9]+$/]',  // Hanya angka yang diperbolehkan
                'is_unique[users.NIK]',  // Cek keunikan di kolom users.NIK
            ],
        ],
        
        'email' => [
            'label' => 'Auth.email',
            'rules' => [
                'required',
                'max_length[254]',
                'valid_email',
                'is_unique[auth_identities.secret]',
            ],
        ],
        'password' => [
            'label' => 'Auth.password',
            'rules' => [
                'required',
                'max_byte[72]',
                'strong_password[]',
            ],
            'errors' => [
                'max_byte' => 'Auth.errorPasswordTooLongBytes',
            ]
        ],
        'password_confirm' => [
            'label' => 'Auth.passwordConfirm',
            'rules' => 'required|matches[password]',
        ],
    ];

    public $createUser = [
        'id_opd' => [
            'label' => 'ID OPD',
            'rules' => [
                'permit_empty', // Izinkan kolom kosong
                'is_not_unique[opd.id_opd]',  // Pastikan id_opd ada di tabel opd
            ],
        ],
    
    'no_telepon' => [
        'label' => 'no_telepon',
        'rules' => [
            'max_length[15]',
            'min_length[10]',
            'regex_match[/^[0-9]+$/]',  // Hanya angka yang diperbolehkan
            'is_unique[users.no_telepon]',  // Cek keunikan di kolom users.no_telepon
        ],
    ],
    
    'name' => [
        'label' => 'name',
        'rules' => [
            'max_length[50]',  // Nama biasanya bisa lebih panjang dari 15 karakter
            'min_length[3]',   // Minimum 3 karakter agar tidak terlalu pendek
        ],
    ],
    
    'NIP' => [
        'label' => 'NIP',
        'rules' => [
            'permit_empty', // Izinkan kolom kosong
            'exact_length[18]',  // NIP di Indonesia biasanya memiliki panjang 18 digit
            'regex_match[/^[0-9]+$/]',  // Hanya angka yang diperbolehkan
            'is_unique[users.NIP]',  // Cek keunikan di kolom users.NIP
        ],
    ],
    
    // 'NIK' => [
    //     'label' => 'NIK',
    //     'rules' => [
    //         'exact_length[16]',  // NIK memiliki panjang 16 digit
    //         'regex_match[/^[0-9]+$/]',  // Hanya angka yang diperbolehkan
    //         'is_unique[users.NIK]',  // Cek keunikan di kolom users.NIK
    //     ],
    // ],
    
    'email' => [
        'label' => 'Auth.email',
        'rules' => [
            'required',
            'max_length[254]',
            'valid_email',
            'is_unique[auth_identities.secret]',
        ],
    ],
    'password' => [
        'label' => 'Auth.password',
        'rules' => [
            'required',
            'max_byte[72]',
            'strong_password[]',
        ],
        'errors' => [
            'max_byte' => 'Auth.errorPasswordTooLongBytes',
        ]
    ],
    'password_confirm' => [
        'label' => 'Auth.passwordConfirm',
        'rules' => 'required|matches[password]',
    ],
    ];

    public $editUser = [
        'id_opd' => [
            'label' => 'ID OPD',
            'rules' => [
                'permit_empty', // Izinkan kolom kosong
                'is_not_unique[opd.id_opd]',  // Pastikan id_opd ada di tabel opd
            ],
        ],
        'no_telepon' => [
            'label' => 'no_telepon',
            'rules' => [
                'permit_empty',
                'max_length[15]',
                'min_length[10]',
                'regex_match[/^[0-9]+$/]',  // Hanya angka yang diperbolehkan
            ],
        ],
        'name' => [
            'label' => 'name',
            'rules' => [
                'permit_empty',
                'max_length[50]',
                'min_length[3]',
            ],
        ],
        'NIP' => [
            'label' => 'NIP',
            'rules' => [
                'permit_empty',
                'exact_length[18]',
                'regex_match[/^[0-9]+$/]',  // Hanya angka yang diperbolehkan
            ],
        ],
        'email' => [
            'label' => 'Auth.email',
            'rules' => [
                'permit_empty',
                'max_length[254]',
                'valid_email',
            ],
        ],
        'password' => [
            'label' => 'Auth.password',
            'rules' => [
                'permit_empty',
                'max_byte[72]',
                'strong_password[]',
            ],
            'errors' => [
                'max_byte' => 'Auth.errorPasswordTooLongBytes',
            ],
        ],
    ];    


    public $createUserUmum = [
    'no_telepon' => [
        'label' => 'no_telepon',
        'rules' => [
            'max_length[15]',
            'min_length[10]',
            'regex_match[/^[0-9]+$/]',  // Hanya angka yang diperbolehkan
            'is_unique[users.no_telepon]',  // Cek keunikan di kolom users.no_telepon
        ],
    ],
    
    'name' => [
        'label' => 'name',
        'rules' => [
            'max_length[50]',  // Nama biasanya bisa lebih panjang dari 15 karakter
            'min_length[3]',   // Minimum 3 karakter agar tidak terlalu pendek
        ],
    ],
    
    // 'NIP' => [
    //     'label' => 'NIP',
    //     'rules' => [
    //         'permit_empty', // Izinkan kolom kosong
    //         'exact_length[18]',  // NIP di Indonesia biasanya memiliki panjang 18 digit
    //         'regex_match[/^[0-9]+$/]',  // Hanya angka yang diperbolehkan
    //         'is_unique[users.NIP]',  // Cek keunikan di kolom users.NIP
    //     ],
    // ],
    
    'NIK' => [
        'label' => 'NIK',
        'rules' => [
            'exact_length[16]',  // NIK memiliki panjang 16 digit
            'regex_match[/^[0-9]+$/]',  // Hanya angka yang diperbolehkan
            'is_unique[users.NIK]',  // Cek keunikan di kolom users.NIK
        ],
    ],
    
    'email' => [
        'label' => 'Auth.email',
        'rules' => [
            'required',
            'max_length[254]',
            'valid_email',
            'is_unique[auth_identities.secret]',
        ],
    ],
    'password' => [
        'label' => 'Auth.password',
        'rules' => [
            'required',
            'max_byte[72]',
            'strong_password[]',
        ],
        'errors' => [
            'max_byte' => 'Auth.errorPasswordTooLongBytes',
        ]
    ],
    'password_confirm' => [
        'label' => 'Auth.passwordConfirm',
        'rules' => 'required|matches[password]',
    ],
    ];

    public $editUserUmum = [
        'no_telepon' => [
            'label' => 'no_telepon',
            'rules' => [
                'permit_empty',
                'max_length[15]',
                'min_length[10]',
                'regex_match[/^[0-9]+$/]',  // Hanya angka yang diperbolehkan
            ],
        ],
        'name' => [
            'label' => 'name',
            'rules' => [
                'permit_empty',
                'max_length[50]',
                'min_length[3]',
            ],
        ],
        'NIK' => [
            'label' => 'NIK',
            'rules' => [
                'permit_empty',
                'exact_length[16]',
                'regex_match[/^[0-9]+$/]',  // Hanya angka yang diperbolehkan
            ],
        ],
        'email' => [
            'label' => 'Auth.email',
            'rules' => [
                'permit_empty',
                'max_length[254]',
                'valid_email',
            ],
        ],
        'password' => [
            'label' => 'Auth.password',
            'rules' => [
                'permit_empty',
                'max_byte[72]',
                'strong_password[]',
            ],
            'errors' => [
                'max_byte' => 'Auth.errorPasswordTooLongBytes',
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
