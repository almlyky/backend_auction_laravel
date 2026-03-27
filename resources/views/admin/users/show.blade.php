@extends('admin.layout')

@section('title', 'ملف المستخدم')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-lg mb-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold">ملف المستخدم: {{ $user->name }}</h2>
        <a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:text-blue-800 font-bold">&rarr; العودة للقائمة</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- User Info -->
        <div class="bg-gray-50 p-6 rounded-lg border shadow-sm">
            <h3 class="text-xl font-bold border-b pb-2 mb-4">بيانات المستخدم</h3>
            <ul class="space-y-3">
                <li><span class="font-bold text-gray-700">الاسم:</span> {{ $user->name }}</li>
                <li><span class="font-bold text-gray-700">رقم الهاتف:</span> <span dir="ltr">{{ $user->phone }}</span></li>
                <li><span class="font-bold text-gray-700">تاريخ التسجيل:</span> <span dir="ltr">{{ $user->created_at->format('Y-m-d') }}</span></li>
                <li class="pt-3 border-t">
                    <span class="font-bold text-gray-700">الحالة الحالية:</span> 
                    @if($user->is_blocked)
                        <span class="text-red-600 font-bold ml-2 text-lg">محظور <i class="fas fa-ban"></i></span>
                    @else
                        <span class="text-green-600 font-bold ml-2 text-lg">نشط <i class="fas fa-check-circle"></i></span>
                    @endif
                </li>
            </ul>

            <div class="mt-6 pt-4 border-t text-center">
                <form action="{{ route('admin.users.toggle_block', $user->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full py-3 px-4 rounded font-bold text-white shadow-md transition duration-300 {{ $user->is_blocked ? 'bg-green-500 hover:bg-green-600' : 'bg-red-600 hover:bg-red-700' }}">
                        {{ $user->is_blocked ? 'فك الحظر عن المستخدم' : 'إصدار حظر للمستخدم' }}
                    </button>
                </form>
            </div>
        </div>

        <!-- Stats & Posts -->
        <div class="bg-gray-50 p-6 rounded-lg border shadow-sm col-span-1 md:col-span-2">
            <h3 class="text-xl font-bold border-b pb-2 mb-4">نشاط المستخدم</h3>
            
            <div class="flex gap-4 mb-6">
                <div class="flex-1 bg-blue-100 p-4 rounded text-center border border-blue-200">
                    <span class="block text-gray-600 mb-1">إجمالي الإعلانات</span>
                    <span class="text-3xl font-bold text-blue-800">{{ $user->posts_count }}</span>
                </div>
                <div class="flex-1 bg-red-100 p-4 rounded text-center border border-red-200">
                    <span class="block text-gray-600 mb-1">البلاغات المتلقاة</span>
                    <span class="text-3xl font-bold text-red-800">{{ $user->received_reports_count }}</span>
                </div>
                <div class="flex-1 bg-purple-100 p-4 rounded text-center border border-purple-200">
                    <span class="block text-gray-600 mb-1">الأشخاص المحظورين بواسطته</span>
                    <span class="text-3xl font-bold text-purple-800">{{ $user->blocks_received_count }}</span>
                </div>
            </div>

            <h4 class="font-bold text-lg mb-3">أحدث الإعلانات (عرض سريع)</h4>
            @if($user->posts->count() > 0)
                <ul class="divide-y divide-gray-200">
                    @foreach($user->posts as $post)
                        <li class="py-3 flex justify-between items-center group">
                            <span class="font-medium text-gray-800">{{ Str::limit($post->name ?? 'إعلان #' . $post->id, 40) }}</span>
                            <div class="flex items-center gap-3">
                                <span class="text-sm text-gray-500">{{ $post->created_at->format('Y-m-d') }}</span>
                                <a href="{{ route('admin.posts.show', $post->id) }}" class="text-blue-500 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 px-3 py-1 rounded-full text-sm font-bold opacity-80 group-hover:opacity-100 transition-all">
                                    تفاصيل الإعلان
                                </a>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-500 italic">لا يوجد إعلانات لهذا المستخدم.</p>
            @endif
        </div>
    </div>
</div>

<!-- Reports History -->
<div class="bg-white p-6 rounded-lg shadow-lg">
    <h3 class="text-xl font-bold mb-4">سجل البلاغات المرفوعة ضده</h3>
    
    @if($user->receivedReports->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full leading-normal text-right">
                <thead>
                    <tr>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-600 uppercase tracking-wider">مُقدم البلاغ</th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-600 uppercase tracking-wider">السبب</th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-600 uppercase tracking-wider">تاريخ البلاغ</th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-600 uppercase tracking-wider">حالة البلاغ</th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-600 uppercase tracking-wider">إدارة</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($user->receivedReports as $report)
                    <tr>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">
                            {{ optional($report->reporter)->name ?? 'مجهول' }}
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">
                            {{ Str::limit($report->reason, 50) }}
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">
                            {{ $report->created_at->format('Y-m-d') }}
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">
                            <span class="px-2 py-1 rounded {{ $report->status == 'pending' ? 'bg-red-100 text-red-800' : ($report->status == 'resolved' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800') }}">
                                {{ $report->status }}
                            </span>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">
                            <a href="{{ route('admin.reports.show', $report->id) }}" class="text-blue-600 hover:underline">عرض البلاغ</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="bg-green-50 text-green-700 p-4 rounded border border-green-200 text-center">
            هذا المستخدم لم يتلق أي بلاغات حتى الآن. حسابه نظيف.
        </div>
    @endif
</div>
@endsection
