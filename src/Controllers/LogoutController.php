<?php

namespace src\Controllers;

class LogoutController extends Controller
{

	public function logout(): void
    {
		session_destroy();
		$this->redirect('/');
	}
}
