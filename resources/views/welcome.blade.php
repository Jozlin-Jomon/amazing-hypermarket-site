@extends('includes.inc')
@section('content')

<!-- User greeting and quick-access section -->
@auth
<div class="bg-purple-50 p-4 mb-6">
    <div class="container mx-auto">
       
    </div>
</div>
@endauth
<!-- Banner Section -->
<div class="banner-section bg-white p-0">
    <div x-data="{ currentBanner: 0 }" class="banner-container relative w-full overflow-hidden">
        <div class="banner-slider relative w-full h-[40vh] sm:h-[50vh] md:h-[60vh] lg:h-screen overflow-hidden">




            <!-- Banner 1 -->
            <div x-show="currentBanner === 0"
                 class="absolute inset-0 w-full h-full transition-opacity duration-500"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0">
                <img src="img/banner/usain-bolt-dirt-is-good-supplied.jpeg"
                     alt="Banner 1"
                     class="w-full h-full object-cover object-center">
            </div>

            <!-- Banner 2 -->
            <div x-show="currentBanner === 1"
                 class="absolute inset-0 w-full h-full transition-opacity duration-500"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0">
                <img src="img/banner/Banner-1-qt2rxmkstiuw7z4sdel7859bwq97xzopmfujzeloag.jpg"
                     alt="Banner 2"
                     class="w-full h-full object-cover object-center">
            </div>

            <!-- Banner 3 -->
            <div x-show="currentBanner === 2"
                 class="absolute inset-0 w-full h-full transition-opacity duration-500"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0">
                <img src="img/banner/WhatsApp Image 2025-04-23 at 1.36.31 PM.jpeg"
                     alt="Banner 3"
                     class="w-full h-full object-cover object-center">
            </div>

            <!-- Navigation Dots -->
            <div class="absolute bottom-6 sm:bottom-8 left-0 right-0 flex justify-center space-x-2 z-10">
                <template x-for="i in 3">
                    <button @click="currentBanner = i - 1"
                        :class="{'bg-white': currentBanner === i - 1, 'bg-white/50': currentBanner !== i - 1}"
                        class="w-3 h-3 rounded-full focus:outline-none transition-colors duration-300"></button>
                </template>
            </div>

            <!-- Arrows -->
            <button @click="currentBanner = (currentBanner - 1 + 3) % 3"
                    class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white/50 hover:bg-white/80 rounded-full p-2 focus:outline-none transition z-10">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-6 w-6"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
            <button @click="currentBanner = (currentBanner + 1) % 3"
                    class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white/50 hover:bg-white/80 rounded-full p-2 focus:outline-none transition z-10">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-6 w-6"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>
    </div>
</div>

<!-- Carousel Section One-->
<div class="bg-white p-6">
    <div class="w-full mx-auto">
        <div class="relative">
            <!-- Left Arrow -->
            <button id="prevBtn"
                class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-white rounded-full p-3 shadow-md z-10 hover:bg-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            <!-- Scrollable Container -->
            <div id="carousel" class="carousel-container overflow-x-scroll py-4 px-8">
                <div id="imageContainer" class="flex space-x-8 w-max">
                    <!-- Manually added product images -->

                        <img class="w-40 sm:w-24 md:w-28 lg:w-40 h-auto object-contain overflow-hidden flex-shrink-0" src={{ asset('img/amazngIcons/ICONS-01.png') }} alt="Personal Wash">
                 
                        <img class="w-40 sm:w-24 md:w-28 lg:w-40 h-auto object-contain overflow-hidden flex-shrink-0" src={{ asset('img/amazngIcons/ICONS-02.png') }} alt="Chill & Dairy">
                  
                        <img class="w-40 sm:w-24 md:w-28 lg:w-40 h-auto object-contain overflow-hidden flex-shrink-0" src={{ asset('img/amazngIcons/ICONS-03.png') }} alt="Frozen">

                        <img class="w-40 sm:w-24 md:w-28 lg:w-40 h-auto object-contain overflow-hidden flex-shrink-0" src={{ asset('img/amazngIcons/ICONS-04.png') }} alt="Baby Care">

                        <img class="w-40 sm:w-24 md:w-28 lg:w-40 h-auto object-contain overflow-hidden flex-shrink-0" src={{ asset('img/amazngIcons/ICONS-05.png') }} alt="Tea & Coffee">

                        <img class="w-40 sm:w-24 md:w-28 lg:w-40 h-auto object-contain overflow-hidden flex-shrink-0" src={{ asset('img/amazngIcons/ICONS-06.png') }} alt="Pulse & Dals">
                   
                        <img class="w-40 sm:w-24 md:w-28 lg:w-40 h-auto object-contain overflow-hidden flex-shrink-0" src={{ asset('img/amazngIcons/ICONS-07.png') }} alt="Pulse & Dals">

                        <img class="w-40 sm:w-24 md:w-28 lg:w-40 h-auto object-contain overflow-hidden flex-shrink-0" src={{ asset('img/amazngIcons/ICONS-08.png') }} alt="Pulse & Dals">

                        <img class="w-40 sm:w-24 md:w-28 lg:w-40 h-auto object-contain overflow-hidden flex-shrink-0" src={{ asset('img/amazngIcons/ICONS-09.png') }} alt="Pulse & Dals">

                        <img class="w-40 sm:w-24 md:w-28 lg:w-40 h-auto object-contain overflow-hidden flex-shrink-0" src={{ asset('img/amazngIcons/ICONS-10.png') }} alt="Pulse & Dals">

                        <img class="w-40 sm:w-24 md:w-28 lg:w-40 h-auto object-contain overflow-hidden flex-shrink-0" src={{ asset('img/amazngIcons/ICONS-11.png') }} alt="Pulse & Dals">

                        <img class="w-40 sm:w-24 md:w-28 lg:w-40 h-auto object-contain overflow-hidden flex-shrink-0" src={{ asset('img/amazngIcons/ICONS-12.png') }} alt="Pulse & Dals">

                        <img class="w-40 sm:w-24 md:w-28 lg:w-40 h-auto object-contain overflow-hidden flex-shrink-0" src={{ asset('img/amazngIcons/ICONS-13.png') }} alt="Pulse & Dals">

                </div>
            </div>
            <!-- Right Arrow -->
            <button id="nextBtn"
                class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-white rounded-full p-3 shadow-md z-10 hover:bg-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>

        <!-- Pagination Dots -->
        <div id="dotsContainer" class="flex justify-center space-x-2 mt-6">
            <!-- Dots will be added dynamically -->
        </div>
    </div>

</div>

<!-- Carousel Section Two-->
<div class="bg-white p-6">

  <section class="w-full p-4">
    <div id="scroll-container-1" class="flex overflow-x-auto no-scrollbar space-x-4" style="scroll-behavior: smooth; scroll-snap-type: none;">
      <img src={{ asset('img/amzngSectionOne/1.jpeg') }} alt="Image 1" class="flex-shrink-0 sm:w-1/2 md:w-1/3 lg:w-1/4" />
      <img src={{ asset('img/amzngSectionOne/2.jpeg') }} alt="Image 2" class="flex-shrink-0 sm:w-1/2 md:w-1/3 lg:w-1/4" />
      <img src={{ asset('img/amzngSectionOne/3.jpeg') }} alt="Image 3" class="flex-shrink-0 sm:w-1/2 md:w-1/3 lg:w-1/4" />
      <img src={{ asset('img/amzngSectionOne/4.jpeg') }} alt="Image 4" class="flex-shrink-0 sm:w-1/2 md:w-1/3 lg:w-1/4" />
      <img src={{ asset('img/amzngSectionOne/1.jpeg') }} alt="Image 5" class="flex-shrink-0 sm:w-1/2 md:w-1/3 lg:w-1/4" />
      <img src={{ asset('img/amzngSectionOne/2.jpeg') }} alt="Image 6" class="flex-shrink-0 sm:w-1/2 md:w-1/3 lg:w-1/4" />
      <img src={{ asset('img/amzngSectionOne/3.jpeg') }} alt="Image 7" class="flex-shrink-0 sm:w-1/2 md:w-1/3 lg:w-1/4" />
    </div>
  </section>
</div>

<!-- Carousel Section Three-->
<div class="bg-white p-6">
  <section class="w-full p-4">
    <div id="scroll-container-2" class="flex overflow-x-auto no-scrollbar space-x-4"
      style="scroll-behavior: smooth; scroll-snap-type: none;">
      <!-- Each image container is 1/3 of the visible width minus spacing -->
      <img src={{ asset('img/amzngSectionTwo/1.jpeg') }} alt="Image 1" class="flex-shrink-0 sm:w-1/4 md:w-1/3 lg:w-1/4" />
      <img src={{ asset('img/amzngSectionTwo/2.jpeg') }} alt="Image 2" class="flex-shrink-0 sm:w-1/4 md:w-1/3 lg:w-1/4" />
      <img src={{ asset('img/amzngSectionTwo/3.jpeg') }} alt="Image 3" class="flex-shrink-0 sm:w-1/4 md:w-1/3 lg:w-1/4" />
      <img src={{ asset('img/amzngSectionTwo/4.jpeg') }} alt="Image 4" class="flex-shrink-0 sm:w-1/4 md:w-1/3 lg:w-1/4" />
      <img src={{ asset('img/amzngSectionTwo/1.jpeg') }} alt="Image 5" class="flex-shrink-0 sm:w-1/4 md:w-1/3 lg:w-1/4" />
      <img src={{ asset('img/amzngSectionTwo/2.jpeg') }} alt="Image 6" class="flex-shrink-0 sm:w-1/4 md:w-1/3 lg:w-1/4" />
      <img src={{ asset('img/amzngSectionTwo/3.jpeg') }} alt="Image 7" class="flex-shrink-0 sm:w-1/4 md:w-1/3 lg:w-1/4" />
    </div>
  </section>
</div>

<!-- Product Section -->
<div class="bg-white p-6">
    <div class="w-full mx-auto">
        <h1 class="text-4xl font-bold text-gray-700 mb-8">Snacks, drinks, ice cream</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
            <!-- Tricone Ice Cream -->
            <div class="bg-white rounded shadow p-4 relative flex flex-col">
                <div class="flex justify-center h-40 mb-4">
                    <div class="relative w-full">
                        <img src={{ asset('img/product/1.webp') }} alt="Amul Tricone Ice Cream"
                            class="mx-auto h-full object-contain" />
                    </div>
                </div>
                <div class="text-xs text-gray-600">Name Category</div>
                <div class="font-bold mb-4">Full Product Name</div>
                <span class="line-through text-gray-500 mr-2">₹ 400/-</span>
                <div class="mt-auto flex justify-between items-center">
                    
                    <div>
                        <span class="font-medium text-purple-800">Price : ₹ 350/-</span>
                    </div>
                    <button class="bg-purple-800 text-white rounded px-4 py-1 text-sm font-bold">ADD</button>
                </div>
            </div>

            <!-- Lay's Classic -->
            <div class="bg-white rounded shadow p-4 relative flex flex-col">
                <div class="flex justify-center h-40 mb-4">
                    <img src={{ asset('img/product/2.jpg') }} alt="Lay's Classic" class="mx-auto h-full object-contain" />
                </div>
                <div class="text-xs text-gray-600">Name Category</div>
                <div class="font-bold mb-4">Full Product Name</div>
                <span class="line-through text-gray-500 mr-2">₹ 400/-</span>
                <div class="mt-auto flex justify-between items-center">
                    <div>
                        
                        <span class="font-medium text-purple-800">Price : ₹ 350/-</span>
                    </div>
                    <button class="bg-purple-800 text-white rounded px-4 py-1 text-sm font-bold">ADD</button>
                </div>
            </div>

            <!-- Tender Coconut Ice Cream -->
            <div class="bg-white rounded shadow p-4 relative flex flex-col">
                <div class="flex justify-center h-40 mb-4">
                    <img src={{ asset('img/product/3.jpg') }} alt="Tender Coconut Ice Cream"
                        class="mx-auto h-full object-contain" />
                </div>
                <div class="text-xs text-gray-600">Name Category</div>
                <div class="font-bold mb-4">Full Product Name</div>
                <span class="line-through text-gray-500 mr-2">₹ 400/-</span>
                <div class="mt-auto flex justify-between items-center">
                    <div>
                        
                        <span class="font-medium text-purple-800">Price : ₹ 350/-</span>
                    </div>
                    <button class="bg-purple-800 text-white rounded px-4 py-1 text-sm font-bold">ADD</button>
                </div>
            </div>

            <!-- Lay's Flamin' Hot -->
            <div class="bg-white rounded shadow p-4 relative flex flex-col">
                <div class="flex justify-center h-40 mb-4">
                    <img src={{ asset('img/product/4.jfif') }} alt="Lay's Flamin' Hot" class="mx-auto h-full object-contain" />
                </div>
                <div class="text-xs text-gray-600">Name Category</div>
                <div class="font-bold mb-4">Full Product Name</div>
                <span class="line-through text-gray-500 mr-2">₹ 400/-</span>
                <div class="mt-auto flex justify-between items-center">
                    <div>
                        
                        <span class="font-medium text-purple-800">Price : ₹ 350/-</span>
                    </div>
                    <button class="bg-purple-800 text-white rounded px-4 py-1 text-sm font-bold">ADD</button>
                </div>
            </div>

            <!-- Lay's Magic Masala -->
            <div class="bg-white rounded shadow p-4 relative flex flex-col">
                <div class="flex justify-center h-40 mb-4">
                    <img src={{ asset('img/product/5.jpg') }} alt="Lay's Magic Masala"
                        class="mx-auto h-full object-contain" />
                </div>
                <div class="text-xs text-gray-600">Name Category</div>
                <div class="font-bold mb-4">Full Product Name</div>
                <span class="line-through text-gray-500 mr-2">₹ 400/-</span>
                <div class="mt-auto flex justify-between items-center">
                    <div>
                        <span class="font-medium text-purple-800">Price : ₹ 350/-</span>
                    </div>
                    <button class="bg-purple-800 text-white rounded px-4 py-1 text-sm font-bold">ADD</button>
                </div>
            </div>

           
        </div>
    </div>
</div>

<!-- Product Section -->
<div class="bg-white p-6">
    <div class="w-full mx-auto">
        <h1 class="text-4xl font-bold text-gray-700 mb-8">Snacks, drinks, ice cream</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
            <!-- Tricone Ice Cream -->
            <div class="bg-white rounded shadow p-4 relative flex flex-col">
                <div class="flex justify-center h-40 mb-4">
                    <div class="relative w-full">
                        <img src={{ asset('img/product/1.webp') }} alt="Amul Tricone Ice Cream"
                            class="mx-auto h-full object-contain" />
                    </div>
                </div>
                <div class="text-xs text-gray-600">Name Category</div>
                <div class="font-bold mb-4">Full Product Name</div>
                <span class="line-through text-gray-500 mr-2">₹ 400/-</span>
                <div class="mt-auto flex justify-between items-center">
                    
                    <div>
                        <span class="font-medium text-purple-800">Price : ₹ 350/-</span>
                    </div>
                    <button class="bg-purple-800 text-white rounded px-4 py-1 text-sm font-bold">ADD</button>
                </div>
            </div>

            <!-- Lay's Classic -->
            <div class="bg-white rounded shadow p-4 relative flex flex-col">
                <div class="flex justify-center h-40 mb-4">
                    <img src={{ asset('img/product/2.jpg') }} alt="Lay's Classic" class="mx-auto h-full object-contain" />
                </div>
                <div class="text-xs text-gray-600">Name Category</div>
                <div class="font-bold mb-4">Full Product Name</div>
                <span class="line-through text-gray-500 mr-2">₹ 400/-</span>
                <div class="mt-auto flex justify-between items-center">
                    <div>
                        
                        <span class="font-medium text-purple-800">Price : ₹ 350/-</span>
                    </div>
                    <button class="bg-purple-800 text-white rounded px-4 py-1 text-sm font-bold">ADD</button>
                </div>
            </div>

            <!-- Tender Coconut Ice Cream -->
            <div class="bg-white rounded shadow p-4 relative flex flex-col">
                <div class="flex justify-center h-40 mb-4">
                    <img src={{ asset('img/product/3.jpg') }} alt="Tender Coconut Ice Cream"
                        class="mx-auto h-full object-contain" />
                </div>
                <div class="text-xs text-gray-600">Name Category</div>
                <div class="font-bold mb-4">Full Product Name</div>
                <span class="line-through text-gray-500 mr-2">₹ 400/-</span>
                <div class="mt-auto flex justify-between items-center">
                    <div>
                        
                        <span class="font-medium text-purple-800">Price : ₹ 350/-</span>
                    </div>
                    <button class="bg-purple-800 text-white rounded px-4 py-1 text-sm font-bold">ADD</button>
                </div>
            </div>

            <!-- Lay's Flamin' Hot -->
            <div class="bg-white rounded shadow p-4 relative flex flex-col">
                <div class="flex justify-center h-40 mb-4">
                    <img src={{ asset('img/product/4.jfif') }} alt="Lay's Flamin' Hot" class="mx-auto h-full object-contain" />
                </div>
                <div class="text-xs text-gray-600">Name Category</div>
                <div class="font-bold mb-4">Full Product Name</div>
                <span class="line-through text-gray-500 mr-2">₹ 400/-</span>
                <div class="mt-auto flex justify-between items-center">
                    <div>
                        
                        <span class="font-medium text-purple-800">Price : ₹ 350/-</span>
                    </div>
                    <button class="bg-purple-800 text-white rounded px-4 py-1 text-sm font-bold">ADD</button>
                </div>
            </div>

            <!-- Lay's Magic Masala -->
            <div class="bg-white rounded shadow p-4 relative flex flex-col">
                <div class="flex justify-center h-40 mb-4">
                    <img src={{ asset('img/product/5.jpg') }} alt="Lay's Magic Masala"
                        class="mx-auto h-full object-contain" />
                </div>
                <div class="text-xs text-gray-600">Name Category</div>
                <div class="font-bold mb-4">Full Product Name</div>
                <span class="line-through text-gray-500 mr-2">₹ 400/-</span>
                <div class="mt-auto flex justify-between items-center">
                    <div>
                        <span class="font-medium text-purple-800">Price : ₹ 350/-</span>
                    </div>
                    <button class="bg-purple-800 text-white rounded px-4 py-1 text-sm font-bold">ADD</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Product Section -->
<div class="bg-white p-6">
    <div class="w-full mx-auto">
        <h1 class="text-4xl font-bold text-gray-700 mb-8">Snacks, drinks, ice cream</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
            <!-- Tricone Ice Cream -->
            <div class="bg-white rounded shadow p-4 relative flex flex-col">
                <div class="flex justify-center h-40 mb-4">
                    <div class="relative w-full">
                        <img src={{ asset('img/product/1.webp') }} alt="Amul Tricone Ice Cream"
                            class="mx-auto h-full object-contain" />
                    </div>
                </div>
                <div class="text-xs text-gray-600">Name Category</div>
                <div class="font-bold mb-4">Full Product Name</div>
                <span class="line-through text-gray-500 mr-2">₹ 400/-</span>
                <div class="mt-auto flex justify-between items-center">
                    
                    <div>
                        <span class="font-medium text-purple-800">Price : ₹ 350/-</span>
                    </div>
                    <button class="bg-purple-800 text-white rounded px-4 py-1 text-sm font-bold">ADD</button>
                </div>
            </div>

            <!-- Lay's Classic -->
            <div class="bg-white rounded shadow p-4 relative flex flex-col">
                <div class="flex justify-center h-40 mb-4">
                    <img src={{ asset('img/product/2.jpg') }} alt="Lay's Classic" class="mx-auto h-full object-contain" />
                </div>
                <div class="text-xs text-gray-600">Name Category</div>
                <div class="font-bold mb-4">Full Product Name</div>
                <span class="line-through text-gray-500 mr-2">₹ 400/-</span>
                <div class="mt-auto flex justify-between items-center">
                    <div>                       
                        <span class="font-medium text-purple-800">Price : ₹ 350/-</span>
                    </div>
                    <button class="bg-purple-800 text-white rounded px-4 py-1 text-sm font-bold">ADD</button>
                </div>
            </div>

            <!-- Tender Coconut Ice Cream -->
            <div class="bg-white rounded shadow p-4 relative flex flex-col">
                <div class="flex justify-center h-40 mb-4">
                    <img src={{ asset('img/product/3.jpg') }} alt="Tender Coconut Ice Cream"
                        class="mx-auto h-full object-contain" />
                </div>
                <div class="text-xs text-gray-600">Name Category</div>
                <div class="font-bold mb-4">Full Product Name</div>
                <span class="line-through text-gray-500 mr-2">₹ 400/-</span>
                <div class="mt-auto flex justify-between items-center">
                    <div>
                        
                        <span class="font-medium text-purple-800">Price : ₹ 350/-</span>
                    </div>
                    <button class="bg-purple-800 text-white rounded px-4 py-1 text-sm font-bold">ADD</button>
                </div>
            </div>

            <!-- Lay's Flamin' Hot -->
            <div class="bg-white rounded shadow p-4 relative flex flex-col">
                <div class="flex justify-center h-40 mb-4">
                    <img src={{ asset('img/product/4.jfif') }} alt="Lay's Flamin' Hot" class="mx-auto h-full object-contain" />
                </div>
                <div class="text-xs text-gray-600">Name Category</div>
                <div class="font-bold mb-4">Full Product Name</div>
                <span class="line-through text-gray-500 mr-2">₹ 400/-</span>
                <div class="mt-auto flex justify-between items-center">
                    <div>
                        
                        <span class="font-medium text-purple-800">Price : ₹ 350/-</span>
                    </div>
                    <button class="bg-purple-800 text-white rounded px-4 py-1 text-sm font-bold">ADD</button>
                </div>
            </div>

            <!-- Lay's Magic Masala -->
            <div class="bg-white rounded shadow p-4 relative flex flex-col">
                <div class="flex justify-center h-40 mb-4">
                    <img src={{ asset('img/product/5.jpg') }} alt="Lay's Magic Masala"
                        class="mx-auto h-full object-contain" />
                </div>
                <div class="text-xs text-gray-600">Name Category</div>
                <div class="font-bold mb-4">Full Product Name</div>
                <span class="line-through text-gray-500 mr-2">₹ 400/-</span>
                <div class="mt-auto flex justify-between items-center">
                    <div>
                        <span class="font-medium text-purple-800">Price : ₹ 350/-</span>
                    </div>
                    <button class="bg-purple-800 text-white rounded px-4 py-1 text-sm font-bold">ADD</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Product Section -->
<div class="bg-white p-6">
    <div class="w-full mx-auto">
        <h1 class="text-4xl font-bold text-gray-700 mb-8">Snacks, drinks, ice cream</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
            <!-- Tricone Ice Cream -->
            <div class="bg-white rounded shadow p-4 relative flex flex-col">
                <div class="flex justify-center h-40 mb-4">
                    <div class="relative w-full">
                        <img src={{ asset('img/product/1.webp') }} alt="Amul Tricone Ice Cream"
                            class="mx-auto h-full object-contain" />
                    </div>
                </div>
                <div class="text-xs text-gray-600">Name Category</div>
                <div class="font-bold mb-4">Full Product Name</div>
                <span class="line-through text-gray-500 mr-2">₹ 400/-</span>
                <div class="mt-auto flex justify-between items-center">
                    
                    <div>
                        <span class="font-medium text-purple-800">Price : ₹ 350/-</span>
                    </div>
                    <button class="bg-purple-800 text-white rounded px-4 py-1 text-sm font-bold">ADD</button>
                </div>
            </div>

            <!-- Lay's Classic -->
            <div class="bg-white rounded shadow p-4 relative flex flex-col">
                <div class="flex justify-center h-40 mb-4">
                    <img src={{ asset('img/product/2.jpg') }} alt="Lay's Classic" class="mx-auto h-full object-contain" />
                </div>
                <div class="text-xs text-gray-600">Name Category</div>
                <div class="font-bold mb-4">Full Product Name</div>
                <span class="line-through text-gray-500 mr-2">₹ 400/-</span>
                <div class="mt-auto flex justify-between items-center">
                    <div>
                        
                        <span class="font-medium text-purple-800">Price : ₹ 350/-</span>
                    </div>
                    <button class="bg-purple-800 text-white rounded px-4 py-1 text-sm font-bold">ADD</button>
                </div>
            </div>

            <!-- Tender Coconut Ice Cream -->
            <div class="bg-white rounded shadow p-4 relative flex flex-col">
                <div class="flex justify-center h-40 mb-4">
                    <img src={{ asset('img/product/3.jpg') }} alt="Tender Coconut Ice Cream"
                        class="mx-auto h-full object-contain" />
                </div>
                <div class="text-xs text-gray-600">Name Category</div>
                <div class="font-bold mb-4">Full Product Name</div>
                <span class="line-through text-gray-500 mr-2">₹ 400/-</span>
                <div class="mt-auto flex justify-between items-center">
                    <div>
                        
                        <span class="font-medium text-purple-800">Price : ₹ 350/-</span>
                    </div>
                    <button class="bg-purple-800 text-white rounded px-4 py-1 text-sm font-bold">ADD</button>
                </div>
            </div>

            <!-- Lay's Flamin' Hot -->
            <div class="bg-white rounded shadow p-4 relative flex flex-col">
                <div class="flex justify-center h-40 mb-4">
                    <img src={{ asset('img/product/4.jfif') }} alt="Lay's Flamin' Hot" class="mx-auto h-full object-contain" />
                </div>
                <div class="text-xs text-gray-600">Name Category</div>
                <div class="font-bold mb-4">Full Product Name</div>
                <span class="line-through text-gray-500 mr-2">₹ 400/-</span>
                <div class="mt-auto flex justify-between items-center">
                    <div>
                        <span class="font-medium text-purple-800">Price : ₹ 350/-</span>
                    </div>
                    <button class="bg-purple-800 text-white rounded px-4 py-1 text-sm font-bold">ADD</button>
                </div>
            </div>

            <!-- Lay's Magic Masala -->
            <div class="bg-white rounded shadow p-4 relative flex flex-col">
                <div class="flex justify-center h-40 mb-4">
                    <img src={{ asset('img/product/5.jpg') }} alt="Lay's Magic Masala"
                        class="mx-auto h-full object-contain" />
                </div>
                <div class="text-xs text-gray-600">Name Category</div>
                <div class="font-bold mb-4">Full Product Name</div>
                <span class="line-through text-gray-500 mr-2">₹ 400/-</span>
                <div class="mt-auto flex justify-between items-center">
                    <div>
                        <span class="font-medium text-purple-800">Price : ₹ 350/-</span>
                    </div>
                    <button class="bg-purple-800 text-white rounded px-4 py-1 text-sm font-bold">ADD</button>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Banner Section Script -->
 <script>
        // Auto-rotate banners every 5 seconds
        document.addEventListener('alpine:init', () => {
            Alpine.data('bannerSlider', () => ({
                currentBanner: 0,
                init() {
                    setInterval(() => {
                        this.currentBanner = (this.currentBanner + 1) % 3;
                    }, 5000);
                }
            }));
        });
    </script>

<!-- carousel Section One  -->
<script>
        // Number of items to display per page
        const itemsPerPage = 3;

        // Get all items
        const items = document.querySelectorAll('.carousel-container img');

        // Calculate total number of pages
        const totalPages = Math.ceil(items.length / itemsPerPage);

        // Current page
        let currentPage = 0;

        // Get DOM elements
        const carousel = document.getElementById('carousel');
        const dotsContainer = document.getElementById('dotsContainer');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');

        // Auto-scroll variables
        let autoScrollInterval;
        const autoScrollDelay = 3000; // 3 seconds

        // Create pagination dots
        function createDots() {
            dotsContainer.innerHTML = '';

            for (let i = 0; i < totalPages; i++) {
                const dot = document.createElement('div');
                dot.className = `dot w-2 h-2 rounded-full cursor-pointer ${i === currentPage ? 'w-8 bg-pink-500' : 'bg-gray-300'}`;
                dot.dataset.page = i;

                dot.addEventListener('click', () => {
                    currentPage = i;
                    scrollToPage(i);
                    updateDots();
                    resetAutoScroll();
                });

                dotsContainer.appendChild(dot);
            }
        }

        // Update dots based on current page
        function updateDots() {
            const dots = dotsContainer.querySelectorAll('.dot');
            dots.forEach((dot, index) => {
                if (index === currentPage) {
                    dot.classList.add('w-8', 'bg-pink-500');
                    dot.classList.remove('bg-gray-300');
                } else {
                    dot.classList.remove('w-8', 'bg-pink-500');
                    dot.classList.add('bg-gray-300');
                }
            });
        }

        // Scroll to specific page
        function scrollToPage(page) {
            const itemWidth = 208 + 16; // width + margin
            const scrollPosition = page * itemWidth * itemsPerPage;
            carousel.scrollTo(scrollPosition, 0);
            currentPage = page;
            updateDots();
        }

        // Start auto-scrolling
        function startAutoScroll() {
            if (autoScrollInterval) clearInterval(autoScrollInterval);

            autoScrollInterval = setInterval(() => {
                if (currentPage < totalPages - 1) {
                    currentPage++;
                } else {
                    currentPage = 0;
                }
                scrollToPage(currentPage);
            }, autoScrollDelay);
        }

        // Reset auto-scroll timer after manual interaction
        function resetAutoScroll() {
            if (autoScrollInterval) {
                clearInterval(autoScrollInterval);
            }
            startAutoScroll();
        }

        // Event listeners for arrow buttons
        prevBtn.addEventListener('click', () => {
            if (currentPage > 0) {
                currentPage--;
            } else {
                // Loop to the last page if at the beginning
                currentPage = totalPages - 1;
            }
            scrollToPage(currentPage);
            resetAutoScroll();
        });

        nextBtn.addEventListener('click', () => {
            if (currentPage < totalPages - 1) {
                currentPage++;
            } else {
                // Loop to the first page if at the end
                currentPage = 0;
            }
            scrollToPage(currentPage);
            resetAutoScroll();
        });

        // Handle manual scroll events
        let scrollTimeout;
        carousel.addEventListener('scroll', () => {
            const itemWidth = 208 + 16; // width + margin
            const scrollPosition = carousel.scrollLeft;
            const newPage = Math.round(scrollPosition / (itemWidth * itemsPerPage));

            if (newPage !== currentPage && newPage < totalPages) {
                currentPage = newPage;
                updateDots();
            }

            // Reset auto-scroll after manual scrolling ends
            clearTimeout(scrollTimeout);
            scrollTimeout = setTimeout(() => {
                resetAutoScroll();
            }, 200);
        });

        // Initialize
        createDots();
        startAutoScroll();
    </script>

<!-- Carousel Section Two and Three -->
   <script>
  function setupAutoScroll(containerId) {
    const container = document.getElementById(containerId);

    // Clone all images and append for infinite effect
    const images = Array.from(container.querySelectorAll('img'));
    images.forEach(img => container.appendChild(img.cloneNode(true)));

    let scrollPosition = 0;
    // Calculate width of one image including margin-right (space-x-4 = 1rem = 16px)
    const firstImage = container.querySelector('img');
    const imageStyle = window.getComputedStyle(firstImage);
    const imageWidth = firstImage.offsetWidth;
    const marginRight = parseInt(imageStyle.marginRight) || 16; // fallback 16px
    const scrollAmount = imageWidth + marginRight;

    const scrollInterval = 3000; // 3 seconds

    function autoScroll() {
      scrollPosition += scrollAmount;

      // Smooth scroll
      container.scrollTo({
        left: scrollPosition,
        behavior: 'smooth'
      });

      // Reset instantly (no animation) when reaching midpoint (original images length)
      if (scrollPosition >= container.scrollWidth / 2) {
        // Reset after the smooth scroll finishes (~300ms)
        setTimeout(() => {
          container.scrollLeft = 0;
          scrollPosition = 0;
        }, 300);
      }
    }

    setInterval(autoScroll, scrollInterval);
  }

  setupAutoScroll('scroll-container-1');
  setupAutoScroll('scroll-container-2');
</script>



@endsection
