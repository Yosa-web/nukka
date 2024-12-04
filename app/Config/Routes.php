<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\JenisInovasiController;
use App\Models\UserModel;
use app\Database\Migrations\CreateJenisInovasi;
use App\Controllers\SuperAdminController;
use CodeIgniter\Shield\Controllers\RegisterController;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
// service('auth')->routes($routes);
service('auth')->routes($routes, ['except' => ['register', 'login']]);
$routes->get('register', '\App\Controllers\CustomRegisterController::registerView');
$routes->post('register', '\App\Controllers\CustomRegisterController::registerActionNew');
$routes->get('user/register', '\App\Controllers\CustomRegisterController::registerViewUser');
$routes->post('user/register', '\App\Controllers\CustomRegisterController::registerAction');
$routes->get('login', '\App\Controllers\CustomLoginController::loginView');
$routes->post('login', '\App\Controllers\CustomLoginController::loginAction');

// $routes->get('/register/admin', '\App\Controllers\CustomRegisterController::registerView');
// $routes->post('register/admin', '\App\Controllers\CustomRegisterController::registerActionNew');



// $routes->get('/superadmin/listuser', 'Superadmin\KelolaUser::index');
// $routes->get('/superadmin/user/create', 'Superadmin\KelolaUser::create');
// $routes->post('/superadmin/user/store', 'Superadmin\KelolaUser::store');
// $routes->post('/superadmin/user/update/(:num)', 'Superadmin\KelolaUser::update/$1');





$routes->group('', ['filter' => 'group:superadmin'], function ($routes) {

    //kelola OPD
    $routes->get('/superadmin/opd/create', 'Superadmin\KelolaOpd::createOpd');
    $routes->post('/superadmin/opd/store', 'Superadmin\KelolaOpd::storeOpd');
    $routes->get('superadmin/opd', 'Superadmin\KelolaOpd::index');
    $routes->get('/superadmin/opd/edit/(:any)', 'Superadmin\KelolaOpd::editOpd/$1');
    $routes->post('/superadmin/opd/update', 'Superadmin\KelolaOpd::updateOpd/$1');
    $routes->get('/superadmin/opd/check-delete/(:num)', 'SuperAdmin\KelolaOpd::checkDelete/$1');
    $routes->delete('/superadmin/opd', 'Superadmin\KelolaOpd::deleteOpd');

    //kelola galeri
    $routes->get('/superadmin/galeri', 'Superadmin\KelolaGaleri::index'); // Menampilkan daftar galeri
    $routes->get('/superadmin/galeri/create', 'Superadmin\KelolaGaleri::create'); // Menampilkan form tambah galeri
    // $routes->post('/superadmin/galeri/store', 'Superadmin\KelolaGaleri::store'); // Menyimpan galeri baru
    $routes->post('/superadmin/galeri/storeVideo', 'Superadmin\GaleriVideo::storeVideo'); // Menyimpan galeri baru
    $routes->post('/superadmin/galeri/storeImage', 'Superadmin\GaleriImage::storeImage'); // Menyimpan galeri baru
    $routes->get('/superadmin/galeri/edit/(:num)', 'Superadmin\KelolaGaleri::edit/$1'); // Menampilkan form edit
    $routes->post('/superadmin/galeri/update/(:num)', 'Superadmin\KelolaGaleri::update/$1'); // Memperbarui galeri
    $routes->delete('/superadmin/galeri/(:num)', 'Superadmin\KelolaGaleri::delete/$1'); // Menghapus galeri

    //kelola option web
    $routes->get('/superadmin/optionweb', 'Superadmin\KelolaOptionWeb::index'); // Menampilkan option web
    $routes->post('/superadmin/optionweb/update/(:num)', 'Superadmin\KelolaOptionWeb::update/$1'); // Mengupdate setting berdasarkan ID    
    $routes->post('/superadmin/optionweb/edit/(:num)', 'Superadmin\KelolaOptionWeb::edit/$1'); // Mengupdate setting berdasarkan ID 
    $routes->get('/superadmin/optionweb/image/(:num)', 'Superadmin\KelolaOptionWeb::showImage/$1');
    $routes->get('/superadmin/optionweb', 'Superadmin\KelolaOptionWeb::showAllOptions');
    $routes->get('/superadmin/optionweb/detail/(:num)', 'Superadmin\KelolaOptionWeb::showOption/$1');
    $routes->get('image/(:any)', 'Superadmin\KelolaOptionWeb::show/$1');

    //kelola inovasi
    $routes->get('/superadmin/inovasi', 'Superadmin\KelolaDataInovasi::index');
    $routes->get('/superadmin/inovasi/create', 'Superadmin\KelolaDataInovasi::create');
    $routes->post('/superadmin/inovasi/store', 'Superadmin\KelolaDataInovasi::store');
    $routes->get('/superadmin/inovasi/edit/(:num)', 'Superadmin\KelolaDataInovasi::edit/$1');
    $routes->post('/superadmin/inovasi/update/(:num)', 'Superadmin\KelolaDataInovasi::update/$1');
    $routes->get('/superadmin/inovasi/delete/(:num)', 'Superadmin\KelolaDataInovasi::delete/$1');
    $routes->get('/superadmin/inovasi/show/(:num)', 'Superadmin\KelolaDataInovasi::show/$1');
    $routes->post('/superadmin/inovasi/updateStatus/(:num)', 'Superadmin\KelolaDataInovasi::updateStatus/$1');
    $routes->get('/superadmin/inovasi/filter', 'SuperAdmin\KelolaDataInovasi::filterByStatuses');
    $routes->post('/superadmin/inovasi/tolak', 'Superadmin\KelolaDataInovasi::tolak');
    $routes->post('/superadmin/inovasi/setujui', 'Superadmin\KelolaDataInovasi::setujui');

    //kelola berita
    $routes->get('/superadmin/berita/list-berita', 'Superadmin\KelolaBerita::index');
    $routes->get('/superadmin/berita/create', 'Superadmin\KelolaBerita::create');
    $routes->post('/superadmin/berita/store', 'Superadmin\KelolaBerita::store');
    $routes->get('/superadmin/berita/(:segment)/edit', 'Superadmin\KelolaBerita::edit/$1');
    $routes->put('/superadmin/berita/update/(:segment)', 'Superadmin\KelolaBerita::update/$1');
    $routes->delete('/superadmin/berita', 'Superadmin\KelolaBerita::delete');
    $routes->get('/berita', 'Superadmin\KelolaBerita::publishedNews');
    $routes->get('berita/detail/(:segment)', 'Superadmin\KelolaBerita::show/$1');
    $routes->get('berita/show/detail/(:segment)', 'Superadmin\KelolaBerita::detail/$1');

    $routes->get('/superadmin/user/list/admin', 'Superadmin\KelolaUser::indexAdmin');
    $routes->get('/superadmin/user/list/pegawai', 'Superadmin\KelolaUser::indexPegawai');
    $routes->get('/superadmin/user/list/umum', 'Superadmin\KelolaUser::indexUmum');

    $routes->get('/superadmin/adminopd/create', 'Superadmin\KelolaUser::createAdmin');
    $routes->get('/superadmin/pegawaiopd/create', 'Superadmin\KelolaUser::createPegawai');
    $routes->get('/superadmin/umum/create', 'Superadmin\KelolaUser::createUmum');

    $routes->get('/superadmin/user/edit/admin/(:any)', 'Superadmin\KelolaUser::editAdmin/$1');
    $routes->get('/superadmin/user/edit/pegawai/(:any)', 'Superadmin\KelolaUser::editPegawai/$1');

    $routes->post('/superadmin/user/store', 'Superadmin\KelolaUser::store');
    $routes->post('admin/create-account', 'Superadmin\KelolaUser::createAccountAction');
    $routes->get('/superadmin/user/edit/(:num)', 'Superadmin\KelolaUser::edit/$1');
    $routes->post('/superadmin/user/update/(:num)', 'Superadmin\KelolaUser::update/$1');
    $routes->delete('/superadmin/user/(:num)', 'Superadmin\KelolaUser::delete/$1'); // Change to DELETE

    $routes->get('/superadmin/listuser', 'Superadmin\KelolaUser::index');
    // $routes->get('/superadmin/user/create', 'Superadmin\KelolaUser::create');
    $routes->post('/superadmin/user/store', 'Superadmin\KelolaUser::store');
    $routes->post('/superadmin/user/update/(:num)', 'Superadmin\KelolaUser::update/$1');

    $routes->get('/superadmin/user/list', 'Superadmin\KelolaUser::index');
    // $routes->get('/superadmin/user/create', 'Superadmin\KelolaUser::create');
    // $routes->post('admin/create-account', 'Superadmin\KelolaUser::createAccountAction');
    $routes->get('/superadmin/user/edit/(:num)', 'Superadmin\KelolaUser::edit/$1');
    $routes->post('/superadmin/user/update/(:num)', 'Superadmin\KelolaUser::update/$1');
    $routes->delete('superadmin/user', 'Superadmin\KelolaUser::delete'); // Change to DELETE


    $routes->get('/superadmin/userumum/create', 'Superadmin\KelolaUser::createUmum');
    $routes->post('superadmin/userumum/store', 'Superadmin\KelolaUser::storeUserUmum');
    $routes->get('/superadmin/userumum/edit/(:any)', 'Superadmin\KelolaUser::editUserUmum/$1');
    $routes->post('/superadmin/userumum/update/(:num)', 'Superadmin\KelolaUser::updateUserUmum/$1');

    $routes->get('/useractivation', 'Superadmin\KelolaUser::nonActiveList');
    $routes->post('/useractivation/activate', 'Superadmin\KelolaUser::activate');
    $routes->post('/useractivation/reject', 'Superadmin\KelolaUser::reject');

    //kelola jenis inovasi
    $routes->get('/dashboard', 'Superadmin\Dashboard::index');
    $routes->get('/jenis_inovasi', 'Superadmin\KelolaJenisInovasi::index');
    $routes->get('/jenis_inovasi/create', 'Superadmin\KelolaJenisInovasi::create');
    $routes->post('/jenis_inovasi/store', 'Superadmin\KelolaJenisInovasi::store');
    $routes->get('/jenis_inovasi/edit/(:num)', 'Superadmin\KelolaJenisInovasi::edit/$1');
    $routes->post('/jenis_inovasi/update/(:num)', 'Superadmin\KelolaJenisInovasi::update/$1');
    $routes->get('/jenis_inovasi/delete/(:num)', 'Superadmin\KelolaJenisInovasi::delete/$1');

    //kelola tahapan inovasi
    $routes->get('/dashboard', 'Superadmin\Dashboard::index');
    $routes->get('/tahapan', 'Superadmin\KelolaTahapan::index');
    $routes->get('/tahapan/create', 'Superadmin\KelolaTahapan::create');
    $routes->post('/tahapan/store', 'Superadmin\KelolaTahapan::store');
    $routes->get('/tahapan/edit/(:num)', 'Superadmin\KelolaTahapan::edit/$1');
    $routes->post('/tahapan/update/(:num)', 'Superadmin\KelolaTahapan::update/$1');
    $routes->get('/tahapan/delete/(:num)', 'Superadmin\KelolaTahapan::delete/$1');

    //kelola bentuk inovasi
    $routes->get('/dashboard', 'Superadmin\Dashboard::index');
    $routes->get('/bentuk', 'Superadmin\KelolaBentuk::index');
    $routes->get('/bentuk/create', 'Superadmin\KelolaBentuk::create');
    $routes->post('/bentuk/store', 'Superadmin\KelolaBentuk::store');
    $routes->get('/bentuk/edit/(:num)', 'Superadmin\KelolaBentuk::edit/$1');
    $routes->post('/bentuk/update/(:num)', 'Superadmin\KelolaBentuk::update/$1');
    $routes->get('/bentuk/delete/(:num)', 'Superadmin\KelolaBentuk::delete/$1');

    $routes->get('/superadmin/kecamatan', 'Superadmin\KecamatanController::index');
    $routes->get('/superadmin/kecamatan/create', 'Superadmin\KecamatanController::create');
    $routes->post('/superadmin/kecamatan/store', 'Superadmin\KecamatanController::store');
    $routes->get('/superadmin/kecamatan/edit/(:num)', 'Superadmin\KecamatanController::edit/$1');
    $routes->post('/superadmin/kecamatan/update/(:num)', 'Superadmin\KecamatanController::update/$1');
    $routes->get('/superadmin/kecamatan/delete/(:num)', 'Superadmin\KecamatanController::delete/$1');

    $routes->get('/superadmin/desa/(:num)', 'Superadmin\DesaController::index/$1');
    $routes->get('/superadmin/desa/create', 'Superadmin\DesaController::create');
    $routes->post('/superadmin/desa', 'Superadmin\DesaController::store');
    $routes->get('/superadmin/desa/edit/(:num)', 'Superadmin\DesaController::edit/$1');
    $routes->post('/superadmin/desa/update/(:num)', 'Superadmin\DesaController::update/$1');
    $routes->get('/superadmin/desa/delete/(:num)', 'Superadmin\DesaController::delete/$1');
});

$routes->group('', ['filter' => 'group:admin-opd'], function ($routes) {

    //kelola pegawai
    $routes->get('/adminopd/pegawai/list', 'AdminOpd\KelolaPegawaiOpd::index');
    $routes->get('/adminopd/pegawai/create', 'AdminOpd\KelolaPegawaiOpd::create');
    $routes->post('/adminopd/pegawai/store', 'AdminOpd\KelolaPegawaiOpd::store');
    $routes->get('/adminopd/pegawai/edit/(:any)', 'AdminOpd\KelolaPegawaiOpd::edit/$1');
    $routes->post('/adminopd/pegawai/update', 'AdminOpd\KelolaPegawaiOpd::update');
    $routes->delete('/adminopd/pegawai/delete', 'AdminOpd\KelolaPegawaiOpd::delete');

    //kelola data inovasi
    $routes->get('/admin/inovasi', 'AdminOpd\KelolaDataInovasi::index');
    $routes->get('/admin/inovasi/create', 'AdminOpd\KelolaDataInovasi::create');
    $routes->post('/admin/inovasi/store', 'AdminOpd\KelolaDataInovasi::store');
    $routes->get('/admin/inovasi/edit/(:num)', 'AdminOpd\KelolaDataInovasi::edit/$1');
    $routes->post('/admin/inovasi/update/(:num)', 'AdminOpd\KelolaDataInovasi::update/$1');
    $routes->get('/admin/inovasi/delete/(:num)', 'AdminOpd\KelolaDataInovasi::delete/$1');
    $routes->get('/admin/inovasi/show/(:num)', 'AdminOpd\KelolaDataInovasi::show/$1');
    $routes->get('/admin/inovasi/filter', 'AdminOpd\KelolaDataInovasi::filterByStatuses');
});


$routes->group('', ['filter' => 'group:sekertaris-opd'], function ($routes) {

    $routes->get('/sekertaris/inovasi', 'SekertarisOpd\KelolaDataInovasi::index');
    $routes->get('/sekertaris/inovasi/create', 'SekertarisOpd\KelolaDataInovasi::create');
    $routes->post('/sekertaris/inovasi/store', 'SekertarisOpd\KelolaDataInovasi::store');
    $routes->get('/sekertaris/inovasi/edit/(:num)', 'SekertarisOpd\KelolaDataInovasi::edit/$1');
    $routes->post('/sekertaris/inovasi/update/(:num)', 'SekertarisOpd\KelolaDataInovasi::update/$1');
    $routes->get('/sekertaris/inovasi/delete/(:num)', 'SekertarisOpd\KelolaDataInovasi::delete/$1');
    $routes->get('/sekertaris/inovasi/show/(:num)', 'SekertarisOpd\KelolaDataInovasi::show/$1');
    $routes->post('/sekertaris/inovasi/updateStatus/(:num)', 'SekertarisOpd\KelolaDataInovasi::updateStatus/$1');
    $routes->get('/sekertaris/inovasi/filter', 'SekertarisOpd\KelolaDataInovasi::filterByStatuses');
    $routes->post('/sekertaris/inovasi/tolak', 'SekertarisOpd\KelolaDataInovasi::tolak');
    $routes->post('/sekertaris/inovasi/setujui', 'SekertarisOpd\KelolaDataInovasi::setujui');
    $routes->post('sekertaris/inovasi/revisi', 'SekertarisOpd\KelolaDataInovasi::revisi');
});

$routes->group('', ['filter' => 'group:kepala-opd'], function ($routes) {

    $routes->get('/kepala/inovasi', 'KepalaOpd\KelolaDataInovasi::index');
    $routes->get('/kepala/inovasi/create', 'KepalaOpd\KelolaDataInovasi::create');
    $routes->post('/kepala/inovasi/store', 'KepalaOpd\KelolaDataInovasi::store');
    $routes->get('/kepala/inovasi/edit/(:num)', 'KepalaOpd\KelolaDataInovasi::edit/$1');
    $routes->post('/kepala/inovasi/update/(:num)', 'KepalaOpd\KelolaDataInovasi::update/$1');
    $routes->get('/kepala/inovasi/delete/(:num)', 'KepalaOpd\KelolaDataInovasi::delete/$1');
    $routes->get('/kepala/inovasi/show/(:num)', 'KepalaOpd\KelolaDataInovasi::show/$1');
    $routes->post('/kepala/inovasi/updateStatus/(:num)', 'KepalaOpd\KelolaDataInovasi::updateStatus/$1');
    $routes->get('/kepala/inovasi/filter', 'KepalaOpd\KelolaDataInovasi::filterByStatuses');
    $routes->post('/kepala/inovasi/tolak', 'KepalaOpd\KelolaDataInovasi::tolak');
    $routes->post('/kepala/inovasi/setujui', 'KepalaOpd\KelolaDataInovasi::setujui');
    $routes->post('kepala/inovasi/revisi', 'KepalaOpd\KelolaDataInovasi::revisi');
});

$routes->group('', ['filter' => 'group:operator'], function ($routes) {

    $routes->get('operator/inovasi', 'Operator\KelolaDataInovasi::index');
    $routes->get('/operator/inovasi/create', 'Operator\KelolaDataInovasi::create');
    $routes->post('/operator/inovasi/store', 'Operator\KelolaDataInovasi::store');
    $routes->get('/operator/inovasi/edit/(:num)', 'Operator\KelolaDataInovasi::edit/$1');
    $routes->post('/operator/inovasi/update/(:num)', 'Operator\KelolaDataInovasi::update/$1');
    $routes->get('/operator/inovasi/delete/(:num)', 'Operator\KelolaDataInovasi::delete/$1');
    $routes->get('/operator/inovasi/show/(:num)', 'Operator\KelolaDataInovasi::show/$1');
    $routes->get('/operator/inovasi/filter', 'Operator\KelolaDataInovasi::filterByStatuses');
});

$routes->group('', ['filter' => 'group:user'], function ($routes) {

    $routes->get('/userumum/inovasi', 'UserUmum\KelolaDataInovasi::index');
    $routes->get('/userumum/inovasi/create', 'UserUmum\KelolaDataInovasi::create');
    $routes->post('/userumum/inovasi/store', 'UserUmum\KelolaDataInovasi::store');
    $routes->get('/userumum/inovasi/edit/(:num)', 'UserUmum\KelolaDataInovasi::edit/$1');
    $routes->post('/userumum/inovasi/update/(:num)', 'UserUmum\KelolaDataInovasi::update/$1');
    $routes->get('/userumum/inovasi/delete/(:num)', 'UserUmum\KelolaDataInovasi::delete/$1');
    $routes->get('/userumum/inovasi/show/(:num)', 'UserUmum\KelolaDataInovasi::show/$1');
    $routes->get('/userumum/inovasi/filter', 'UserUmum\KelolaDataInovasi::filterByStatuses');
});

// $routes->get('/berita', 'Superadmin\KelolaBerita::publishedNews');
// $routes->get('berita/detail/(:segment)', 'Superadmin\KelolaBerita::show/$1');
// $routes->get('berita/show/detail/(:segment)', 'Superadmin\KelolaBerita::detail/$1');


// $routes->get('/option_web', 'Superadmin\KelolaOptionWeb::publishedOptions');
// $routes->get('option_web/detail/(:num)', 'Superadmin\KelolaOptionWeb::show/$1');

// $routes->group('optionweb', function ($routes) {
//     $routes->get('/', 'OptionWebController::index'); // Menampilkan option web
//     $routes->post('update/(:num)', 'OptionWebController::update/$1'); // Mengupdate setting berdasarkan ID
// });


// $routes->group('super_admin', ['filter' => 'group:user'], function ($routes) {
//     $routes->get('/superadmin/galeri/delete/(:num)', 'Superadmin\KelolaGaleri::delete/$1'); // Menghapus galeri
// });

// $routes->group('superadmin', ['filter' => 'group:user'], function ($routes) {
//     $routes->get('/galeri', 'Superadmin\KelolaGaleri::index'); // Menampilkan daftar galeri
//     $routes->get('/galeri/create', 'Superadmin\KelolaGaleri::create'); // Menampilkan form tambah galeri
//     $routes->post('/galeri/store', 'Superadmin\KelolaGaleri::store'); // Menyimpan galeri baru
//     $routes->get('/galeri/(:num)/edit', 'Superadmin\KelolaGaleri::edit/$1'); // Menampilkan form edit
//     $routes->post('/galeri/update/(:num)', 'Superadmin\KelolaGaleri::update/$1'); // Memperbarui galeri
//     $routes->delete('/galeri/(:num)', 'Superadmin\KelolaGaleri::delete/$1'); // Menghapus galeri
// });

$routes->group('', ['filter' => 'group:superadmin,kepala-opd,sekertaris-opd,admin-opd,operator'], function ($routes) {
    $routes->get('/user/profile/edit', 'Superadmin\KelolaProfile::editProfile', ['as' => 'profile.edit']);
    $routes->post('/user/profile/update', 'Superadmin\KelolaProfile::updateUser', ['as' => 'profile.update']);
});


$routes->group('', ['filter' => 'group:user'], function ($routes) {
    $routes->get('/profile/edit', 'UserUmum\KelolaProfile::edit');
    $routes->post('/profile/update', 'UserUmum\KelolaProfile::update');
});

$routes->get('/beranda', 'LandingController::index');
$routes->get('/tentang', 'LandingController::tentang');
$routes->get('/visi-misi', 'LandingController::visi');
$routes->get('/database-inovasi', 'LandingController::databaseInovasi');
$routes->get('/peta-inovasi', 'LandingController::petaInovasi');
$routes->get('/api/jumlah-inovasi', 'LandingController::jumlahInovasi');
$routes->get('/regulasi', 'LandingController::regulasi');

//berita
$routes->get('/berita/lainnya', 'LandingController::semuaBerita');

$routes->get('handleLogin', 'AuthController::handleLogin');
