<?php
require_once 'header.php';
?>

<?php

use src\Repositories\ArticleRepository;
use src\Repositories\UserRepository;

$articleRepository = new ArticleRepository();
$articles = $articleRepository->getAllArticles();
$userRepository = new UserRepository();
?>

<body>

<?php require_once 'nav.php' ?>

<div class="mx-auto max-w-4xl sm:px-6 lg:px-8">

    <h1 class="text-xl text-center font-semibold text-indigo-500 mt-10 mb-10 title">Articles</h1>

    <?php if (isset($articles)): ?>
        <h6 class="text-center"><?= count($articles) === 0 ? "No articles yet :(" : ""; ?></h6>

        <div class="sm:rounded-md">
            <ul role="list" class="mb-20">
                <?php foreach ($articles as $article) : ?>
                    <?php
                    // Check if the user is logged in
                    if (isset($_SESSION['user_id'])) {
                        // Get the currently logged-in user
                        $authenticatedUser = $userRepository->getUserById($_SESSION['user_id']);

                        // Check if the logged-in user is the author of the article
                        $isAuthor = ($article->author_id == $authenticatedUser->id);
                    } else {
                        $isAuthor = false;
                    }

                    // Fetch the author using user_id
                    $author = $userRepository->getUserById($article->author_id);
                    ?>

                    <!-- Display your article content here -->
                    <div class="card w-full bg-black shadow-xl mt-10">
                        <div class="card-body">
                            <h3 class="card-title text-purple-600">
                                <a href="<?= $article->url; ?>" target="_blank" class="article-link"><?= $article->title; ?></a>
                            </h3>

                            <?php
                            // Convert to DateTime objects
                            $created_at_date = new DateTime($article->created_at);
                            $updated_at_date = new DateTime($article->updated_at);

                            // Format the timestamps
                            $formatted_created_at = $created_at_date->format('l jS \of F Y, h:i A');
                            $formatted_updated_at = $updated_at_date->format('l jS \of F Y, h:i A');
                            ?>

                            <!-- Created At -->
                            <div class="flex items-center mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar mr-1" viewBox="0 0 16 16">
                                    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z"></path>
                                </svg>
                                <p class="ml-1">Created At: <?= h($formatted_created_at); ?></p>
                            </div>

                            <!-- Updated At -->
                            <?php if ($article->updated_at !== null): ?>
                                <div class="flex items-center mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar mr-1" viewBox="0 0 16 16">
                                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z"></path>
                                    </svg>
                                    <p class="ml-1">Updated At: <?= h($formatted_updated_at); ?></p>
                                </div>
                            <?php endif; ?>

                            <?php
                            // Fetch the author using user_id
                            $author = $userRepository->getUserById($article->author_id);
                            ?>

                            <div class="relative flex items-center">
                                <!-- Display author's profile picture -->
                                <img class="h-8 w-8 rounded-full cover" src="<?= image(h($author->profile_picture) ?? 'default.jpg') ?>" alt="">
                                <span class="absolute top-0 right-0 block h-2 w-2 rounded-full"></span>
                                <!-- Display author's name -->
                                <p class="ml-2">Posted By: <?= h($author->name) ?></p>
                            </div>

                            <div class="flex justify-between">
                                <div></div>
                                <div></div>
                                <div class="justify-end">
                                    <?php if ($isAuthor): ?>
                                        <form action="/articles/edit" method="get" class="inline-block">
                                            <input type="hidden" name="id" value="<?= h($article->id); ?>">
                                            <button type="submit">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-block action-icon">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                </svg>
                                            </button>
                                        </form>

                                        <form action="/articles/delete" method="post" class="inline-block" onsubmit="return confirmDelete()">
                                            <input type="hidden" name="id" value="<?= h($article->id); ?>">
                                            <button type="submit" class="inline-block">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="red" class="w-6 h-6 inline-block action-icon">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                </svg>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <script>
        function confirmDelete() {
            var confirmDelete = confirm("Are you sure you want to delete this article?");
            return confirmDelete;
        }
    </script>
</div>

</body>