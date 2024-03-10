<?php require_once 'header.php'; ?>

<?php require_once 'nav.php' ?>
<?php
use src\Repositories\UserRepository;

// Get the authenticated user if there is one
$authenticatedUser = null;
if (isset($_SESSION['user_id'])) {
    $userRepository = new UserRepository();
    $authenticatedUser = $userRepository->getUserById($_SESSION['user_id']);
}
?>
<div class="mx-auto max-w-4xl sm:px-6 lg:px-8 mt-10">
    <form class="space-y-8" action="/settings/update" method="POST" enctype="multipart/form-data" id="file-upload-form">

        <div class="px-4 py-6">
            <h1 class="font-bold text-xl">Settings</h1>
        </div>
        <input type="hidden" name="id" value="<?= h($authenticatedUser->id) ?? '' ?>">

        <!-- Email Field -->
        <div class="flex px-4 py-2 items-start border-t border-gray-400">
            <label for="email" class="block text-sm font-bold focus:text-gray-400 w-1/3">Email (cannot be changed)</label>
            <input type="email" id="email" name="email" value="<?= h($authenticatedUser->email) ?>" readonly
                   class="mt-1 px-3 border rounded-md w-2/3 border-gray-500 bg-transparent">
        </div>

        <!-- Username Field -->
        <div class="flex px-4 py-2 items-start border-t border-gray-400">
            <label for="username" class="block text-sm font-bold text-gray-400 w-1/3">Username</label>
            <input type="text" id="username" name="username" value="<?= h($authenticatedUser->name) ?>"
                   class="mt-1 px-3 border rounded-md w-2/3 border-gray-500 bg-transparent">
        </div>

        <!-- Photo Field -->
        <div class="flex px-4 py-2 items-start border-t border-gray-400">
            <label for="profile_image" class="block text-sm font-bold text-gray-400 w-1/3">Photo</label>
            <span class="relative inline-block mr-2">
                <img id="previewImage" class="h-8 w-8 rounded-full cover" src="<?= image(h($authenticatedUser->profile_picture)) ?>" alt="">
            </span>
            <input type="file" id="photo" name="profile_picture" class="mt-1 px-3 border rounded-md w-2/3 border-gray-500" onchange="updateImagePreview()">
        </div>

        <!-- Save Button -->
        <div class="flex justify-end px-4 py-2 items-start border-t border-gray-400">
            <input type="submit" value="Save" class="bg-indigo-500 text-white p-2 rounded-md">
        </div>
    </form>

    <script>
        function updateImagePreview() {
            const input = document.getElementById('photo');
            const preview = document.getElementById('previewImage');

            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    updateNavbarImage(e.target.result); // Update profile picture in navigation bar
                };
                reader.readAsDataURL(file);
            } else {
                // Reset to default image if no file is selected
                preview.src = '<?= image(h($authenticatedUser->profile_picture)) ?>';
                updateNavbarImage('<?= image(h($authenticatedUser->profile_picture)) ?>'); // Reset profile picture in navigation bar
            }
        }

        function updateNavbarImage(src) {
            // Update profile picture in navigation bar
            const navbarImage = document.getElementById('navbarImage');
            if (navbarImage) {
                navbarImage.src = src;
            }
        }

    </script>
</div>
<style>
    #file-upload-form input[type='submit'] {
        cursor: pointer;
    }
</style>