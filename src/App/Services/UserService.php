<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Database;
use Framework\Exceptions\ValidationException;

/**
 * Service class for managing user-related operations.
 *
 * Provides functionality for checking user email uniqueness, creating new users,
 * handling user login and logout.
 */
class UserService {
    private Database $db;

    /**
     * Constructs Database instance.
     *
     * @param Database $db The database connection used for queries.
     */
    public function __construct(Database $db) {
        $this->db = $db;
    }

    /**
     * Checks if an email already exists in the database.
     *
     * Throws a ValidationException if the email is found in the users table.
     *
     * @param string $email The email address to check.
     * @throws ValidationException If the email already exists.
     * @return void
     */
    public function emailExists(string $email) : void {
        $emailCount = $this->db->query(
            "SELECT COUNT(*) FROM users WHERE email = :email",
            ["email" => $email]
        )->count();

        if ($emailCount > 0) {
            throw new ValidationException(["email" => "Email is already taken"]);
        }
    }

    /**
     * Creates a new user in the database.
     *
     * Hashes the user's password and stores the user's details.
     * Also, updates the session to log in the newly created user.
     *
     * @param array $postData The user data to create a new user.
     * @return void
     */
    public function createUser($postData) {
        $securePass = password_hash($postData["password"], PASSWORD_BCRYPT, ["cost" => 12]);
        $this->db->query(
            "INSERT INTO users (email, password) VALUES(:email, :password)",
            [
                "email" => $postData["email"], 
                "password" => $securePass,
            ]
        );

        session_regenerate_id();
        $_SESSION["user"] = $this->db->id(); 
    }

    /**
     * Authenticates a user based on email and password.
     *
     * Validates the credentials and updates the session to log in the user.
     *
     * @param array $postData The login credentials.
     * @throws ValidationException If authentication fails.
     * @return void
     */
    public function login (array $postData) {
        $user = $this->db->query(
            "SELECT * FROM users WHERE email = :email",
            [
                "email" => $postData["email"]
            ]
        )->find();

        $passwordsMatch = password_verify(
            $postData["password"], 
            $user["password"] ?? ""
        );

        if (!$user || !$passwordsMatch) {
            throw new ValidationException(["password" => ["Invalid Email or Password"]]);
        }

        session_regenerate_id();

        $_SESSION["user"] = $user["id"];
    }

    /**
     * Logs out the current user.
     *
     * Destroys the current session and clears the session cookie.
     * @return void
     */
    public function logout () {
        session_destroy();
        
        $params = session_get_cookie_params();
        setcookie(
            "PHPSESSIONID",
            "",
            time() - 3600,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }
}