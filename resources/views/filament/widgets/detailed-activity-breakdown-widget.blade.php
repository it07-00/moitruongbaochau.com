<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            Thống kê chi tiết hoạt động theo Ngày / Tuần / Tháng / Năm
        </x-slot>

        <x-slot name="description">
            Tổng hợp bài đăng mới, dịch vụ mới, dự án, tuyển dụng, liên hệ, hồ sơ khai báo và lưu lượng truy cập (cập nhật lúc {{ $this->getDateSummary() }}).
        </x-slot>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm divide-y divide-gray-200 dark:divide-white/10">
                <thead>
                    <tr class="bg-gray-50 dark:bg-white/5 text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">
                        <th class="px-4 py-3">Hạng mục</th>
                        <th class="px-3 py-3 text-right">Hôm nay</th>
                        <th class="px-3 py-3 text-right">Tuần này</th>
                        <th class="px-3 py-3 text-right">Tháng này</th>
                        <th class="px-3 py-3 text-right">Năm nay</th>
                        <th class="px-3 py-3 text-right">Tổng cộng</th>
                        <th class="px-4 py-3">Trạng thái / Chi tiết</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-white/10">
                    @foreach ($this->getRows() as $row)
                        @php
                            $badgeClasses = match ($row['highlight_tone']) {
                                'warning' => 'bg-amber-50 text-amber-700 ring-amber-600/20 dark:bg-amber-400/10 dark:text-amber-400 dark:ring-amber-400/30',
                                'success' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20 dark:bg-emerald-400/10 dark:text-emerald-400 dark:ring-emerald-400/30',
                                'info' => 'bg-sky-50 text-sky-700 ring-sky-600/20 dark:bg-sky-400/10 dark:text-sky-400 dark:ring-sky-400/30',
                                default => 'bg-gray-50 text-gray-700 ring-gray-600/20 dark:bg-white/5 dark:text-gray-300 dark:ring-white/15',
                            };
                        @endphp
                        <tr class="hover:bg-gray-50/75 dark:hover:bg-white/5 transition-colors">
                            <td class="px-4 py-3">
                                <a href="{{ $row['url'] }}" class="font-medium text-gray-950 hover:text-emerald-600 dark:text-white dark:hover:text-emerald-400">
                                    {{ $row['label'] }}
                                </a>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $row['group'] }}
                                </div>
                            </td>
                            <td class="px-3 py-3 text-right font-medium tabular-nums {{ $row['today'] > 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-gray-500 dark:text-gray-400' }}">
                                {{ number_format($row['today']) }}
                            </td>
                            <td class="px-3 py-3 text-right tabular-nums text-gray-700 dark:text-gray-200">
                                {{ number_format($row['week']) }}
                            </td>
                            <td class="px-3 py-3 text-right tabular-nums text-gray-700 dark:text-gray-200">
                                {{ number_format($row['month']) }}
                            </td>
                            <td class="px-3 py-3 text-right tabular-nums text-gray-700 dark:text-gray-200">
                                {{ number_format($row['year']) }}
                            </td>
                            <td class="px-3 py-3 text-right font-semibold tabular-nums text-gray-950 dark:text-white">
                                {{ number_format($row['total']) }}
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset {{ $badgeClasses }}">
                                    {{ $row['highlight_label'] }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
