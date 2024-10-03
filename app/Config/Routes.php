<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\SuperAdminController;

/**
 * @var RouteCollection $routes
 */

service('auth')->routes($routes);
$routes->get('/', 'Home::index');



//Kelola Data OPD
$routes->group('', ['filter' => 'group:user'], function($routes) {
    $routes->get('/superadmin/opd/create', 'Superadmin\KelolaOpd::createOpd');
    $routes->post('/superadmin/opd/store', 'Superadmin\KelolaOpd::storeOpd');
    $routes->get('/superadmin/opd', 'Superadmin\KelolaOpd::index');
    $routes->get('/superadmin/opd/(:num)/edit', 'Superadmin\KelolaOpd::editOpd/$1');
    $routes->put('/superadmin/opd/update/(:num)', 'Superadmin\KelolaOpd::updateOpd/$1');
    $routes->delete('/superadmin/opd/(:num)', 'Superadmin\KelolaOpd::deleteOpd/$1');
});

