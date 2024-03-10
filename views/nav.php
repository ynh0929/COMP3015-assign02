<?php

use src\Repositories\UserRepository;

// TODO get the authenticated user if there is one, and conditonally render the appropriate buttons
// If the user is authenticated: show the new article button and logout button
// If we have a guest user: show the login and registration buttons
session_start();
$authenticatedUser = null;
if (isset($_SESSION['user_id'])) {
    $userRepository = new UserRepository();
    $authenticatedUser = $userRepository->getUserById($_SESSION['user_id']);
}
?>

<nav class="bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="flex-shrink-0 flex items-center text-lg text-white">
                    NewCo.
                </div>

                <div class="hidden md:ml-6 md:flex md:items-center md:space-x-4">
                    <a href="/" class="text-white px-3 py-2 rounded-md text-sm font-medium">All Articles</a>
                </div>

                <?php if ($authenticatedUser): ?>
                    <div class="hidden md:ml-6 md:flex md:items-center md:space-x-4">
                        <a href="/articles/create" class="text-white px-3 py-2 rounded-md text-sm font-medium">New Article</a>
                    </div>
                <?php endif; ?>
            </div>

            <div class="flex items-center">
                <?php if ($authenticatedUser): ?>
                    <a href="<?= "/settings?id=$authenticatedUser->id" ?>" class="mt-2">
                    <span class="relative inline-block">
                        <img id="navbarImage" class="h-8 w-8 rounded-full cover" src="<?= image(h($authenticatedUser->profile_picture)) ?>" alt="">
                        <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-green-400 ring-2 ring-white"></span>
                    </span>
                    </a>

                    &nbsp;&nbsp;

                    <div class="flex-shrink-0 text-white">
                        <span>Welcome, <?= h($authenticatedUser->name) ?>!&nbsp;&nbsp;</span>
                    </div>

                    <div>
                        <form id="logout-form" action="/logout" method="POST">
                            <button type="button" onclick="logout()" class="text-white px-3 py-2 rounded-md text-sm font-medium">Logout</button>
                        </form>
                    </div>
                <?php else: ?>
                    <div class="flex float-right">
                        <div class="hidden md:ml-6 md:flex md:items-center md:space-x-4">
                            <a href="/login" class="text-white px-3 py-2 rounded-md text-sm font-medium">Login</a>
                        </div>
                        <div class="hidden md:ml-6 md:flex md:items-center md:space-x-4">
                            <a href="/register" class="text-white px-3 py-2 rounded-md text-sm font-medium">Register</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<script>
    logout = () => {
        document.getElementById('logout-form').submit();
    }


</script>


<style>
    .clickable {
        cursor: pointer;
    }

    .cover {
        object-fit: cover;
    }
</style>
