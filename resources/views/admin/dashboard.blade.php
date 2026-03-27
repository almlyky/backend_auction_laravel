@extends('admin.layout')

@section('title', 'الرئيسية')

@section('content')
<div class="flex flex-wrap -mx-3 mb-6">
    <div class="w-full md:w-1/2 xl:w-1/3 p-3">
        <div class="bg-blue-100 border-b-4 border-blue-500 rounded-lg shadow-lg p-5">
            <div class="flex flex-row items-center">
                <div class="flex-shrink pr-4">
                    <div class="rounded-full p-5 bg-blue-600"><i class="fas fa-users fa-2x fa-inverse"></i></div>
                </div>
                <div class="flex-1 text-right md:text-center">
                    <h2 class="font-bold uppercase text-gray-600">إجمالي المستخدمين</h2>
                    <p class="font-bold text-3xl">{{ $usersCount }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="w-full md:w-1/2 xl:w-1/3 p-3">
        <div class="bg-red-100 border-b-4 border-red-500 rounded-lg shadow-lg p-5">
            <div class="flex flex-row items-center">
                <div class="flex-shrink pr-4">
                    <div class="rounded-full p-5 bg-red-600"><i class="fas fa-exclamation-triangle fa-2x fa-inverse"></i></div>
                </div>
                <div class="flex-1 text-right md:text-center">
                    <h2 class="font-bold uppercase text-gray-600">البلاغات المعلقة</h2>
                    <p class="font-bold text-3xl">{{ $pendingReportsCount }} <span class="text-red-500"><i class="fas fa-caret-up"></i></span></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
