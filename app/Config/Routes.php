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


$routes->group('', ['filter' => 'group:superadmin'], function ($routes) {



    //kelola galeri
    $routes->get('/superadmin/galeri', 'Superadmin\KelolaGaleri::index'); // Menampilkan daftar galeri
    $routes->get('/superadmin/galeri/create', 'Superadmin\KelolaGaleri::create'); // Menampilkan form tambah galeri
    // $routes->post('/superadmin/galeri/store', 'Superadmin\KelolaGaleri::store'); // Menyimpan galeri baru
    $routes->post('/superadmin/galeri/storeVideo', 'Superadmin\GaleriVideo::storeVideo'); // Menyimpan galeri baru
    $routes->post('/superadmin/galeri/storeImage', 'Superadmin\GaleriImage::storeImage'); // Menyimpan galeri baru
    $routes->get('/superadmin/galeri/edit/(:num)', 'Superadmin\KelolaGaleri::edit/$1'); // Menampilkan form edit
    $routes->post('/superadmin/galeri/update/(:num)', 'Superadmin\KelolaGaleri::update/$1'); // Memperbarui galeri
    $routes->delete('/superadmin/galeri/(:num)', 'Superadmin\KelolaGaleri::delete/$1'); // Menghapus galeri
    $routes->match(['get', 'post'], 'superadmin/galeri/update-image/(:num)', 'Superadmin\GaleriImage::updateImage/$1');
    $routes->match(['get', 'post'], 'superadmin/galeri/update-video/(:num)', 'Superadmin\GaleriVideo::updateVideo/$1');


    //kelola option web
    $routes->get('/superadmin/optionweb', 'Superadmin\KelolaOptionWeb::index'); // Menampilkan option web
    $routes->post('/superadmin/optionweb/update/(:num)', 'Superadmin\KelolaOptionWeb::update/$1'); // Mengupdate setting berdasarkan ID    
    $routes->post('/superadmin/optionweb/edit/(:num)', 'Superadmin\KelolaOptionWeb::edit/$1'); // Mengupdate setting berdasarkan ID 
    $routes->get('/superadmin/optionweb/image/(:num)', 'Superadmin\KelolaOptionWeb::showImage/$1');
    $routes->get('/superadmin/optionweb', 'Superadmin\KelolaOptionWeb::showAllOptions');
    $routes->get('/superadmin/optionweb/detail/(:num)', 'Superadmin\KelolaOptionWeb::showOption/$1');
    $routes->get('image/(:any)', 'Superadmin\KelolaOptionWeb::show/$1');


    $routes->get('/useractivation', 'Superadmin\KelolaUser::nonActiveList');
    $routes->get('/useractivation/count', 'Superadmin\KelolaUser::countNonActiveAdmins');
    $routes->post('/useractivation/activate', 'Superadmin\KelolaUser::activate');
    $routes->post('/useractivation/reject', 'Superadmin\KelolaUser::reject');


    $routes->get('superadmin/kunjungan/getKunjunganData', 'Superadmin\KunjunganController::getKunjunganData');
});


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

//berita
$routes->get('/berita/lainnya', 'LandingController::semuaBerita');
$routes->get('/foto/lainnya', 'LandingController::semuaFoto');
$routes->get('/video/lainnya', 'LandingController::semuaVideo');
$routes->get('berita/detail/(:segment)', 'LandingController::show/$1');

$routes->get('handleLogin', 'AuthController::handleLogin');
