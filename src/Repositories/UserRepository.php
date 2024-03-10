<?php

namespace src\Repositories;

use PDO;
use PDOException;
use src\Models\User;

class  UserRepository extends Repository {

    /**
     * @param string $id
     * @return User|false
     */
    public function getUserById(string $id): User|false {
        $sqlStatement = $this->pdo->prepare('SELECT * FROM users WHERE id=?');
        $result = $sqlStatement->execute([$id]);
        if ($result) {
            $resultSet = $sqlStatement->fetch(PDO::FETCH_ASSOC);
            if ($resultSet) {
                // Create a new User object with the fetched data
                return new User($resultSet);
            }
        }
        return false;
    }

    /**
     * @param string $email
     * @return User|false
     */
    public function getUserByEmail(string $email): User|false {
        $sqlStatement = $this->pdo->prepare('SELECT * FROM users WHERE email=?');

        try {
            $result = $sqlStatement->execute([$email]);
            $resultSet = $sqlStatement->fetch(PDO::FETCH_ASSOC);

            if ($result && $resultSet) {
                return new User($resultSet);
            }
        } catch (PDOException $e) {
            // Handle the exception (log, print, or rethrow)
            error_log('PDOException in getUserByEmail: ' . $e->getMessage());

        }

        return false;
    }

    /**
     * @param string $name
     * @param string $email
     * @param string $passwordDigest
     * @return User|false
     */
    public function saveUser(string $name, string $email, string $passwordDigest): User|false {
        // TODO
        $sqlStatement = $this->pdo->prepare("INSERT INTO users (name, email, password_digest) VALUES (?, ?, ?)");
        $result = $sqlStatement->execute([$name, $email, $passwordDigest]);

        if ($result) {
            $id = $this->pdo->lastInsertId();
            $sqlStatement = "SELECT * FROM users WHERE id = $id";
            $result = $this->pdo->query($sqlStatement);
            return new User($result->fetch());
        }

        return false;
    }

    /**
     * @param int $id
     * @param string $name
     * @param string|null $profilePicture
     * @return bool
     */public function updateUser(int $id, string $name, ?string $profilePicture = null): bool {
            try {
                if ($profilePicture === null) {
                    // If $profilePicture is null, update only the name
                    $sqlStatement = $this->pdo->prepare("UPDATE users SET name=? WHERE id=?");
                    $result = $sqlStatement->execute([$name, $id]);
                } else {
                    // If $profilePicture is not null, update both name and profile_picture
                    $sqlStatement = $this->pdo->prepare("UPDATE users SET name=?, profile_picture=? WHERE id=?");
                    $result = $sqlStatement->execute([$name, $profilePicture, $id]);
                }

                return $result;
            } catch (\PDOException $e) {
                error_log('PDO Error: ' . $e->getMessage());
                return false;
            }
    }


    /**
     * @param string $email
     * @return bool
     */
    public function emailExists(string $email): bool {
        $sqlStatement = $this->pdo->prepare('SELECT COUNT(*) FROM users WHERE email = ?');
        $sqlStatement->execute([$email]);
        return (bool) $sqlStatement->fetchColumn();
    }
}
