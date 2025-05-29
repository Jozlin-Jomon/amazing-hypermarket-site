<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amazing Hypermarket - Admin Login</title>
    <link rel="icon" href="{{ asset('img/logos/amzlogo2.svg') }}" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        html, body {
            height: 100%;
            overflow: hidden;
        }

        .bg-admin {
            background-image: url('https://images.unsplash.com/photo-1581091870622-1e7e94fda7b5?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>

<body class="h-full">
    <div class="flex h-full">
        <div class="hidden md:block md:w-1/2 bg-admin relative">
            <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                <div class="text-white p-8 text-center">
                    <h2 class="text-4xl font-bold mb-4">Admin Access Portal</h2>
                    <p class="text-xl">Secure management access for Amazing Hypermarket</p>
                </div>
            </div>
        </div>

        <div class="w-full md:w-1/2 flex items-center justify-center p-4 bg-white">
            <div class="w-full max-w-md">
                <div class="text-center mb-8">
                    <a href="{{ route('index') }}"><h1 class="text-3xl font-bold text-blue-700 mb-2">ADMIN LOGIN</h1></a>
                    <p class="text-gray-600">Authorized personnel only</p>
                </div>
                <form class="space-y-6" id="adminLoginForm">
                    @csrf
                    <div>
                        <label for="admin_email" class="block text-gray-700 font-medium mb-2">Admin Email</label>
                        <input type="email" id="admin_email" name="email"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-700"
                            placeholder="Enter Admin Email" required autocomplete="new-email">
                    </div>

                    <div>
                        <label for="admin_password" class="block text-gray-700 font-medium mb-2">Password</label>
                        <div class="relative">
                            <input type="password" id="admin_password" name="password"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-700"
                                placeholder="••••••••" required autocomplete="new-password">
                            <span class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer"
                                onclick="togglePassword('admin_password')">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input type="checkbox" id="admin_remember"
                                class="h-4 w-4 text-blue-700 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="admin_remember" class="ml-2 block text-gray-700">Remember me</label>
                        </div>

                        <a href="#" class="text-blue-700 hover:text-blue-900 font-medium">Forgot password?</a>
                    </div>

                    <button type="submit"
                        class="w-full bg-blue-700 text-white py-3 px-4 rounded-lg hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:ring-offset-2 transition duration-150 font-medium">
                        Login as Admin
                    </button>
                    <div id="adminLoginMessage"></div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Custom JS -->
    <script src="{{ asset('js/auth.ajax.js') }}"></script>
    <script>
        function togglePassword(id) {
            const input = document.getElementById(id);
            const type = input.type === 'password' ? 'text' : 'password';
            input.type = type;
        }
    </script>
</body>

</html>
