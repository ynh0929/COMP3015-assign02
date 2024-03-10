<?php

use core\Router;

use src\Controllers\ArticleController;
use src\Controllers\LoginController;
use src\Controllers\LogoutController;
use src\Controllers\RegistrationController;
use src\Controllers\SettingsController;

Router::get('/', [ArticleController::class, 'renderIndexPage']); // the root/index page
Router::get('/about', [ArticleController::class, 'about']); // Display the about page

// User/Auth related

Router::get('/login', [LoginController::class, 'index']);
Router::post('/login', [LoginController::class, 'login']);
Router::get('/register', [RegistrationController::class, 'index']); // show registration form.
Router::post('/register', [RegistrationController::class, 'register']); // process a registration req.
Router::post('/logout', [LogoutController::class, 'logout']);

Router::post('/upload_image', [SettingsController::class, 'uploadImage']);

// Article related
Router::get('/articles/create', [ArticleController::class, 'create']); // Show the form for creating a new article
Router::post('/articles/store', [ArticleController::class, 'store']); // Process the storing of a new article
Router::get('/articles/edit', [ArticleController::class, 'edit']); // Show the form for editing an article
Router::post('/articles/update', [ArticleController::class, 'update']); // Process the editing of an article
Router::post('/articles/delete', [ArticleController::class, 'delete']); // Process the deleting of an article

// Settings related
Router::get('/settings', [SettingsController::class, 'index']);
Router::post('/settings/update', [SettingsController::class, 'update']);

