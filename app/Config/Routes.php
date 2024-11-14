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
$routes->get('/dashboard', 'Superadmin\Dashboard::index');
$routes->get('/jenis_inovasi', 'Superadmin\KelolaJenisInovasi::index');
$routes->get('/jenis_inovasi/create', 'Superadmin\KelolaJenisInovasi::create');
$routes->post('/jenis_inovasi/store', 'Superadmin\KelolaJenisInovasi::store');
$routes->get('/jenis_inovasi/edit/(:num)', 'Superadmin\KelolaJenisInovasi::edit/$1');
$routes->post('/jenis_inovasi/update/(:num)', 'Superadmin\KelolaJenisInovasi::update/$1');
$routes->get('/jenis_inovasi/delete/(:num)', 'Superadmin\KelolaJenisInovasi::delete/$1');


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



//Kelola Data OPD
$routes->group('', ['filter' => 'group:user'], function ($routes) {
    $routes->get('/superadmin/opd/create', 'Superadmin\KelolaOpd::createOpd');
    $routes->post('/superadmin/opd/store', 'Superadmin\KelolaOpd::storeOpd');
    $routes->get('superadmin/opd', 'Superadmin\KelolaOpd::index');
    $routes->get('/superadmin/opd/edit/(:any)', 'Superadmin\KelolaOpd::editOpd/$1');
    $routes->post('/superadmin/opd/update', 'Superadmin\KelolaOpd::updateOpd/$1');
    $routes->delete('/superadmin/opd', 'Superadmin\KelolaOpd::deleteOpd');

    $routes->get('/superadmin/galeri', 'Superadmin\KelolaGaleri::index'); // Menampilkan daftar galeri
    $routes->get('/superadmin/galeri/create', 'Superadmin\KelolaGaleri::create'); // Menampilkan form tambah galeri
    // $routes->post('/superadmin/galeri/store', 'Superadmin\KelolaGaleri::store'); // Menyimpan galeri baru
    $routes->post('/superadmin/galeri/storeVideo', 'Superadmin\GaleriVideo::storeVideo'); // Menyimpan galeri baru
    $routes->post('/superadmin/galeri/storeImage', 'Superadmin\GaleriImage::storeImage'); // Menyimpan galeri baru
    $routes->get('/superadmin/galeri/edit/(:num)', 'Superadmin\KelolaGaleri::edit/$1'); // Menampilkan form edit
    $routes->post('/superadmin/galeri/update/(:num)', 'Superadmin\KelolaGaleri::update/$1'); // Memperbarui galeri
    $routes->delete('/superadmin/galeri/(:num)', 'Superadmin\KelolaGaleri::delete/$1'); // Menghapus galeri

    $routes->get('/superadmin/optionweb', 'Superadmin\KelolaOptionWeb::index'); // Menampilkan option web
    $routes->post('/superadmin/optionweb/update/(:num)', 'Superadmin\KelolaOptionWeb::update/$1'); // Mengupdate setting berdasarkan ID    
    $routes->get('/superadmin/optionweb/edit/(:num)', 'Superadmin\KelolaOptionWeb::edit/$1'); // Mengupdate setting berdasarkan ID 
    $routes->get('/superadmin/optionweb/image/(:num)', 'Superadmin\KelolaOptionWeb::showImage/$1');
    $routes->get('/superadmin/optionweb', 'Superadmin\KelolaOptionWeb::showAllOptions');
    $routes->get('/superadmin/optionweb/detail/(:num)', 'Superadmin\KelolaOptionWeb::showOption/$1');
    $routes->get('image/(:any)', 'Superadmin\KelolaOptionWeb::show/$1');



    $routes->get('/superadmin/berita/list-berita', 'Superadmin\KelolaBerita::index'); // Menampilkan daftar galeri
    $routes->get('/superadmin/berita/create', 'Superadmin\KelolaBerita::create'); // Menampilkan form tambah galeri
    $routes->post('/superadmin/berita/store', 'Superadmin\KelolaBerita::store'); // Menyimpan galeri baru
    $routes->get('/superadmin/berita/(:segment)/edit', 'Superadmin\KelolaBerita::edit/$1'); // Menampilkan form edit
    $routes->put('/superadmin/berita/update/(:segment)', 'Superadmin\KelolaBerita::update/$1'); // Memperbarui galeri
    $routes->delete('/superadmin/berita', 'Superadmin\KelolaBerita::delete'); // Menghapus galeri

});

    $routes->get('/berita', 'Superadmin\KelolaBerita::publishedNews');
    $routes->get('berita/detail/(:segment)', 'Superadmin\KelolaBerita::show/$1');   
    $routes->get('berita/show/detail/(:segment)', 'Superadmin\KelolaBerita::detail/$1');


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

$routes->get('/useractivation', 'Superadmin\KelolaUser::nonActiveList');
$routes->post('/useractivation/activate', 'Superadmin\KelolaUser::activate');
$routes->post('/useractivation/reject', 'Superadmin\KelolaUser::reject');

$routes->get('/user/profile/edit', 'Superadmin\KelolaProfile::editProfile', ['as' => 'profile.edit']);
$routes->post('/user/profile/update', 'Superadmin\KelolaProfile::updateUser', ['as' => 'profile.update']);


$routes->get('/profile/edit', 'UserUmum\KelolaProfile::edit');
$routes->post('/profile/update', 'UserUmum\KelolaProfile::edit');

$routes->get('/adminopd/pegawai/list', 'AdminOpd\KelolaPegawaiOpd::index');
$routes->get('/adminopd/pegawai/create', 'AdminOpd\KelolaPegawaiOpd::create');
$routes->post('/adminopd/pegawai/store', 'AdminOpd\KelolaPegawaiOpd::store');
$routes->get('/adminopd/pegawai/edit/(:any)', 'AdminOpd\KelolaPegawaiOpd::edit/$1');
$routes->post('/adminopd/pegawai/update', 'AdminOpd\KelolaPegawaiOpd::update');
$routes->delete('/adminopd/pegawai/delete', 'AdminOpd\KelolaPegawaiOpd::delete');