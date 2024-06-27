<nav class="bg-white dark:bg-gray-800 antialiased">
    <div class="max-w-screen-xl px-4 mx-auto 2xl:px-0 py-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-8">
                <div class="shrink-0">
                    <a href="#" title="">
                        <img src="{{ asset('assets/img/6962261.jpg') }}" class="w-14 h-14 rounded-full object-cover">
                    </a>
                </div>
                <ul class="hidden lg:flex items-center justify-start gap-6 md:gap-8 py-3 sm:justify-center">
                    <li>
                        <a href="#" title="" class="flex text-sm font-medium text-gray-900 hover:text-primary-700 dark:text-white dark:hover:text-primary-500">Home</a>
                    </li>
                    <li class="shrink-0">
                        <a href="/collections" title="" class="flex text-sm font-medium text-gray-900 hover:text-primary-700 dark:text-white dark:hover:text-primary-500">Collectionis</a>
                    </li>
                    <li class="shrink-0">
                        <a href="#" title="" class="flex text-sm font-medium text-gray-900 hover:text-primary-700 dark:text-white dark:hover:text-primary-500">Gift Ideas</a>
                    </li>
                    <li class="shrink-0">
                        <a href="#" title="" class="text-sm font-medium text-gray-900 hover:text-primary-700 dark:text-white dark:hover:text-primary-500">Today's Deals</a>
                    </li>
                    <li class="shrink-0">
                        <a href="#" title="" class="text-sm font-medium text-gray-900 hover:text-primary-700 dark:text-white dark:hover:text-primary-500">Sell</a>
                    </li>
                </ul>
            </div>
            <div class="flex items-center lg:space-x-2">
                <button id="myCartDropdownButton1" data-dropdown-toggle="myCartDropdown1" type="button" class="inline-flex items-center rounded-lg justify-center p-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-sm font-medium leading-none text-gray-900 dark:text-white">
                    <span class="sr-only">Cart</span>
                    <svg class="w-5 h-5 lg:me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7H7.312"/>
                    </svg> 
                    <span class="hidden sm:flex">My Cart</span>
                    <svg class="hidden sm:flex w-4 h-4 text-gray-900 dark:text-white ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7"/>
                    </svg>              
                </button>
                <div id="myCartDropdown1" class="hidden z-50 mx-auto max-w-sm space-y-4 overflow-hidden rounded-lg bg-white p-4 antialiased shadow-lg dark:bg-gray-800">
                    <!-- Cart Items Here -->
                </div>
                <button id="userDropdownButton1" data-dropdown-toggle="userDropdown1" type="button" class="inline-flex items-center rounded-lg justify-center p-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-sm font-medium leading-none text-gray-900 dark:text-white">
                    <svg class="w-5 h-5 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-width="2" d="M7 17v1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3Zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                    </svg>              
                    @guest
                        Account
                    @else
                        {{ Auth::user()->name }}
                    @endguest
                    <svg class="w-4 h-4 text-gray-900 dark:text-white ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7"/>
                    </svg> 
                </button>
                <div id="userDropdown1" class="hidden z-50 w-56 divide-y divide-gray-100 overflow-hidden overflow-y-auto rounded-lg bg-white antialiased shadow dark:divide-gray-600 dark:bg-gray-700">
                    @guest
                        @if (Route::has('login'))
                            <a class="block px-4 py-2 text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600" href="{{ route('login') }}">
                                {{ __('Login') }}
                            </a>
                        @endif
                        @if (Route::has('register'))
                            <a class="block px-4 py-2 text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600" href="{{ route('register') }}">
                                {{ __('Register') }}
                            </a>
                        @endif
                    @else
                        <a class="block px-4 py-2 text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    @endguest
                </div>
                <button type="button" data-collapse-toggle="ecommerce-navbar-menu-1" aria-controls="ecommerce-navbar-menu-1" aria-expanded="false" class="inline-flex lg:hidden items-center justify-center hover:bg-gray-100 rounded-md dark:hover:bg-gray-700 p-2 text-gray-900 dark:text-white">
                    <span class="sr-only">Open Menu</span>
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h14"/>
                    </svg>                
                </button>
            </div>
        </div>
        <div id="ecommerce-navbar-menu-1" class="bg-gray-50 dark:bg-gray-700 dark:border-gray-600 border border-gray-200 rounded-lg py-3 hidden px-4 mt-4">
            <ul class="text-gray-900 dark:text-white text-sm font-medium dark:text-white space-y-3">
                <li>
                    <a href="#" class="hover:text-primary-700 dark:hover:text-primary-500">Home</a>
                </li>
                <li>
                    <a href="#" class="hover:text-primary-700 dark:hover:text-primary-500">Best Sellers</a>
                </li>
                <li>
                    <a href="#" class="hover:text-primary-700 dark:hover:text-primary-500">Gift Ideas</a>
                </li>
                <li>
                    <a href="#" class="hover:text-primary-700 dark:hover:text-primary-500">Today's Deals</a>
                </li>
                <li>
                    <a href="#" class="hover:text-primary-700 dark:hover:text-primary-500">Sell</a>
                </li>
            </ul>
        </div>
    </div>
</nav>