<?php

namespace src\Controllers;

use core\Request;
use PDOException;
use src\Repositories\UserRepository;

class RegistrationController extends Controller
{

	/**
	 * @return void
	 */
    public function index(): void
    {
        $this->render('register');
    }

    /**
     * Handle user registration.
     * @param Request $request
     * @return void
     */
    public function register(Request $request): void
    {
        // Start the session before processing user registration
        $this->startSession();

        // Validate form inputs
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');

//        $name = $_POST['name'];
//        $email = $_POST['email'];
//        $password = $_POST['password'];

        // Use a helper function for validation to make the code cleaner
        $validationResult = $this->validateRegistrationInput($name, $email, $password);

        // Check the validation result
        if (!$validationResult['success']) {
            // Handle validation error
            $this->render('register', [
                'name_error' => $validationResult['errors']['name'] ?? '',
                'email_error' => $validationResult['errors']['email'] ?? '',
                'password_error' => $validationResult['errors']['password'] ?? '',
            ]);
            return;
        }

        try {
            // Check if the email is already registered
            $userRepository = new UserRepository();
            if ($userRepository->emailExists($email)) {
                $this->render('register', ['error' => 'Email is already registered']);
                return;
            }

            // Hash the password using password_hash with Bcrypt (cost of 12)
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);

            // Save the user to the database using UserRepository
            $newUser = $userRepository->saveUser($name, $email, $hashedPassword);

            // Automatically log in the user after successful registration
            $_SESSION['user_id'] = $newUser->id;
            $_SESSION['user_name'] = $newUser->name;

            // Redirect to the user's profile or dashboard
            $this->redirect('/'); // Change '/profile' to the appropriate path
            exit;
        } catch (PDOException $e) {
            // Log the exception for debugging
            error_log('PDOException: ' . $e->getMessage());

            // Display a user-friendly error message
            $this->render('register', ['error' => 'Error registering user. Please try again later.']);
        }
    }

    private function validateRegistrationInput(string $name, string $email, string $password): array
    {
        $validationResult = ['success' => true, 'errors' => []];

        if (empty($name) || !is_string($name) || !ctype_alpha(str_replace([' ', '-', '\''], '', $name))) {
            $validationResult['success'] = false;
            $validationResult['errors']['name'] = 'Name must be a string containing valid characters.';
        }

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $validationResult['success'] = false;
            $validationResult['errors']['email'] = 'Invalid email.';
        }

        if (strlen($password) < 8 || !preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
            $validationResult['success'] = false;
            $validationResult['errors']['password'] = 'Password must be at least 8 characters and contain at least one symbol.';
        }

        return $validationResult;
    }
}
