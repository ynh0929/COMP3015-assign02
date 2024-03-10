<?php

namespace src\Controllers;

use core\Request;
use src\Repositories\UserRepository;

class SettingsController extends Controller
{

	/**
	 * @param Request $request
	 * @return void
	 */
	public function index(Request $request): void
	{
		// TODO

        // Check if the user is authenticated
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
            return;
        }

        $userRepository = new UserRepository();
        $user = $userRepository->getUserById($_SESSION['user_id']);

        // Render the settings page with user data
        $this->render('settings', ['user' => $user]);
	}

    /**
	 * @param Request $request
	 * @return void
	 */
    public function update(Request $request): void
    {
        // TODO

        // Ensure user is authenticated
        $authenticatedUserId = $_SESSION['user_id'];

        if (!$authenticatedUserId) {
            $this->redirect('/login?error=Unauthorized');
            return;
        }

        // Validate user input
        $newUsername = $request->input('username');

        // Fetch the existing user data
        $userRepository = new UserRepository();
        $user = $userRepository->getUserById($authenticatedUserId);

        // Validate username
        $validationResult = $this->validateUsername($newUsername);

        if (!$validationResult['success']) {
            // Handle validation error
            $this->render('settings', [
                'user' => ['id' => $authenticatedUserId, 'username' => $newUsername],
                'username_error' => $validationResult['errors']['username'] ?? '',
            ]);
            return;
        }

        // Handle image upload logic
        $profilePicture = $_FILES['profile_picture'];

        if ($profilePicture['error'] === UPLOAD_ERR_OK) {
            $filename = $profilePicture['name'];

            // Move the uploaded file to the destination directory
            move_uploaded_file($profilePicture['tmp_name'], image($filename));

            // Update user with the new username and profile picture filename
            $userRepository->updateUser($authenticatedUserId, $newUsername, $filename);
        }
        // Update user username
        $userRepository->updateUser($authenticatedUserId, $newUsername);

        // Redirect to the homepage
        $this->redirect('/');
    }


    /**
     * Validate username.
     * @param string $username
     * @return array
     */
    private function validateUsername(string $username): array
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
}
