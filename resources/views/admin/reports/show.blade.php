@extends('admin.layout')

@section('title', 'تفاصيل البلاغ')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-lg">
    <div class="mb-4 flex justify-between items-center">
        <h2 class="text-2xl font-bold">تفاصيل البلاغ #{{ $report->id }}</h2>
        <a href="{{ route('admin.reports.index') }}" class="text-gray-600 hover:text-gray-900">العودة للقائمة &rarr;</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Report Info -->
        <div class="bg-gray-50 p-4 rounded border">
            <h3 class="font-bold mb-2 border-b pb-2">معلومات البلاغ</h3>
            <p><span class="font-semibold text-gray-700">المبلغ:</span> {{ optional($report->reporter)->name ?? 'مجهول' }} ({{ optional($report->reporter)->phone }})</p>
            <p class="mt-2"><span class="font-semibold text-gray-700">تاريخ البلاغ:</span> {{ $report->created_at->format('Y-m-d H:i') }}</p>
            <div class="mt-4">
                <span class="font-semibold text-gray-700 block mb-1">سبب البلاغ:</span>
                <p class="bg-white p-3 border rounded text-gray-800">{{ $report->reason }}</p>
            </div>
        </div>

        <!-- Target Info -->
        <div class="bg-gray-50 p-4 rounded border">
            <h3 class="font-bold mb-2 border-b pb-2 flex justify-between items-center">
                <span>المبلغ عنه</span>
                <span class="px-2 py-1 text-sm font-bold rounded {{ $report->report_type == 'إعلان' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                    بلاغ {{ $report->report_type }}
                </span>
            </h3>
            
            @if($report->reportedUser)
                <p><span class="font-semibold text-gray-700">المستخدم:</span> {{ $report->reportedUser->name }}</p>
                <p><span class="font-semibold text-gray-700">رقم الهاتف:</span> {{ $report->reportedUser->phone }}</p>
                
                <div class="mt-4 pt-4 border-t">
                    <p class="mb-2"><span class="font-semibold text-gray-700">حالة الحظر:</span> 
                        {!! $report->reportedUser->is_blocked ? '<span class="text-red-600 font-bold">محظور</span>' : '<span class="text-green-600 font-bold">نشط</span>' !!}
                    </p>
                    
                    <form action="{{ route('admin.users.toggle_block', $report->reportedUser->id) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2 rounded text-white font-bold {{ $report->reportedUser->is_blocked ? 'bg-green-500 hover:bg-green-600' : 'bg-red-500 hover:bg-red-600' }}">
                            {{ $report->reportedUser->is_blocked ? 'إلغاء حظر المستخدم' : 'حظر المستخدم' }}
                        </button>
                    </form>
                </div>
            @endif

            @if($report->reportedPost)
                <div class="{{ $report->reportedUser ? 'mt-4 pt-4 border-t' : '' }}">
                    <p><span class="font-semibold text-gray-700">الإعلان:</span> #{{ $report->reportedPost->id }} - {{ $report->reportedPost->name ?? 'بدون عنوان' }}</p>
                    <a href="{{ route('admin.posts.show', $report->reportedPost->id) }}" class="inline-block mt-2 bg-blue-100 hover:bg-blue-200 text-blue-800 font-bold py-1 px-3 rounded text-sm transition-colors mb-2">
                        &larr; عرض تفاصيل الإعلان
                    </a>
                    
                    <div class="mt-2 pt-3 border-t flex flex-wrap gap-2">
                        <form action="{{ route('admin.posts.destroy', $report->reportedPost->id) }}" method="POST" class="inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا الإعلان؟');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded text-sm transition-colors shadow">
                                حذف الإعلان <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        
                        @if($report->reportedPost->user)
                            <form action="{{ route('admin.users.toggle_block', $report->reportedPost->user->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="font-bold py-1 px-3 rounded text-sm transition-colors shadow text-white {{ $report->reportedPost->user->is_blocked ? 'bg-green-500 hover:bg-green-600' : 'bg-red-600 hover:bg-red-700' }}">
                                    {{ $report->reportedPost->user->is_blocked ? 'إلغاء حظر صاحب الإعلان' : 'حظر صاحب الإعلان' }} <i class="fas fa-user-slash"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Admin Actions -->
    <div class="mt-8 pt-6 border-t">
        <h3 class="text-xl font-bold mb-4">تحديث حالة البلاغ</h3>
        
        <form action="{{ route('admin.reports.update_status', $report->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="status">
                    الحالة
                </label>
                <select name="status" id="status" class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline">
                    <option value="pending" {{ $report->status == 'pending' ? 'selected' : '' }}>قيد الانتظار (Pending)</option>
                    <option value="reviewed" {{ $report->status == 'reviewed' ? 'selected' : '' }}>تمت المراجعة (Reviewed)</option>
                    <option value="rejected" {{ $report->status == 'rejected' ? 'selected' : '' }}>مرفوض / تم الحل (Rejected)</option>
                </select>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="admin_notes">
                    ملاحظات الإدارة (اختياري)
                </label>
                <textarea name="admin_notes" id="admin_notes" rows="3" class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline">{{ old('admin_notes', $report->admin_notes) }}</textarea>
            </div>
            
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                حفظ التغييرات
            </button>
        </form>
    </div>
</div>
@endsection
