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
$routes->post('/tambah_dosen', 'AdminController::addDosen');
$routes->post('/kelola_dosen/update/(:num)', 'AdminController::updateDosen/$1');
$routes->post('/tambah_antrean', 'AdminController::addAntrean');
$routes->get('/delete_antrean/(:num)', 'AdminController::deleteAntrean/$1');
$routes->get('/kelola_antrean/edit/(:num)', 'AdminController::editAntrean/$1');
$routes->post('/kelola_antrean/update/(:num)', 'AdminController::updateAntrean/$1');
