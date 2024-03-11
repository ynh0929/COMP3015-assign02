<?php

namespace src\Controllers;

use core\Request;
use Exception;
use src\Repositories\UserRepository;

class LoginController extends Controller
{
    public function index(): void
    {
        $this->startSession();

        // If user is already authenticated, redirect to the main page
        if (isAuthenticated()) {
            $this->redirect('/');
        }
        $this->render('login');
    }

    /**
     * Process the login attempt.
     * @param Request $request
     * @return void
     */
    public function login(Request $request): void
    {
        $this->startSession();

        // If user is already authenticated, redirect to the main page
        if (isAuthenticated()) {
            $this->redirect('/');
        }

        $email = $request->input('email');
        $password = $request->input('password');

//        $email = $_POST['email'];
//        $password = $_POST['password'];

        try {
            $user = (new UserRepository)->getUserByEmail($email);
            $correctPassword = password_verify($password, $user->password_digest);

            if ($correctPassword) {
                $this->setSessionData('user_id', $user->id);
                $this->setSessionData('user_name', $user->name);
                $this->redirect('/');
            } else {
                $this->redirect('/login?error=Invalid+credentials');
            }
        } catch (Exception $e) {
            // Log the exception for debugging
            error_log('LoginController Exception: ' . $e->getMessage());

            // Handle the error gracefully (e.g., redirect with an error message)
            $this->redirect('/login?error=Something+went+wrong');
        }
    }

}
