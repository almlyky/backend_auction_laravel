@extends('admin.layout')

@section('title', 'إدارة البلاغات')

@section('content')
<div class="space-y-8">
    
    <!-- Pending Reports Table -->
    <div class="bg-white p-6 rounded-lg shadow-lg border-t-4 border-red-500">
        <h2 class="text-2xl font-bold mb-4 text-red-700 flex justify-between items-center">
            <span>البلاغات المعلقة (Pending)</span>
            <span class="bg-red-100 text-red-800 text-sm py-1 px-3 rounded-full">{{ $pendingReports->count() }}</span>
        </h2>

        @if($pendingReports->count() > 0)
            @include('admin.reports.partials._table', ['reports' => $pendingReports])
        @else
            <p class="text-gray-500 text-center py-4 bg-gray-50 rounded">لا توجد بلاغات معلقة حالياً.</p>
        @endif
    </div>

    <!-- Reviewed Reports Table -->
    <div class="bg-white p-6 rounded-lg shadow-lg border-t-4 border-yellow-500">
        <h2 class="text-2xl font-bold mb-4 text-yellow-700 flex justify-between items-center">
            <span>البلاغات قيد المراجعة (Reviewed)</span>
            <span class="bg-yellow-100 text-yellow-800 text-sm py-1 px-3 rounded-full">{{ $reviewedReports->count() }}</span>
        </h2>

        @if($reviewedReports->count() > 0)
            @include('admin.reports.partials._table', ['reports' => $reviewedReports])
        @else
            <p class="text-gray-500 text-center py-4 bg-gray-50 rounded">لا توجد بلاغات قيد المراجعة حالياً.</p>
        @endif
    </div>

    <!-- Rejected/Resolved Reports Table -->
    <div class="bg-white p-6 rounded-lg shadow-lg border-t-4 border-green-500">
        <h2 class="text-2xl font-bold mb-4 text-green-700 flex justify-between items-center">
            <span>البلاغات المرفوضة/المحلولة (Rejected)</span>
            <span class="bg-green-100 text-green-800 text-sm py-1 px-3 rounded-full">{{ $rejectedReports->count() }}</span>
        </h2>

        @if($rejectedReports->count() > 0)
            @include('admin.reports.partials._table', ['reports' => $rejectedReports])
        @else
            <p class="text-gray-500 text-center py-4 bg-gray-50 rounded">لا توجد بلاغات مرفوضة حالياً.</p>
        @endif
    </div>

</div>
@endsection
