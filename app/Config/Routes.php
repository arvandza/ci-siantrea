<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::landing');
$routes->get('/login', 'AuthController::index');
$routes->post('/auth', 'AuthController::auth');
$routes->get('/dashboard', 'Home::index');
$routes->get('/kelola_dosen', 'AdminController::index');
$routes->get('/kelola_antrean', 'AdminController::indexAntrean');
$routes->get('/kelola_dosen/edit', 'AdminController::editDosen');
$routes->get('/delete_dosen/(:num)', 'AdminController::deleteDosen/$1');
$routes->post('/tambah_dosen', 'AdminController::addDosen');
$routes->post('/kelola_dosen/update/(:num)', 'AdminController::updateDosen/$1');
$routes->post('/tambah_antrean', 'AdminController::addAntrean');
$routes->get('/delete_antrean/(:num)', 'AdminController::deleteAntrean/$1');
$routes->get('/kelola_antrean/edit', 'AdminController::editAntrean');
$routes->post('/kelola_antrean/update/(:num)', 'AdminController::updateAntrean/$1');

// errors
$routes->set404Override(function () {
    $data['title'] = 'Not Found';
    return view('errors/custom_404', $data);
});