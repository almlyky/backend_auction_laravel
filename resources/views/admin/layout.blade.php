<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم الإدارة - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal text-gray-800">

<div class="flex flex-col md:flex-row min-h-screen">
    <!-- Sidebar -->
    <div class="bg-gray-800 shadow-xl h-16 fixed bottom-0 md:relative md:h-auto z-10 w-full md:w-64">
        <div class="md:mt-12 md:w-64 md:fixed md:left-auto md:top-0 md:content-start text-left justify-between bg-gray-800 shadow-xl">
            <ul class="list-reset flex flex-row md:flex-col pt-3 md:py-3 px-1 md:px-2 text-center md:text-right">
                <li class="mr-3 flex-1">
                    <a href="{{ route('admin.dashboard') }}" class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 {{ request()->routeIs('admin.dashboard') ? 'border-blue-600' : 'border-gray-800' }} hover:border-blue-500">
                        <i class="fas fa-tasks pr-0 md:pr-3"></i><span class="pb-1 md:pb-0 text-xs md:text-base text-gray-400 md:text-gray-200 block md:inline-block">لوحة القيادة</span>
                    </a>
                </li>
                <li class="mr-3 flex-1">
                    <a href="{{ route('admin.users.index') }}" class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 {{ request()->routeIs('admin.users.*') ? 'border-blue-600' : 'border-gray-800' }} hover:border-blue-500">
                        <i class="fa fa-users pr-0 md:pr-3"></i><span class="pb-1 md:pb-0 text-xs md:text-base text-gray-400 md:text-gray-200 block md:inline-block">المستخدمين</span>
                    </a>
                </li>
                <li class="mr-3 flex-1">
                    <a href="{{ route('admin.posts.index') }}" class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 {{ request()->routeIs('admin.posts.*') ? 'border-blue-600' : 'border-gray-800' }} hover:border-blue-500">
                        <i class="fa fa-box-open pr-0 md:pr-3"></i><span class="pb-1 md:pb-0 text-xs md:text-base text-gray-400 md:text-gray-200 block md:inline-block">الإعلانات</span>
                    </a>
                </li>
                <li class="mr-3 flex-1">
                    <a href="{{ route('admin.reports.index') }}" class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 {{ request()->routeIs('admin.reports.*') ? 'border-blue-600' : 'border-gray-800' }} hover:border-blue-500">
                        <i class="fa fa-envelope pr-0 md:pr-3"></i><span class="pb-1 md:pb-0 text-xs md:text-base text-gray-400 md:text-gray-200 block md:inline-block">البلاغات</span>
                    </a>
                </li>
                <li class="mr-3 flex-1">
                    <a href="/" class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 border-gray-800 hover:border-blue-500">
                        <i class="fa fa-home pr-0 md:pr-3"></i><span class="pb-1 md:pb-0 text-xs md:text-base text-gray-400 md:text-gray-200 block md:inline-block">العودة للموقع</span>
                    </a>
                </li>
                <li class="mr-3 flex-1">
                    <form method="POST" action="{{ route('admin.logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="w-full text-right block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 border-gray-800 hover:border-red-500">
                            <i class="fa fa-sign-out-alt pr-0 md:pr-3"></i><span class="pb-1 md:pb-0 text-xs md:text-base text-gray-400 md:text-gray-200 block md:inline-block">تسجيل خروج</span>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content flex-1 bg-gray-100 mt-12 md:mt-2 pb-24 md:pb-5">
        <div class="bg-gray-800 pt-3 flex justify-between px-6 py-2 shadow-md items-center">
            <h1 class="text-white text-2xl">الإدارة</h1>
        </div>

        <div class="p-6">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            @yield('content')
        </div>
    </div>
</div>
</body>
</html>
