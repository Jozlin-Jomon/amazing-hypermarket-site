<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amazing Hypermarket - Sign Up</title>
    <link rel="icon" href="{{ asset('img/logos/amzlogo2.svg') }}" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        html,
        body {
            height: 100%;
            overflow: hidden;
        }

        .bg-shopping {
            background-image: url('https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1600&q=80');
            background-size: cover;
            background-position: center;
        }

        .form-container {
            max-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .form-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
    </style>
</head>

<body class="h-full">
    <div class="flex h-full">

        <div class="hidden md:block md:w-1/2 bg-shopping relative">
            <div class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center">
                <div class="text-white p-8 text-center">
                    <h2 class="text-4xl font-bold mb-4">Join Our Community</h2>
                    <p class="text-xl">Enjoy exclusive benefits and amazing deals</p>
                </div>
            </div>
        </div>


        <div class="w-full md:w-1/2 p-4 bg-white">
            <div class="form-container h-full mx-auto max-w-md">
                <div class="text-center mb-4 pt-4">
                <a href="{{ route('index') }}"><h1 class="text-3xl font-bold text-red-600 mb-2">AMAZING HYPERMARKET</h1></a>
                    <p class="text-gray-600">Create your account to start shopping</p>
                </div>

                <div class="form-content">
                    <form class="space-y-4" id="signupForm">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="first-name" class="block text-gray-700 font-medium mb-1 text-sm">First
                                    Name</label>
                                <input type="text" id="first-name" name="first_name"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600"
                                    placeholder="Enter First Name" required>
                            </div>
                            <div>
                                <label for="last-name" class="block text-gray-700 font-medium mb-1 text-sm">Last
                                    Name</label>
                                <input type="text" id="last-name" name="last_name"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600"
                                    placeholder="Enter Last Name" required>
                            </div>
                        </div>

                        <div>
                            <label for="email" class="block text-gray-700 font-medium mb-1 text-sm">Email
                                Address</label>
                            <input type="email" id="email" name="email"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600"
                                placeholder="Enter Your Email" required autocomplete="new-email">
                        </div>

                        <div>
                            <label for="phone" class="block text-gray-700 font-medium mb-1 text-sm">Contact Number</label>
                            <input type="phone" id="phone" name="phone"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600"
                                placeholder="Enter Your Phone" required>
                        </div>

                        <div class="relative">
                            <label for="password" class="block text-gray-700 font-medium mb-1 text-sm">Password</label>
                            <input type="password" id="password" name="password"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600"
                                placeholder="••••••••" required autocomplete="new-password">
                            <span class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer"
                                onclick="togglePassword('password')">
                                <i class="fas fa-eye"></i>
                            </span>
                            <p class="mt-1 text-xs text-gray-500">Must be at least 8 characters</p>
                        </div>

                        <div class="relative">
                            <label for="confirm-password" class="block text-gray-700 font-medium mb-1 text-sm">Confirm
                                Password</label>
                            <input type="password" id="confirm-password" name="password_confirmation"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600"
                                placeholder="••••••••" required>
                            <span class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer"
                                onclick="togglePassword('confirm-password')">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>

                        <div class="flex items-start pt-2">
                            <input type="checkbox" id="terms" name="terms"
                                class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded mt-1" required>
                            <label for="terms" class="ml-2 block text-gray-700 text-sm">
                                I agree to the <a href="#" class="text-red-600 hover:text-red-800">Terms</a> and <a
                                    href="#" class="text-red-600 hover:text-red-800">Privacy Policy</a>
                            </label>
                        </div>

                        <button type="submit"
                            class="w-full bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-600 focus:ring-offset-2 transition duration-150 font-medium mt-2">
                            Create Account
                        </button>
                        <div id="signupMessage"></div>
                    </form>

                    <div class="text-center mt-4 pb-4">
                        <p class="text-gray-600 text-sm">
                            Already have an account?
                            <a href="{{ route('login') }}" class="text-red-600 hover:text-red-800 font-medium">Log in</a>
                        </p>
                    </div>
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