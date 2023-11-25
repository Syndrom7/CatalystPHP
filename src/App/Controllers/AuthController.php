<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Services\{ValidatorService, UserService};

/**
 * Controller for authentication-related actions.
 *
 * Handles user registration, login, logout, and rendering of auth views.
 */
class AuthController {

    private TemplateEngine $view;
    private ValidatorService $validatorService;
    private UserService $userService;

    /**
     * Constructs the AuthController.
     *
     * @param TemplateEngine $view The template engine for rendering views.
     * @param ValidatorService $validatorService The service for form validation.
     * @param UserService $userService The service for user operations.
     */
    public function __construct(TemplateEngine $view, ValidatorService $validatorService, UserService $userService) {
        $this->view = $view;
        $this->validatorService = $validatorService;
        $this->userService = $userService;
    }

    /**
     * Renders the registration view.
     *
     * @return void
     */
    public function registerView () : void {
        echo $this->view->render('auth/register', [
            'title' => 'Register'
        ]);
    }

    /**
     * Processes user registration.
     *
     * Validates the form data, checks for existing email, creates a new user, and redirects to the home page.
     *
     * @return void
     */
    public function register () : void {
        $this->validatorService->validateRegister($_POST);
        $this->userService->emailExists($_POST["email"]);
        $this->userService->createUser($_POST);

        redirectTo("/");
    }

    /**
     * Renders the login view.
     *
     * @return void
     */
    public function loginView () : void {
        echo $this->view->render('auth/login', [
            'title' => 'Login'
        ]);
    }

    /**
     * Processes user login.
     *
     * Validates the form data, authenticates the user and redirects to the home page.
     *
     * @return void
     */
    public function login () : void {
        $this->validatorService->validateLogin($_POST);
        $this->userService->login($_POST);

        redirectTo("/");
    }

    /**
     * Processes user logout.
     *
     * Logs out the user and redirects to the login page.
     *
     * @return void
     */
    public function logout () : void {
        $this->userService->logout();
        
        redirectTo("/login");
    }
}