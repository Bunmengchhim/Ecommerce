<header class="z-10 py-4 bg-white shadow-md dark:bg-gray-800">
    <div class="container flex items-center justify-between px-6 mx-auto text-purple-600 dark:text-purple-300">
        <!-- Mobile hamburger -->
        <button class="p-1 -ml-1 rounded-md md:hidden focus:outline-none focus:shadow-outline-purple" @click="isSideMenuOpen = !isSideMenuOpen" aria-label="Menu">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
            </svg>
        </button>

        <!-- Search bar -->
        <div class="flex flex-1 justify-center lg:mr-32">
            <div class="relative w-full max-w-xl mr-6 focus-within:text-purple-500">
                <div class="absolute inset-y-0 left-0 flex items-center pl-2">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 2a8 8 0 11-5.293 14.293l-4.586 4.586a1 1 0 01-1.414-1.414l4.586-4.586A8 8 0 0110 2zm-3 8a3 3 0 106 0 3 3 0 00-6 0z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <input class="w-full pl-8 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:text-gray-200 dark:bg-gray-700 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input" type="text" placeholder="Search for projects" aria-label="Search">
            </div>
        </div>

        <!-- Profile menu -->
        <div class="relative">
            <button class="flex items-center space-x-2 rounded-full focus:shadow-outline-purple focus:outline-none" @click="isProfileMenuOpen = !isProfileMenuOpen" aria-label="Account" aria-haspopup="true">
                <img class="w-8 h-8 rounded-full" src="https://via.placeholder.com/150" alt="Profile picture">
                <span class="text-sm font-medium">{{ Auth::user()->name }}</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <ul x-show="isProfileMenuOpen" @click.away="isProfileMenuOpen = false" @keydown.escape="isProfileMenuOpen = false" class="absolute right-0 w-48 mt-2 py-2 bg-white rounded-md shadow-lg dark:bg-gray-700">
                <li><a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600">Profile</a></li>
                <li><a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600">Settings</a></li>
                <li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-600">Logout</button>
                    </form>
                </li>
            </ul>
        </div>

    </div>
</header>
