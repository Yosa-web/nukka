<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\JenisInovasiController;
use App\Models\UserModel;
use app\Database\Migrations\CreateJenisInovasi;
use App\Controllers\SuperAdminController;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/jenis_inovasi', 'Superadmin\KelolaJenisInovasi::index');
$routes->get('/jenis_inovasi/create', 'Superadmin\KelolaJenisInovasi::create');
$routes->post('/jenis_inovasi/store', 'Superadmin\KelolaJenisInovasi::store');
$routes->get('/jenis_inovasi/edit/(:num)', 'Superadmin\KelolaJenisInovasi::edit/$1');
$routes->post('/jenis_inovasi/update/(:num)', 'Superadmin\KelolaJenisInovasi::update/$1');
$routes->get('/jenis_inovasi/delete/(:num)', 'Superadmin\KelolaJenisInovasi::delete/$1');


service('auth')->routes($routes);

//Kelola Data OPD
$routes->group('', ['filter' => 'group:user'], function ($routes) {
    $routes->get('/superadmin/opd/create', 'Superadmin\KelolaOpd::createOpd');
    $routes->post('/superadmin/opd/store', 'Superadmin\KelolaOpd::storeOpd');
    $routes->get('/superadmin/opd', 'Superadmin\KelolaOpd::index');
    $routes->get('/superadmin/opd/(:num)/edit', 'Superadmin\KelolaOpd::editOpd/$1');
    $routes->put('/superadmin/opd/update/(:num)', 'Superadmin\KelolaOpd::updateOpd/$1');
    $routes->delete('/superadmin/opd/(:num)', 'Superadmin\KelolaOpd::deleteOpd/$1');

    $routes->get('/superadmin/galeri', 'Superadmin\KelolaGaleri::index'); // Menampilkan daftar galeri
    $routes->get('/superadmin/galeri/create', 'Superadmin\KelolaGaleri::create'); // Menampilkan form tambah galeri
    // $routes->post('/superadmin/galeri/store', 'Superadmin\KelolaGaleri::store'); // Menyimpan galeri baru
    $routes->post('/superadmin/galeri/storeVideo', 'Superadmin\GaleriVideo::storeVideo'); // Menyimpan galeri baru
    $routes->post('/superadmin/galeri/storeImage', 'Superadmin\GaleriImage::storeImage'); // Menyimpan galeri baru
    $routes->get('/superadmin/galeri/edit/(:num)', 'Superadmin\KelolaGaleri::edit/$1'); // Menampilkan form edit
    $routes->post('/superadmin/galeri/update/(:num)', 'Superadmin\KelolaGaleri::update/$1'); // Memperbarui galeri
    $routes->delete('/superadmin/galeri/(:num)', 'Superadmin\KelolaGaleri::delete/$1'); // Menghapus galeri

    $routes->get('/superadmin/berita/list-berita', 'Superadmin\KelolaBerita::index'); // Menampilkan daftar galeri
    $routes->get('/superadmin/berita/create', 'Superadmin\KelolaBerita::create'); // Menampilkan form tambah galeri
    $routes->post('/superadmin/berita/store', 'Superadmin\KelolaBerita::store'); // Menyimpan galeri baru
    $routes->get('/superadmin/berita/(:num)/edit', 'Superadmin\KelolaBerita::edit/$1'); // Menampilkan form edit
    $routes->put('/superadmin/berita/update/(:num)', 'Superadmin\KelolaBerita::update/$1'); // Memperbarui galeri
    $routes->delete('/superadmin/berita/(:num)', 'Superadmin\KelolaBerita::delete/$1'); // Menghapus galeri
});

$routes->get('/berita', 'Superadmin\KelolaBerita::publishedNews');
$routes->get('berita/detail/(:num)', 'Superadmin\KelolaBerita::show/$1');

$routes->group('super_admin', ['filter' => 'group:user'], function ($routes) {
    $routes->get('/superadmin/galeri/delete/(:num)', 'Superadmin\KelolaGaleri::delete/$1'); // Menghapus galeri
});

// $routes->group('superadmin', ['filter' => 'group:user'], function ($routes) {
//     $routes->get('/galeri', 'Superadmin\KelolaGaleri::index'); // Menampilkan daftar galeri
//     $routes->get('/galeri/create', 'Superadmin\KelolaGaleri::create'); // Menampilkan form tambah galeri
//     $routes->post('/galeri/store', 'Superadmin\KelolaGaleri::store'); // Menyimpan galeri baru
//     $routes->get('/galeri/(:num)/edit', 'Superadmin\KelolaGaleri::edit/$1'); // Menampilkan form edit
//     $routes->post('/galeri/update/(:num)', 'Superadmin\KelolaGaleri::update/$1'); // Memperbarui galeri
//     $routes->delete('/galeri/(:num)', 'Superadmin\KelolaGaleri::delete/$1'); // Menghapus galeri
// });
