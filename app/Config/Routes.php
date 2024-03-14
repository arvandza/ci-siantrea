<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/dashboard', 'Home::index');
$routes->get('/kelola_dosen', 'AdminController::index');
$routes->get('/kelola_antrean', 'AdminController::indexAntrean');
$routes->get('/kelola_dosen/edit/(:num)', 'AdminController::editDosen/$1');
$routes->get('/delete_dosen/(:num)', 'AdminController::deleteDosen/$1');
$routes->post('/tambah_dosen', 'AdminController::storeDataDosen');
$routes->post('/kelola_dosen/update/(:num)', 'AdminController::updateDosen/$1');
