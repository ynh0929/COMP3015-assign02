<?php

namespace src\Repositories;

use PDO;
use PDOException;
use src\Models\Article as Article;
use src\Models\User;

class ArticleRepository extends Repository {

	/**
	 * @return Article[]
	 */
	public function getAllArticles(): array {
		// TODO
        $sqlStatement = $this->pdo->prepare('SELECT * FROM articles');
        $sqlStatement->execute();
        $rows = $sqlStatement->fetchAll();

        $articles = [];
        foreach ($rows as $row) {
            $articles[] = new Article($row);
        }

        return $articles;
	}

	/**
	 * @param string $title
	 * @param string $url
	 * @param string $authorId
	 * @return Article|false
	 */
	public function saveArticle(string $title, string $url, string $authorId): Article|false {
		// TODO
        $user = $this->getArticleAuthor($authorId);

        if (!$user) {
            error_log("Invalid author_id: $authorId");

            return false; // User does not exist
        }
        $createdAt = date('Y-m-d H:i:s');
        $sqlStatement = $this->pdo->prepare('INSERT INTO articles (title, url, created_at, author_id) VALUES (?, ?, ?, ?)');
        $result = $sqlStatement->execute([$title, $url, $createdAt, $user->id]);

        if ($result) {
            $articleId = $this->pdo->lastInsertId();
            return $this->getArticleById($articleId);
        }

        return false;
	}

	/**
	 * @param int $id
	 * @return Article|false Article object if it was found, false otherwise
	 */
	public function getArticleById(int $id): Article|false {
        // TODO
        $sqlStatement = $this->pdo->prepare('SELECT * FROM articles WHERE id = ?');
        $result = $sqlStatement->execute([$id]);
        if ($result) {
            $resultSet = $sqlStatement->fetch();
            return new Article($resultSet);
        }

        return false;
	}

	/**
	 * @param int $id
	 * @param string $title
	 * @param string $url
	 * @return bool true on success, false otherwise
	 */
	public function updateArticle(int $id, string $title, string $url): bool {
		// TODO
        // Fetch the existing article data
        $existingArticle = $this->getArticleById($id);

        if (!$existingArticle) {
            return false; // Article does not exist
        }
        $updatedAt = date('Y-m-d H:i:s');
        $sqlStatement = $this->pdo->prepare('UPDATE articles SET title = ?, url = ?, updated_at = ? WHERE id = ?');
        $result =  $sqlStatement->execute([$title, $url, $updatedAt, $existingArticle->id]);
        if($result && $sqlStatement->rowCount() > 0){
            return true;
        }
        return false;
	}

	/**
	 * @param int $id
	 * @return bool true on success, false otherwise
	 */
	public function deleteArticleById(int $id): bool {
		// TODO
        $sqlStatement = $this->pdo->prepare('DELETE FROM articles WHERE id = ?');
        $result = $sqlStatement->execute([$id]);
        if($result){
            return true;
        }
        return false;
	}

	/**
	 * @param string $articleId
	 * @return User|false
	 */
	public function getArticleAuthor(string $articleId): User|false {
		// TODO
        $sqlStatement = $this->pdo->prepare('SELECT * FROM users WHERE id = ?');

        $sqlStatement->execute([$articleId]);

        $result = $sqlStatement->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            return new User($result);
        }

        return false;
	}

}
