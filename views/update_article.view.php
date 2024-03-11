<?php require_once 'header.php'; ?>
<?php require_once 'nav.php'; ?>

<body>

<div class="grid grid-cols-12 mt-20">
    <form class="space-y-6 col-start-4 col-span-6" action="/articles/update" method="POST">
        <h2 id="page-title" class="text-3xl text-center font-semibold text-indigo-600 mt-10">Edit Article</h2>
        <br>
        <div class="rounded-md">
            <input type="hidden" name="id" value="<?= h($article->id) ?? '' ?>">

            <div>
                <span class="error text-red-500"><?= isset($_GET['title_error']) ? h($_GET['title_error']) : '' ?></span>
                <label for="article_title"  class="block text-xl font-semibold leading-6 text-white">Article Title</label>
                <div class="mt-2">
                <input id="article_title" name="article_title" type="text" class="block w-full rounded-md border-0 py-1.5 text-gray-400 shadow-sm ring-1 ring-inset ring-white placeholder:text-gray-800 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Article Title" value="<?= h($article->title) ?? '' ?>">
                </div>
            </div>


            <div class="mt-6">
                <span class="error text-red-500"><?= isset($_GET['url_error']) ? h($_GET['url_error']) : '' ?></span>
                <label for="article_url" class="block text-xl font-semibold leading-6 text-white">Article URL</label>
                <div class="mt-2">
                <input id="article_url" name="article_url" type="text" class="block w-full rounded-md border-0 py-1.5 text-gray-400 shadow-sm ring-1 ring-inset ring-white placeholder:text-gray-800 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Article URL" value="<?= h($article->url) ?? '' ?>">
                </div>
            </div>
        </div>
        <?php if (isset($error) && $error): ?>
            <p style="color: red;"><?= h($error); ?></p>
        <?php endif; ?>
        <div>
            <button type="submit" class="mt-6 w-full btn btn-primary">
                Update Article
            </button>
        </div>
    </form>

</div>

</body>
