<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amazing Hypermarket - Login</title>
    <link rel="icon" href="{{ asset('img/logos/amzlogo2.svg') }}" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        html,
        body {
            height: 100%;
            overflow: hidden;
        }

        .bg-shopping {
            background-image: url('https://images.unsplash.com/photo-1555529669-e69e7aa0ba9a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1600&q=80');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>

<body class="h-full">
    <div class="flex h-full">
        <div class="hidden md:block md:w-1/2 bg-shopping relative">
            <div class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center">
                <div class="text-white p-8 text-center">
                    <h2 class="text-4xl font-bold mb-4">Amazing Shopping Experience</h2>
                    <p class="text-xl">Your one-stop destination for all your daily needs</p>
                </div>
            </div>
        </div>
        
        <div class="w-full md:w-1/2 flex items-center justify-center p-4 bg-white">
            <div class="w-full max-w-md">
                <div class="text-center mb-8">
                    <a href="{{ route('index') }}"><h1 class="text-3xl font-bold text-red-600 mb-2">AMAZING HYPERMARKET</h1></a>
                    <p class="text-gray-600">Welcome back! Please login to your account</p>
                </div>
                <form class="space-y-6" id="loginForm">
                    @csrf
                    <div>
                        <label for="email" class="block text-gray-700 font-medium mb-2">Email Address</label>
                        <input type="email" id="email" name="email"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600"
                            placeholder="Enter Your Email" required autocomplete="new-email">
                    </div>

                    <div>
                        <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
                        <div class="relative">
                            <input type="password" id="password" name="password"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600"
                                placeholder="••••••••" required autocomplete="new-password">
                            <span class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer"
                                onclick="togglePassword('password')">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input type="checkbox" id="remember"
                                class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                            <label for="remember" class="ml-2 block text-gray-700">Remember me</label>
                        </div>

                        <a href="#" class="text-red-600 hover:text-red-800 font-medium">Forgot password?</a>
                    </div>

                    <button type="submit"
                        class="w-full bg-red-600 text-white py-3 px-4 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-600 focus:ring-offset-2 transition duration-150 font-medium">
                        Login
                    </button>
                    <div id="loginMessage"></div>
                </form>

                <div class="mt-8 text-center">
                    <p class="text-gray-600">
                        Don't have an account?
                        <a href="{{ route('signup') }}" class="text-red-600 hover:text-red-800 font-medium">Sign up</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- custom JS -->

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