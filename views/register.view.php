<?php require_once 'header.php' ?>

<body>
    <div>
        <div class="card w-96 bg-base-100 bg-slate-900 mx-auto mt-20">
            <div class="card-body">
                <h2 class="card-title text-white mx-auto">NewCo. Registration</h2>
                <div>
                    <div class="py-8">

                        <form class="space-y-6" action="/register" method="POST">

                            <div>
                                <label for="name" class="text-white"> Name </label>
                                <div class="mt-1">
                                    <input id="name" name="name" type="text" placeholder="Your name" autocomplete="name" required class="input input-bordered w-full max-w-xs">
                                    <?php if (isset($name_error)): ?>
                                        <span style="color: red;"><?php echo h($name_error); ?></span>
                                    <?php endif; ?>

                                </div>
                            </div>

                            <div>
                                <label for="email" class="text-white"> Email address </label>
                                <div class="mt-1">
                                    <input id="email" name="email" type="email" placeholder="Your email" autocomplete="email" required class="input input-bordered w-full max-w-xs">
                                    <?php if (isset($email_error)): ?>
                                        <span style="color: red;"><?php echo h($email_error); ?></span>
                                    <?php endif; ?>
                                    <?php if (isset($exist_error)): ?>
                                        <span style="color: red;"><?php echo h($exist_error); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div>
                                <label for="password" class="text-white"> Password </label>
                                <div class="mt-1">
                                    <input id="password" name="password" type="password" placeholder="Your password" autocomplete="current-password" required class="input input-bordered w-full max-w-xs">
                                    <?php if (isset($password_error)): ?>
                                        <span style="color: red;"><?php echo h($password_error); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    Already have an account?&nbsp;&nbsp;
                                    <a href="/login" class="font-medium text-indigo-600 hover:text-indigo-500">
                                        Login
                                    </a>
                                </div>
                            </div>

                            <div>
                                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Register
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</body>

<style>
    .background {
        background-color: #0F2339;
    }
</style>