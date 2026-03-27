<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل دخول الإدارة</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

<div class="bg-white p-8 rounded shadow-md w-full max-w-md">
    <h1 class="text-2xl font-bold mb-6 text-center text-gray-800">تسجيل دخول الإدارة</h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.login.post') }}">
        @csrf
        
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2" for="phone">
                رقم الهاتف (الخاص بالمدير)
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline text-left" dir="ltr" id="phone" type="text" name="phone" value="{{ old('phone') }}" required autofocus>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2" for="password">
                كلمة المرور
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline text-left" dir="ltr" id="password" type="password" name="password" required>
        </div>

        <div class="mb-6 flex items-center">
            <input type="checkbox" name="remember" id="remember" class="mr-2 rounded border-gray-300 ml-2">
            <label for="remember" class="text-gray-700">تذكر الدخول</label>
        </div>

        <div class="flex items-center justify-between">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full" type="submit">
                دخول
            </button>
        </div>
    </form>
</div>

</body>
</html>
