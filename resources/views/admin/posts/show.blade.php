@extends('admin.layout')

@section('title', 'تفاصيل الإعلان')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-lg mb-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold">تفاصيل الإعلان: {{ $post->name }}</h2>
        <a href="{{ url()->previous() }}" class="text-blue-600 hover:text-blue-800 font-bold">&rarr; رجوع للخلف</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Post Info -->
        <div class="bg-gray-50 p-6 rounded-lg border shadow-sm">
            <h3 class="text-xl font-bold border-b pb-2 mb-4">بيانات الإعلان</h3>
            <ul class="space-y-3">
                <li><span class="font-bold text-gray-700">الرقم المرجعي:</span> #{{ $post->id }}</li>
                <li><span class="font-bold text-gray-700">العنوان:</span> {{ $post->name }}</li>
                <li><span class="font-bold text-gray-700">السعر:</span> {{ $post->price }} ريال</li>
                <li><span class="font-bold text-gray-700">مكان البيع:</span> {{ $post->address }}</li>
                <li><span class="font-bold text-gray-700">القسم:</span> {{ optional($post->category)->name ?? 'غير محدد' }}</li>
                <li><span class="font-bold text-gray-700">حالة الإعلان:</span> {{ $post->status == 1 ? 'مفتوح' : 'مغلق/مباع' }}</li>
                <li><span class="font-bold text-gray-700">حالة المنتج:</span> {{ $post->product_status == 1 ? 'جديد' : 'مستعمل' }}</li>
                <li><span class="font-bold text-gray-700">تاريخ النشر:</span> <span dir="ltr">{{ $post->created_at->format('Y-m-d H:i') }}</span></li>
            </ul>
            
            <hr class="my-4">
            
            <h3 class="text-lg font-bold mb-2">الناشر</h3>
            @if($post->user)
                <p class="font-bold">{{ $post->user->name }}</p>
                <p class="text-sm text-gray-600 mb-3" dir="ltr">{{ $post->user->phone }}</p>
                <a href="{{ route('admin.users.show', $post->user->id) }}" class="inline-block bg-blue-100 hover:bg-blue-200 text-blue-800 font-semibold py-1 px-3 rounded text-sm transition-colors text-center w-full">إدارة الناشر</a>
            @else
                <p class="text-red-500 italic">مستخدم غير معروف أو محذوف</p>
            @endif
        </div>

        <!-- Post Description & Images -->
        <div class="bg-gray-50 p-6 rounded-lg border shadow-sm col-span-1 md:col-span-2">
            <h3 class="text-xl font-bold border-b pb-2 mb-4">الوصف</h3>
            <div class="prose max-w-none text-gray-800 mb-8 whitespace-pre-wrap leading-relaxed bg-white p-4 rounded border">
{{ $post->discribtion ?? 'لا يوجد وصف للإعلان' }}
            </div>

            <h3 class="text-xl font-bold border-b pb-2 mb-4">الصور המرفقة</h3>
            @if($post->images && count($post->images) > 0)
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($post->images as $image)
                        <div class="border rounded bg-white p-1 shadow-sm aspect-square flex items-center justify-center overflow-hidden group relative">
                            <!-- Try matching typical structure for file paths, adjust if your image path is different visually -->
                            <img src="{{ asset($image->image_url ?? $image->path ?? 'storage/' . $image->image) }}" alt="Post image" class="object-cover w-full h-full transform group-hover:scale-110 transition-transform duration-300">
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 italic bg-white p-4 text-center rounded border">لا توجد صور مرفقة مع هذا الإعلان.</p>
            @endif
        </div>
    </div>
</div>
@endsection
