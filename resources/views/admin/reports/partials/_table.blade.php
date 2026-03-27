<div class="overflow-x-auto">
    <table class="min-w-full leading-normal text-right">
        <thead>
            <tr>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    المبلغ
                </th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    نوع البلاغ
                </th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    المعني بالبلاغ
                </th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    التاريخ
                </th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    إجراءات
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($reports as $report)
            <tr>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                    <p class="text-gray-900 whitespace-no-wrap">{{ optional($report->reporter)->name ?? 'مجهول' }}</p>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                    <span class="px-2 py-1 text-xs font-bold rounded {{ $report->report_type == 'إعلان' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                        {{ $report->report_type }}
                    </span>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                    @if($report->report_type == 'إعلان')
                        <p class="text-gray-900 whitespace-no-wrap">{{ optional($report->reportedPost)->title ?? 'إعلان #' . $report->reported_post_id }}</p>
                    @else
                        <p class="text-gray-900 whitespace-no-wrap">{{ optional($report->reportedUser)->name ?? 'مستخدم #' . $report->reported_user_id }}</p>
                    @endif
                </td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                    <p class="text-gray-900 whitespace-no-wrap">{{ $report->created_at->format('Y-m-d') }}</p>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                    <a href="{{ route('admin.reports.show', $report->id) }}" class="text-indigo-600 hover:text-indigo-900 font-bold bg-indigo-50 px-3 py-1 rounded">عرض التفاصيل</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
