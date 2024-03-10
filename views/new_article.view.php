<?php require_once 'header.php'; ?>

<body>

    <?php require_once 'nav.php'; ?>

    <div class="grid grid-cols-12 mt-20">


        <form class="space-y-6 col-start-4 col-span-6" action="/articles/store" method="POST">
            <!-- TODO: add inputs for article creation -->
            <div class="rounded-md">
                <h2 id="page-title" class="text-3xl text-center font-semibold text-indigo-600 mt-10">New Article</h2>
                <br>
                <p>The new article page. Handle displaying the new article form and handling article submissions here.</p>
                <br>
                <div>
                    <span class="error text-red-500"><?= isset($_GET['title_error']) ? h($_GET['title_error']) : '' ?></span>
                    <label for="article_title" class="block text-xl font-semibold leading-6 text-white">Article Title</label>
                    <div class="mt-2">
                        <input id="article_title" name="article_title" type="text" class="block w-full rounded-md border-accent/10 py-1.5 px-3 text-gray-400 shadow-sm ring-1 ring-inset ring-indigo-800 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Article Title" required>
                    </div>
                    </div>
                <br>
                <div class="mt-6">
                    <span class="error text-red-500"><?= isset($_GET['url_error']) ? h($_GET['url_error']) : '' ?></span>
                    <label for="article_url" class="block text-xl font-semibold leading-6 text-white">Article URL</label>
                    <div class="mt-2">
                        <input id="article_url" name="article_url" type="text" class="block w-full rounded-md border-accent/10 py-1.5 px-3 text-gray-400 shadow-sm ring-1 ring-inset ring-indigo-800 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Article URL" required>                </div>
                    </div>
                </div>

            <div>
                <input type="hidden" name="id" value="<?= h($authenticatedUser->id) ?? '' ?>">
                <button type="submit" class="mt-6 w-full btn btn-primary">
                    Submit
                </button>
            </div>
        </form>
        </div>



</body>