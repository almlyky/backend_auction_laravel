@extends('admin.layout')

@section('title', 'إدارة الإعلانات')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-lg">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">كل الإعلانات</h2>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full leading-normal text-right">
            <thead>
                <tr>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        رقم الإعلان / العنوان
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        الناشر
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        البلاغات
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        الحالة النظامية
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        حالة البيع
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        إجراءات
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($posts as $post)
                <tr class="{{ $post->trashed() ? 'bg-red-50' : '' }}">
                    <td class="px-5 py-5 border-b border-gray-200 text-sm">
                        <p class="text-gray-900 whitespace-no-wrap font-bold">#{{ $post->id }} - {{ Str::limit($post->name, 30) }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $post->created_at->format('Y-m-d') }}</p>
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 text-sm">
                        @if($post->user)
                            <a href="{{ route('admin.users.show', $post->user->id) }}" class="text-blue-600 hover:text-blue-800 font-semibold">{{ $post->user->name }}</a>
                        @else
                            <p class="text-gray-500 italic">مستخدم محذوف</p>
                        @endif
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 text-sm">
                        @if($post->reports_count > 0)
                            <span class="bg-red-100 text-red-800 text-xs font-bold px-2 py-1 rounded-full whitespace-nowrap">
                                {{ $post->reports_count }} بلاغ
                            </span>
                        @else
                            <span class="text-gray-500 text-xs">لا يوجد</span>
                        @endif
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 text-sm">
                        @if($post->trashed())
                            <span class="px-2 py-1 bg-red-100 text-red-800 font-bold rounded text-xs">محذوف (تم إيقافه)</span>
                        @else
                            <span class="px-2 py-1 bg-green-100 text-green-800 font-bold rounded text-xs">نشط</span>
                        @endif
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 text-sm">
                        <span class="text-gray-700 font-semibold text-xs">{{ $post->status == 1 ? 'مفتوح' : 'مغلق/مباع' }}</span>
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 text-sm text-right flex flex-col gap-2">
                        <a href="{{ route('admin.posts.show', $post->id) }}" class="text-center bg-blue-50 text-blue-600 hover:text-blue-900 border border-blue-200 font-bold py-1 px-3 rounded text-xs whitespace-nowrap">عرض</a>
                        
                        @if($post->trashed())
                            <form action="{{ route('admin.posts.restore', $post->id) }}" method="POST" class="inline" onsubmit="return confirm('هل أنت متأكد من استعادة هذا الإعلان؟');">
                                @csrf
                                <button type="submit" class="w-full text-center bg-green-500 hover:bg-green-600 text-white font-bold py-1 px-3 rounded text-xs transition-colors shadow">استعادة</button>
                            </form>
                        @else
                            <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" class="inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا الإعلان؟');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full text-center bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded text-xs transition-colors shadow">حذف</button>
                            </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $posts->links() }}
    </div>
</div>
@endsection
