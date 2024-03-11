<?php

use src\Repositories\UserRepository;

function image(string $filename): string {
    return "/images/$filename";
}

/**
 * Validate the title.
 * @param string $title
 * @return bool
 */
function validTitle(string $title): bool {
    return !empty($title) && strlen($title) > 3;
}

/**
 * Validate the url.
 * @param string $url
 * @return bool
 */
function validURL(string $url): bool {
    return !empty($url) && filter_var($url, FILTER_VALIDATE_URL) !== false;
}

/**
 * Validate the name.
 * @param string $name
 * @return bool
 */
function validName(string $name): bool
{
    return !empty($name) && is_string($name) && ctype_alpha(str_replace([' ', '-', '\''], '', $name));
}

/**
 * Validate the email.
 * @param string $email
 * @return bool
 */
function validEmail(string $email): bool
{
    return !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Validate the password.
 * @param string $password
 * @return bool
 */
function validPassword(string $password): bool
{
    return strlen($password) >= 8 && preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password);
}


/**
 * Validate username.
 * @param string $username
 * @return array
 */
function validateUsername(string $username): array
{
    $errors = [];

    // Check if the username is empty
    if (empty($username)) {
        $errors['error'] = 'Username cannot be empty';
        return ['success' => false, 'error' => $errors['error']];
    }

    // Check if the username is already taken
    $userRepository = new UserRepository();
    $existingUser = $userRepository->getUserByEmail($username);
    if ($existingUser && $existingUser->id !== $_SESSION['user_id']) {
        $errors['error'] = 'Username is already taken';
        return ['success' => false, 'error' => $errors['error']];
    }

    // Username is valid
    return ['success' => true];
}

/**
 * Check if the user is authenticated.
 * @return bool
 */
function isAuthenticated(): bool
{
    return isset($_SESSION['user_id']);
}


/**
 * Safely output the data  in views.
 * @param string $data
 * @return bool
 */
function h(string $data): string
{
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}
