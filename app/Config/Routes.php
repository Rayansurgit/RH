<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Authentification
$routes->group('auth', function($routes) {
    $routes->get('login', 'Auth::login');
    $routes->post('login', 'Auth::login');
    $routes->get('logout', 'Auth::logout');
    $routes->get('register', 'Auth::register');
    $routes->post('register', 'Auth::register');
});

// Dashboard & Redirection par défaut
$routes->get('/', static function() {
    if (session('logged_in')) {
        $role = session('user_role');
        if ($role === 'admin') {
            return redirect()->to(base_url('admin/dashboard'));
        } elseif ($role === 'rh') {
            return redirect()->to(base_url('rh/dashboard'));
        } else {
            return redirect()->to(base_url('employe/dashboard'));
        }
    }
    return redirect()->to(base_url('auth/login'));
});

// Espace Employé
$routes->group('employe', function($routes) {
    $routes->get('dashboard', 'Employe::dashboard');
    $routes->get('conges', 'Employe::conges');
    $routes->get('conges/create', 'Employe::createConge');
    $routes->post('conges/store', 'Employe::storeConge');
    $routes->get('conges/cancel/(:num)', 'Employe::cancelConge/$1');
    $routes->get('profil', 'Employe::profil');
});

// Espace RH
$routes->group('rh', function($routes) {
    $routes->get('dashboard', 'RH::dashboard');
    $routes->get('conges', 'RH::conges');
    $routes->post('conges/approve/(:num)', 'RH::approve/$1');
    $routes->get('conges/approve/(:num)', 'RH::approve/$1');
    $routes->post('conges/refuse/(:num)', 'RH::refuse/$1');
    $routes->get('conges/refuse/(:num)', 'RH::refuse/$1');
    $routes->get('historique', 'RH::historique');
    $routes->get('soldes', 'RH::soldes');
});

// Espace Admin
$routes->group('admin', function($routes) {
    $routes->get('dashboard', 'Admin::dashboard');
    
    // Employés
    $routes->get('employes', 'Admin::employes');
    $routes->post('employes/store', 'Admin::storeEmploye');
    $routes->get('employes/edit/(:num)', 'Admin::editEmploye/$1');
    $routes->post('employes/update/(:num)', 'Admin::updateEmploye/$1');
    $routes->get('employes/delete/(:num)', 'Admin::deleteEmploye/$1');
    
    // Départements
    $routes->get('departements', 'Admin::departements');
    $routes->post('departements/store', 'Admin::storeDepartement');
    
    // Types de congé
    $routes->get('types-conge', 'Admin::typeConge');
    $routes->post('types-conge/store', 'Admin::storeTypeConge');
    
    // Soldes
    $routes->get('soldes', 'Admin::soldes');
});
