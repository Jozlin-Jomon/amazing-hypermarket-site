<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Amazing Hypermarket</title>
  <link rel="icon" href="{{ asset('img/logos/amzlogo2.svg') }}" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.12.0/cdn.min.js" defer></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="{{ asset('css/style.css')}}">
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#0053e2',
            darkblue: '#002e99',
          }
        }
      }
    };
  </script>
</head>

<body class="bg-gray-50 siteHeader">
  <!-- Desktop Navigation Bar -->
  <div id="siteHeader"
    class="flex flex-col min-h-screen pt-0 lg:pt-0 lg:bg-[#f6f6f6] sm:bg-[#f6f6f6] lg:bg-none bg-no-repeat bg-contain xs:pt-0 max-w-[1920px] mx-auto">
    <header
      class="hidden lg:flex lg:sticky inset-x-0 lg:-top-[72px] z-30 w-full items-center backdrop-blur bg-white transition-all duration-300 sm:px-[20px] mx-auto border-b border-[#f1f1f1]">

      <div class="container mx-auto py-3 flex items-center justify-between">
        <!-- Logo -->
        <div class="flex items-center">
          <a href="#" class="mr-8">
            <img src="{{ asset('img/logos/amzlogo1.svg') }}" alt="Amazing Hypermarket Logo" class="h-12">
          </a>
        </div>

        <!-- Location Selector -->
        <div class="flex items-center text-gray-700 mr-2">
          <div class="flex items-center bg-white rounded-md">
            <div class="bg-amazing-red p-2 rounded-full">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
            </div>
            <div class="ml-2">
              <p class="text-sm font-semibold">Delivery to</p>
              <p class="text-sm">Aluva - 683101</p>
            </div>
          </div>
        </div>

        <!-- Search -->
        <div class="flex-1 max-w-xl mx-4">
          <div class="relative">
            <input type="text" placeholder="What are you looking for?"
              class="w-full border border-gray-300 rounded-md py-2 px-4 focus:outline-none focus:ring-2 focus:ring-green-300">
            <button class="absolute right-0 top-0 bottom-0 px-3">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
            </button>
          </div>
        </div>

        @auth
        <!-- Profile and Cart -->
        <div class="flex items-center space-x-4">
          <a href="#" class="flex items-center">
            <div class="bg-amazing-red p-2 rounded-full">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
              </svg>
            </div>
            <span class="ml-1">Profile</span>
          </a>
          <a href="#" class="flex items-center">
            <div class="bg-amazing-red p-2 rounded-full relative">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
              </svg>
              <span
                class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full text-xs w-5 h-5 flex items-center justify-center font-bold">0</span>
            </div>
            <span class="ml-1">My Cart</span>
          </a>
          <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="flex items-center text-purple-600 hover:text-purple-800">
                  <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                  </svg>
                  Logout
              </button>
          </form>
        </div>
        @endauth

        @guest
        <!-- Profile and Cart -->
        <div class="flex items-center space-x-4">
          <a href="{{ route('login') }}" class="flex items-center">
            <div class="bg-amazing-red p-2 rounded-full">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
              </svg>
            </div>
            <span class="ml-1">Login</span>
          </a>
          <a href="{{ route('login') }}" class="flex items-center">
            <div class="bg-amazing-red p-2 rounded-full relative">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
              </svg>
              <span
                class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full text-xs w-5 h-5 flex items-center justify-center font-bold">0</span>
            </div>
            <span class="ml-1">My Cart</span>
          </a>
          
        </div>
        @endguest


      </div>
    </header>


    <!-- Category Navigation -->
    <div id="siteHeader" class="hidden sm:block lg:block  sticky -top-[1px] z-20">
      <div
        class="menu relative hidden items-center 2xl:gap-[56px] xl:gap-[2rem] lg:gap-[35px] sm:px-[20px] lg:flex sm:flex xs:px-[16px] 2xl:px-[80px] lg:px-[26px] xl:px-[50px] shadow-top-header bg-white boreder-b border-[]">
        <div class="container mx-auto px-4">
          <div class="flex items-center space-x-8">
            <button class="py-4 flex items-center space-x-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
              </svg>
              <span>All</span>
            </button>

            <div class="py-4 flex items-center space-x-2 cursor-pointer border-b-2 category-nav"
              data-target="grocery-fresh">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17" />
              </svg>
              <span class="amazing-green font-medium">Grocery & Fresh</span>
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 amazing-green transform transition-transform"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </div>

            <div class="py-4 flex items-center space-x-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
              </svg>
              <span>Offers</span>
            </div>
            @auth
            
            <div class="flex flex-wrap gap-4 mt-4">
              <a href="/orders" class="bg-white px-4 py-2 rounded shadow flex items-center">
                  <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                  </svg>
                  My Orders
              </a>
              <a href="/wishlist" class="bg-white px-4 py-2 rounded shadow flex items-center">
                  <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                  </svg>
                  Wishlist
              </a>
            </div>
            @endauth
          </div>
        </div>
      </div>

      <!-- Mega Menu - Grocery & Fresh -->
      <div id="grocery-fresh" class="mega-menu bg-white shadow-lg border-t border-gray-200">
        <div class="container mx-auto px-4 py-6">
          <div class="grid grid-cols-5 gap-8">
            <!-- Column 1 -->
            <div>
              <h3 class="text-green-600 font-medium text-lg mb-4">Fruits & Vegetables</h3>
              <ul class="space-y-3">
                <li><a href="#" class="hover:text-green-600">Fresh Vegetables</a></li>
                <li><a href="#" class="hover:text-green-600">Fresh Fruits</a></li>
              </ul>

              <h3 class="text-green-600 font-medium text-lg mt-8 mb-4">Dairy & Ice Creams</h3>
              <ul class="space-y-3">
                <li><a href="#" class="hover:text-green-600">Fresh Dairy</a></li>
              </ul>

              <h3 class="text-green-600 font-medium text-lg mt-8 mb-4">Breakfast & Instant Foods</h3>
              <ul class="space-y-3">
                <li><a href="#" class="hover:text-green-600">Breakfast Cereals</a></li>
              </ul>
            </div>

            <!-- Column 2 -->
            <div>
              <h3 class="text-green-600 font-medium text-lg mb-4">Meat, Fish & Eggs</h3>
              <ul class="space-y-3">
                <li><a href="#" class="hover:text-green-600">Meat</a></li>
                <li><a href="#" class="hover:text-green-600">Fish</a></li>
                <li><a href="#" class="hover:text-green-600">Eggs</a></li>
              </ul>

              <h3 class="text-green-600 font-medium text-lg mt-8 mb-4">Baby Care & Diapers</h3>
              <ul class="space-y-3">
                <li><a href="#" class="hover:text-green-600">Baby Foods</a></li>
                <li><a href="#" class="hover:text-green-600">Baby Diapers & Wipes</a></li>
                <li><a href="#" class="hover:text-green-600">Baby Care</a></li>
              </ul>
            </div>

            <!-- Column 3 -->
            <div>
              <h3 class="text-green-600 font-medium text-lg mb-4">Frozen Foods</h3>
              <ul class="space-y-3">
                <li><a href="#" class="hover:text-green-600">Veg</a></li>
                <li><a href="#" class="hover:text-green-600">Non Veg</a></li>
              </ul>

              <h3 class="text-green-600 font-medium text-lg mt-8 mb-4">Dry Fruits & Nuts</h3>
              <ul class="space-y-3">
                <li><a href="#" class="hover:text-green-600">Nuts</a></li>
                <li><a href="#" class="hover:text-green-600">Dry Fruits</a></li>
              </ul>

              <h3 class="text-green-600 font-medium text-lg mt-8 mb-4">Cooking & Baking Needs</h3>
            </div>

            <!-- Column 4 -->
            <div>
              <h3 class="text-green-600 font-medium text-lg mb-4">Bakery & Breads</h3>
              <ul class="space-y-3">
                <li><a href="#" class="hover:text-blue-600">Bread & Bun</a></li>
                <li><a href="#" class="hover:text-blue-600">Rusk & Toast</a></li>
                <li><a href="#" class="hover:text-blue-600">Savouries</a></li>
                <li><a href="#" class="hover:text-blue-600">Samosas & Snacks</a></li>
                <li><a href="#" class="hover:text-blue-600">Cakes & Pastries</a></li>
                <li><a href="#" class="hover:text-blue-600">Cookies & Brownies</a></li>
                <li><a href="#" class="hover:text-blue-600">Donuts & Muffins</a></li>
              </ul>
            </div>

            <!-- Column 5 -->
            <div>
              <h3 class="text-green-600 font-medium text-lg mb-4">Tea, Coffee & Malted Drinks</h3>
              <ul class="space-y-3">
                <li><a href="#" class="hover:text-green-600">Tea</a></li>
                <li><a href="#" class="hover:text-green-600">Coffee</a></li>
                <li><a href="#" class="hover:text-green-600">Chocolate & Malted Drinks</a></li>
                <li><a href="#" class="hover:text-green-600">Health Supplement</a></li>
              </ul>

              <h3 class="text-green-600 font-medium text-lg mt-8 mb-4">Snacks & Beverages</h3>
              <ul class="space-y-3">
                <li><a href="#" class="hover:text-green-600">Beverages</a></li>
                <li><a href="#" class="hover:text-green-600">Snacks</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>

      <!-- Mega Menu - Electronics & Appliances -->
      <div id="electronics" class="mega-menu bg-white shadow-lg border-t border-gray-200">
        <div class="container mx-auto px-4 py-6">
          <div class="grid grid-cols-3 gap-8">
            <div>
              <h3 class="text-green-600 font-medium text-lg mb-4">Kitchen Appliances</h3>
              <ul class="space-y-3">
                <li><a href="#" class="hover:text-green-600">Mixers & Grinders</a></li>
                <li><a href="#" class="hover:text-green-600">Microwaves & Ovens</a></li>
                <li><a href="#" class="hover:text-green-600">Refrigerators</a></li>
              </ul>
            </div>
            <div>
              <h3 class="text-green-600 font-medium text-lg mb-4">Entertainment</h3>
              <ul class="space-y-3">
                <li><a href="#" class="hover:text-green-600">Televisions</a></li>
                <li><a href="#" class="hover:text-green-600">Audio Systems</a></li>
                <li><a href="#" class="hover:text-green-600">Gaming</a></li>
              </ul>
            </div>
            <div>
              <h3 class="text-green-600 font-medium text-lg mb-4">Computers & Accessories</h3>
              <ul class="space-y-3">
                <li><a href="#" class="hover:text-green-600">Laptops</a></li>
                <li><a href="#" class="hover:text-green-600">Peripherals</a></li>
                <li><a href="#" class="hover:text-green-600">Mobile Phones</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>

      <!-- Mega Menu - Home & Lifestyle -->
      <div id="home" class="mega-menu bg-white shadow-lg border-t border-gray-200">
        <div class="container mx-auto px-4 py-6">
          <div class="grid grid-cols-3 gap-8">
            <div>
              <h3 class="text-green-600 font-medium text-lg mb-4">Home Decor</h3>
              <ul class="space-y-3">
                <li><a href="#" class="hover:text-green-600">Curtains & Blinds</a></li>
                <li><a href="#" class="hover:text-green-600">Cushions & Covers</a></li>
                <li><a href="#" class="hover:text-green-600">Wall Decor</a></li>
              </ul>
            </div>
            <div>
              <h3 class="text-green-600 font-medium text-lg mb-4">Furniture</h3>
              <ul class="space-y-3">
                <li><a href="#" class="hover:text-green-600">Sofas & Chairs</a></li>
                <li><a href="#" class="hover:text-green-600">Tables & Desks</a></li>
                <li><a href="#" class="hover:text-green-600">Bed & Mattresses</a></li>
              </ul>
            </div>
            <div>
              <h3 class="text-green-600 font-medium text-lg mb-4">Kitchen & Dining</h3>
              <ul class="space-y-3">
                <li><a href="#" class="hover:text-green-600">Cookware</a></li>
                <li><a href="#" class="hover:text-green-600">Tableware</a></li>
                <li><a href="#" class="hover:text-green-600">Kitchen Tools</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>

    </div>


   


    <!-- Mobile Navbar -->
    <header class="mobile-nav bg-white shadow-sm fixed top-0 left-0 right-0 z-40 fixed-sticky">
      <!-- Top navigation bar -->
      <div class="flex items-center justify-between p-3">
        <!-- Hamburger menu -->
        <button id="menu-toggle" class="text-gray-600 focus:outline-none">
          <i class="fas fa-bars text-xl"></i>
        </button>

        <!-- Logo -->
        <div class="flex items-center">
          <img src={{ asset('img/logos/amzlogo1.svg') }} alt="Amazing Hypermarket" class="h-8">
        </div>

        <!-- Cart icon with badge -->
        <div class="relative">
          <button class="text-gray-600 focus:outline-none">
            <div class="relative">
              <i class="fas fa-shopping-cart text-xl bg-amazing-red text-white p-2 rounded-full"></i>
              <span
                class="absolute -top-1 -right-1 bg-amazing-red text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">0</span>
            </div>
          </button>
        </div>
      </div>

      <!-- Search bar -->
      <div class="px-3 pb-3">
        <div class="relative">
          <input type="text" placeholder="What are you looking for?"
            class="w-full py-2 px-4 pr-10 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-300 text-sm">
          <div class="absolute right-3 top-2.5">
            <i class="fas fa-search text-gray-400"></i>
          </div>
        </div>
      </div>

      <!-- Location selector -->
      <div class="flex items-center bg-gray-50 py-2 px-3 border-t border-gray-200">
        <i class="fas fa-map-marker-alt text-amazing-red mr-2"></i>
        <div class="text-sm">
          <span class="text-gray-500">Delivery to</span>
          <span class="font-medium ml-1 text-gray-700">Aluva - 683101</span>
        </div>
      </div>

      <!-- Sidebar menu -->
      <div id="sidebar-overlay" class="fixed inset-0 bg-black opacity-50 z-40 hidden"></div>
      <div id="sidebar"
        class="sidebar fixed top-0 left-0 h-full w-64 bg-white shadow-lg z-50 transform -translate-x-full">
        <!-- Welcome section -->
        <div class="bg-blue-900 text-white p-4">
          <div class="text-sm font-medium">Welcome</div>
          <div class="text-xs mt-1">To access account and manage orders.</div>
          <button class="mt-3 bg-amazing-red text-white text-xs font-medium py-1 px-4 rounded">Login/Sign Up</button>
        </div>

        <!-- Sidebar menu items -->
        <div class="py-2">
          <!-- Category section -->
          <div class="px-4 py-2 text-xs font-semibold text-gray-500">Category</div>
          <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
            <div class="w-6 text-center mr-3"><i class="fas fa-apple-alt text-amazing-green"></i></div>
            Grocery & Fresh
          </a>
          <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
            <div class="w-6 text-center mr-3"><i class="fas fa-tv"></i></div>
            Electronics & Appliances
          </a>
          <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
            <div class="w-6 text-center mr-3"><i class="fas fa-home"></i></div>
            Home & Lifestyle
          </a>
          <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
            <div class="w-6 text-center mr-3"><i class="fas fa-tag"></i></div>
            Offers
          </a>

          <!-- My Account section -->
          <div class="px-4 py-2 mt-2 text-xs font-semibold text-gray-500">My Account</div>
          <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
            <div class="w-6 text-center mr-3"><i class="fas fa-address-book"></i></div>
            My Address
          </a>
          <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
            <div class="w-6 text-center mr-3"><i class="fas fa-shopping-bag"></i></div>
            My Orders
          </a>
          <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
            <div class="w-6 text-center mr-3"><i class="far fa-heart"></i></div>
            Wishlist
          </a>
          <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
            <div class="w-6 text-center mr-3"><i class="fas fa-gift"></i></div>
            Amazing Happiness Points
          </a>
          <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
            <div class="w-6 text-center mr-3"><i class="fas fa-user-plus"></i></div>
            Refer a Friend
          </a>

          <!-- Help & Support section -->
          <div class="px-4 py-2 mt-2 text-xs font-semibold text-gray-500">Help & Support</div>
          <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
            <div class="w-6 text-center mr-3"><i class="fas fa-headset"></i></div>
            Contact Support
          </a>
        </div>

        <!-- Close button -->
        <button id="close-sidebar" class="absolute top-2 right-2 text-gray-600 focus:outline-none">
          <i class="fas fa-times text-lg"></i>
        </button>
      </div>
    </header>

    <!-- Add some content to push down the mobile navbar -->
  <div class="pt-32 sm:pt-0">
    @yield('content')
  </div>




    <footer class="w-full mx-auto py-8 px-4">
      <div class="flex flex-col md:flex-row border-t border-gray-200 pt-6">
        <!-- Useful Links Section -->
        <div class="w-full md:w-1/4 mb-6 md:mb-0 pr-4">
          <h2 class="text-lg font-bold mb-4">Useful Links</h2>
          <div class="grid grid-cols-3 gap-y-2">
            <div class="col-span-1">
              <ul class="space-y-2">
                <li><a href="#" class="text-gray-500 hover:text-gray-700">About</a></li>
                <li><a href="#" class="text-gray-500 hover:text-gray-700">Careers</a></li>
                <li><a href="#" class="text-gray-500 hover:text-gray-700">Blog</a></li>
                <li><a href="#" class="text-gray-500 hover:text-gray-700">Press</a></li>
                <li><a href="#" class="text-gray-500 hover:text-gray-700">Lead</a></li>
                <li><a href="#" class="text-gray-500 hover:text-gray-700">Value</a></li>
              </ul>
            </div>
            <div class="col-span-1">
              <ul class="space-y-2">
                <li><a href="#" class="text-gray-500 hover:text-gray-700">Privacy</a></li>
                <li><a href="#" class="text-gray-500 hover:text-gray-700">Terms</a></li>
                <li><a href="#" class="text-gray-500 hover:text-gray-700">FAQs</a></li>
                <li><a href="#" class="text-gray-500 hover:text-gray-700">Security</a></li>
                <li><a href="#" class="text-gray-500 hover:text-gray-700">Mobile</a></li>
                <li><a href="#" class="text-gray-500 hover:text-gray-700">Contact</a></li>
              </ul>
            </div>
            <div class="col-span-1">
              <ul class="space-y-2">
                <li><a href="#" class="text-gray-500 hover:text-gray-700">Partner</a></li>
                <li><a href="#" class="text-gray-500 hover:text-gray-700">Franchise</a></li>
                <li><a href="#" class="text-gray-500 hover:text-gray-700">Seller</a></li>
                <li><a href="#" class="text-gray-500 hover:text-gray-700">Warehouse</a></li>
                <li><a href="#" class="text-gray-500 hover:text-gray-700">Deliver</a></li>
                <li><a href="#" class="text-gray-500 hover:text-gray-700">Resources</a></li>
              </ul>
            </div>
          </div>
        </div>

        <!-- Categories Section -->
        <div class="w-full md:w-3/4">
          <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-bold">Categories</h2>
            <a href="#" class="text-green-600 hover:text-green-700">see all</a>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-3 gap-y-2">
            <!-- First Category Column -->
            <div class="col-span-1">
              <ul class="space-y-2">
                <li><a href="#" class="text-gray-500 hover:text-gray-700">Vegetables & Fruits</a></li>
                <li><a href="#" class="text-gray-500 hover:text-gray-700">Cold Drinks & Juices</a></li>
                <li><a href="#" class="text-gray-500 hover:text-gray-700">Bakery & Biscuits</a></li>
                <li><a href="#" class="text-gray-500 hover:text-gray-700">Dry Fruits, Masala & Oil</a></li>
                <li><a href="#" class="text-gray-500 hover:text-gray-700">Paan Corner</a></li>
                <li><a href="#" class="text-gray-500 hover:text-gray-700">Pharma & Wellness</a></li>
                <li><a href="#" class="text-gray-500 hover:text-gray-700">Ice Creams & Frozen Desserts</a>
                </li>
                <li><a href="#" class="text-gray-500 hover:text-gray-700">Beauty & Cosmetics</a></li>
                <li><a href="#" class="text-gray-500 hover:text-gray-700">Magazines</a></li>
              </ul>
            </div>

            <!-- Second Category Column -->
            <div class="col-span-1">
              <ul class="space-y-2">
                <li><a href="#" class="text-gray-500 hover:text-gray-700">Dairy & Breakfast</a></li>
                <li><a href="#" class="text-gray-500 hover:text-gray-700">Instant & Frozen Food</a></li>
                <li><a href="#" class="text-gray-500 hover:text-gray-700">Sweet Tooth</a></li>
                <li><a href="#" class="text-gray-500 hover:text-gray-700">Sauces & Spreads</a></li>
                <li><a href="#" class="text-gray-500 hover:text-gray-700">Organic & Premium</a></li>
                <li><a href="#" class="text-gray-500 hover:text-gray-700">Cleaning Essentials</a></li>
                <li><a href="#" class="text-gray-500 hover:text-gray-700">Personal Care</a></li>
                <li><a href="#" class="text-gray-500 hover:text-gray-700">Books</a></li>
                <li><a href="#" class="text-gray-500 hover:text-gray-700">Print Store</a></li>
              </ul>
            </div>

            <!-- Third Category Column -->
            <div class="col-span-1">
              <ul class="space-y-2">
                <li><a href="#" class="text-gray-500 hover:text-gray-700">Munchies</a></li>
                <li><a href="#" class="text-gray-500 hover:text-gray-700">Tea, Coffee & Health Drinks</a>
                </li>
                <li><a href="#" class="text-gray-500 hover:text-gray-700">Atta, Rice & Dal</a></li>
                <li><a href="#" class="text-gray-500 hover:text-gray-700">Chicken, Meat & Fish</a></li>
                <li><a href="#" class="text-gray-500 hover:text-gray-700">Baby Care</a></li>
                <li><a href="#" class="text-gray-500 hover:text-gray-700">Home & Office</a></li>
                <li><a href="#" class="text-gray-500 hover:text-gray-700">Pet Care</a></li>
                <li><a href="#" class="text-gray-500 hover:text-gray-700">Toys & Games</a></li>
                <li><a href="#" class="text-gray-500 hover:text-gray-700">E-Gift Cards</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </footer>
  </div>
  <script>
    // JavaScript to handle the toggle functionality
    document.addEventListener('DOMContentLoaded', function () {
      const categoryNavs = document.querySelectorAll('.category-nav');

      categoryNavs.forEach(nav => {
        nav.addEventListener('click', function () {
          const targetId = this.getAttribute('data-target');
          const targetMenu = document.getElementById(targetId);
          const arrow = this.querySelector('svg:last-child');

          // Close all menus first
          document.querySelectorAll('.mega-menu').forEach(menu => {
            if (menu.id !== targetId) {
              menu.classList.remove('active');
            }
          });

          // Reset all arrows and remove green color from all categories
          document.querySelectorAll('.category-nav svg:last-child').forEach(svg => {
            if (svg !== arrow) {
              svg.classList.remove('rotate-180');
            }
          });
          document.querySelectorAll('.category-nav span').forEach(span => {
            span.classList.remove('amazing-green', 'font-medium');
          });

          // Toggle current menu and set green color for selected category
          targetMenu.classList.toggle('active');
          arrow.classList.toggle('rotate-180');
          this.querySelector('span').classList.add('amazing-green', 'font-medium');
        });
      });

      // Close menu when clicking outside
      document.addEventListener('click', function (event) {
        const isClickInsideNav = Array.from(categoryNavs).some(nav => nav.contains(event.target));
        const isClickInsideMenu = Array.from(document.querySelectorAll('.mega-menu')).some(menu => menu.contains(event.target));

        if (!isClickInsideNav && !isClickInsideMenu) {
          document.querySelectorAll('.mega-menu').forEach(menu => {
            menu.classList.remove('active');
          });

          document.querySelectorAll('.category-nav svg:last-child').forEach(svg => {
            svg.classList.remove('rotate-180');
          });

          document.querySelectorAll('.category-nav span').forEach(span => {
            span.classList.remove('amazing-green', 'font-medium');
          });
        }
      });

      // Mobile sidebar toggle
      const menuToggle = document.getElementById('menu-toggle');
      const sidebar = document.getElementById('sidebar');
      const closeSidebar = document.getElementById('close-sidebar');
      const overlay = document.getElementById('sidebar-overlay');

      function openSidebar() {
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.remove('hidden');
        document.body.classList.add('sidebar-open');
      }

      function closeSidebarMenu() {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
        document.body.classList.remove('sidebar-open');
      }

      menuToggle.addEventListener('click', openSidebar);
      closeSidebar.addEventListener('click', closeSidebarMenu);
      overlay.addEventListener('click', closeSidebarMenu);
    });
  </script>
</body>

</html>