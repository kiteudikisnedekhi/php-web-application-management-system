<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title . ' - ' : '' ?>HAVMORICE</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .loading {
            display: none;
        }
        .loading.active {
            display: flex;
        }
    </style>

    <!-- Custom Tailwind Configuration -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#FF6B6B',
                        secondary: '#4ECDC4',
                        dark: '#2C3E50',
                        light: '#ECF0F1'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 text-gray-900">
    <!-- Loading Overlay -->
    <div class="loading fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center">
        <div class="bg-white p-4 rounded-lg shadow-lg flex items-center space-x-3">
            <i class="fas fa-spinner fa-spin text-primary text-2xl"></i>
            <span>Loading...</span>
        </div>
    </div>

    <!-- Navigation Header -->
    <?php if ($isLoggedIn): ?>
    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="/dashboard" class="text-2xl font-bold text-primary">
                            HAVMORICE
                        </a>
                    </div>
                </div>
                <div class="flex items-center">
                    <a href="/wallet" class="p-2 text-gray-600 hover:text-primary">
                        <i class="fas fa-wallet"></i>
                    </a>
                    <a href="/cart" class="p-2 text-gray-600 hover:text-primary">
                        <i class="fas fa-shopping-cart"></i>
                    </a>
                    <div class="ml-3 relative">
                        <button type="button" class="profile-menu-button bg-white rounded-full flex text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                            <i class="fas fa-user-circle text-2xl text-gray-600"></i>
                        </button>
                        <!-- Profile dropdown panel -->
                        <div class="profile-menu hidden origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                            <a href="/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Profile</a>
                            <a href="/orders" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Orders</a>
                            <a href="/addresses" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Addresses</a>
                            <a href="/referral" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Refer & Earn</a>
                            <a href="/logout" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100" role="menuitem">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <?php endif; ?>

    <!-- Main Content -->
    <main class="min-h-screen">
        <?= $content ?>
    </main>

    <!-- Footer Navigation for Mobile -->
    <?php if ($isLoggedIn): ?>
    <nav class="fixed bottom-0 w-full bg-white border-t border-gray-200 md:hidden">
        <div class="grid grid-cols-5">
            <a href="/dashboard" class="flex flex-col items-center justify-center p-2 text-gray-600 hover:text-primary">
                <i class="fas fa-home text-lg"></i>
                <span class="text-xs mt-1">Home</span>
            </a>
            <a href="/categories" class="flex flex-col items-center justify-center p-2 text-gray-600 hover:text-primary">
                <i class="fas fa-th-large text-lg"></i>
                <span class="text-xs mt-1">Categories</span>
            </a>
            <a href="/cart" class="flex flex-col items-center justify-center p-2 text-gray-600 hover:text-primary">
                <i class="fas fa-shopping-cart text-lg"></i>
                <span class="text-xs mt-1">Cart</span>
            </a>
            <a href="/wallet" class="flex flex-col items-center justify-center p-2 text-gray-600 hover:text-primary">
                <i class="fas fa-wallet text-lg"></i>
                <span class="text-xs mt-1">Wallet</span>
            </a>
            <a href="/profile" class="flex flex-col items-center justify-center p-2 text-gray-600 hover:text-primary">
                <i class="fas fa-user text-lg"></i>
                <span class="text-xs mt-1">Profile</span>
            </a>
        </div>
    </nav>
    <?php endif; ?>

    <!-- JavaScript -->
    <script>
        // Toggle profile menu
        const profileButton = document.querySelector('.profile-menu-button');
        const profileMenu = document.querySelector('.profile-menu');
        
        if (profileButton && profileMenu) {
            profileButton.addEventListener('click', () => {
                profileMenu.classList.toggle('hidden');
            });

            // Close menu when clicking outside
            document.addEventListener('click', (e) => {
                if (!profileButton.contains(e.target) && !profileMenu.contains(e.target)) {
                    profileMenu.classList.add('hidden');
                }
            });
        }

        // Show loading overlay
        function showLoading() {
            document.querySelector('.loading').classList.add('active');
        }

        // Hide loading overlay
        function hideLoading() {
            document.querySelector('.loading').classList.remove('active');
        }

        // Handle AJAX errors
        function handleAjaxError(error) {
            hideLoading();
            alert(error.message || 'An error occurred. Please try again.');
        }
    </script>
</body>
</html>
