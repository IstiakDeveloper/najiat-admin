<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Bookshop</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @livewireStyles

    <!-- Your custom styles go here -->
    <style>
        /* Add your custom styles here */
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            font-family: 'Arial', sans-serif; /* Example font-family, replace with your preferred font */
            background-color: #f7f7f7; /* Light background color */
        }

        main {
            flex: 1;
        }

        nav {
            background-color: #393280; /* Primary Color */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        nav a:hover {
            border-bottom: 2px solid transparent;
            transition: border-bottom 0.3s ease-in-out;
        }

        nav .logo:hover {
            border-bottom: none;
            transition: border-bottom 0.3s ease-in-out;
        }

        nav a:hover,
        nav a:focus {
            border-bottom-color: #fff;
        }

        #toggleBtn:hover,
        #closeBtn:hover {
            color: #f8f8f8;
        }

        #mobileMenu a:hover {
            background-color: #1a365d; /* Change the background color on hover */
        }

        /* Top Bar Styles */
        .top-bar {
            background-color: #f9cea1; /* White background */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .top-bar a {
            color: #393280; /* Primary Color */
        }

        .top-bar a:hover {
            color: #ED553B; /* Secondary Color */
        }

        /* Main Content Section Styles */
        .content-section {
            background-color: #fff; /* White background */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Search Bar Styles */
        .search-bar {
            background-color: #f8f8f8; /* Light gray background */
            border-radius: 25px; /* Adjust as needed */
            display: flex;
            align-items: center;
            margin: 0 auto;
            padding: 0 10px;
        }

        .search-input {
            border: none;
            outline: none;
            flex: 1;
            padding: 8px;
            border-radius: 25px; /* Rounded corners on the left */
        }

        .search-icon {
            color: #393280; /* Primary Color */
            margin-right: 8px;
        }

        /* Footer Styles */
        footer {
            background-color: #393280; /* Primary Color */
            color: #fff;
        }
    </style>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>

</head>

<body class="font-sans flex flex-col min-h-screen">

    <!-- Top Bar for Contact Info and User Actions -->
    <div class="top-bar p-2">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Contact Info -->
            <p class="text-gray-700">Contact: info@example.com</p>

            <!-- User Actions (Login/Signup, Profile) -->
            <div class="flex items-center space-x-4">
                <a href="#" class="text-gray-700">Login</a>
                <a href="#" class="text-gray-700">Signup</a>
                <a href="#" class="text-gray-700">
                    <i class="fas fa-user"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Navigation Bar -->
    <nav class="bg-primary p-4">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Logo -->
            <a href="#" class="flex items-center text-white text-2xl font-bold logo focus:text-white focus:outline-none">
                <img src="{{asset('logo.png')}}" alt="Najiat.com" class="h-12 mr-2 p-2 bg-gray-50 rounded-full ">
                Najiat.com
            </a>

            <!-- Search Bar -->
            <div class="search-bar">
                <i class="fas fa-search search-icon"></i>
                <input type="text" placeholder="Search..." class="search-input">
            </div>

            <!-- Responsive Navigation -->
            <div class="lg:hidden">
                <button id="toggleBtn" class="text-white focus:outline-none">
                    <i class="fas fa-bars"></i>
                </button>
            </div>

            <!-- Navigation Links with Icons -->
            <div class="hidden lg:flex space-x-4 items-center">
                <a href="#" class="text-white flex items-center">
                    <i class="fas fa-home mr-2"></i> Home
                </a>
                <a href="#" class="text-white flex items-center">
                    <i class="fas fa-book mr-2"></i> Books
                </a>
                <!-- Add more navigation links with icons as needed -->
            </div>
        </div>
    </nav>

    <!-- Responsive Navigation Menu (Hidden by default) -->
    <div id="mobileMenu" class="lg:hidden fixed inset-0 bg-purple-900 bg-opacity-75 z-50 hidden">
        <div class="flex justify-end p-4">
            <button id="closeBtn" class="text-white">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="flex flex-col items-center">
            <a href="#" class="text-white py-2 hover:bg-secondary flex items-center">
                <i class="fas fa-home mr-2"></i> Home
            </a>
            <a href="#" class="text-white py-2 hover:bg-secondary flex items-center">
                <i class="fas fa-book mr-2"></i> Books
            </a>
            <!-- Add more navigation links with icons as needed -->
        </div>

        <!-- Contact Info and User Actions (Mobile) -->
        <div class="flex flex-col items-center mt-4">
            <p class="text-white mb-2">Contact: info@example.com</p>
            <a href="#" class="text-white mb-2">Login</a>
            <a href="#" class="text-white mb-4">Signup</a>
            <a href="#" class="text-white">
                <i class="fas fa-user"></i>
            </a>
        </div>
    </div>

    <!-- Content Section -->
    <main class="container mx-auto my-8 rounded-md">
        <!-- Your content goes here -->
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-primary text-white p-4 mt-auto">
        <div class="container mx-auto text-center">
            <!-- Your footer content goes here -->
            <p>&copy; 2023 Your Bookshop. All rights reserved.</p>
        </div>
    </footer>



    <script>
        // JavaScript for toggling the mobile navigation menu
        document.getElementById('toggleBtn').addEventListener('click', function () {
            document.getElementById('mobileMenu').classList.toggle('hidden');
        });

        document.getElementById('closeBtn').addEventListener('click', function () {
            document.getElementById('mobileMenu').classList.add('hidden');
        });

        // Close the mobile menu when clicking anywhere outside of it
        document.addEventListener('click', function (event) {
            if (!event.target.closest('#mobileMenu') && !event.target.closest('#toggleBtn')) {
                document.getElementById('mobileMenu').classList.add('hidden');
            }
        });
    </script>


    @livewireScripts
</body>

</html>
