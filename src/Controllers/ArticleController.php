<?php

namespace src\Controllers;

use core\Request;
use src\Repositories\ArticleRepository;

class ArticleController extends Controller
{

	/**
	 * Display the page showing the articles.
	 * @return void
	 */
	public function renderIndexPage(): void
	{
		$articles = (new ArticleRepository)->getAllArticles();
        $this->render('index', [
            'articles' => $articles,
        ]);	}

	public function about(): void
	{
		$this->render('about', ['articles' => []]);
	}

	/**
	 * Process the storing of a new article.
	 * @return void
	 */
	public function create(): void
	{
		// TODO
        $this->render('/new_article');
	}

	public function store(Request $request)
	{
		// TODO
        // Check if the user is authenticated
        if (!isset($_SESSION['user_id'])) {
            // Redirect to the login page
            $this->redirect('/login');
        }

        $title = $request->input('article_title');
        $url = $request->input('article_url');
        $authorId = $request->input('id');

//        $title = $_POST['article_title'];
//        $url = $_POST['article_url'];
//        $authorId = $_POST['id'];

        $articleRepository = new ArticleRepository();
        $articleRepository->saveArticle($title, $url, $authorId);

        $this->redirect('/');
	}

	/**
	 * Show the form for editing an article.
	 * @param Request $request
	 * @return void
	 */
	public function edit(Request $request): void
	{
		// TODO
       $articleId = $request->input('id');
        $article = (new ArticleRepository)->getArticleById($articleId);

        // Check if the article exists and the user has permission to edit
        if ($article) {
            $this->render('update_article', ['article' => $article]);
        } else {
            // Redirect or handle unauthorized access
            $this->redirect('/');
        }
	}

	/**
	 * Process the editing of an article.
	 * @param Request $request
	 * @return void
	 */
	public function update(Request $request): void
	{
		// TODO
        $articleId = $request->input('id');
        $title = $request->input('article_title');
        $url = $request->input('article_url');

//        $articleId = $_POST['id'];
//        $title = $_POST['article_title'];
//        $url = $_POST['article_url'];

        // Fetch the existing article data
        $articleRepository = new ArticleRepository();
        $article = $articleRepository->getArticleById($articleId);

        // Validate title and URL using helper functions
        $titleError = validTitle($title) ? '' : 'Title should be at least 3 characters';
        $urlError = validURL($url) ? '' : 'Invalid URL';

        if (!empty($titleError) || !empty($urlError)) {
            // Render the update_article view with error messages
            $this->render('update_article', [
                'error' => 'Invalid title or URL',
                'title_error' => $titleError,
                'url_error' => $urlError,
                'article' => $article,
            ]);
            return;
        }
        $articleRepository->updateArticle($articleId, $title, $url);

        // Redirect to the index page after updating the article
        $this->redirect('/');
	}

	/**
	 * Process the deleting of an article.
	 * @param Request $request
	 * @return void
	 */
	public function delete(Request $request): void
	{
		// TODO
        $articleId = $request->input('id');

        //$articleId = $_POST['id'];

        $articleRepository = new ArticleRepository();
        $articleRepository->deleteArticleById($articleId);

        // Redirect to the index page after deleting the article
        $this->redirect('/');
	}
}
