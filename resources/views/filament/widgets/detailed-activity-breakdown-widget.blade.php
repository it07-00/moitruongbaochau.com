<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            Thống kê chi tiết hoạt động theo Ngày / Tuần / Tháng / Năm
        </x-slot>

        <x-slot name="description">
            Tổng hợp bài đăng mới, dịch vụ mới, dự án, tuyển dụng, liên hệ, hồ sơ khai báo và lưu lượng truy cập (cập nhật lúc {{ $this->getDateSummary() }}).
        </x-slot>

        <style>
            .bc-stats-table-wrap {
                overflow-x: auto;
                margin: -0.25rem -0.5rem 0;
                border-radius: 0.75rem;
                border: 1px solid rgba(148, 163, 184, 0.2);
            }

            .bc-stats-table {
                width: 100%;
                border-collapse: collapse;
                font-size: 0.875rem;
                line-height: 1.35;
            }

            .bc-stats-table thead tr {
                background-color: rgba(148, 163, 184, 0.1);
                border-bottom: 1px solid rgba(148, 163, 184, 0.22);
            }

            .bc-stats-table th {
                padding: 0.75rem 1rem;
                font-size: 0.75rem;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.04em;
                color: #64748b;
                white-space: nowrap;
            }

            .dark .bc-stats-table th {
                color: #94a3b8;
            }

            .bc-stats-table tbody tr {
                border-bottom: 1px solid rgba(148, 163, 184, 0.14);
                transition: background-color 150ms ease;
            }

            .bc-stats-table tbody tr:last-child {
                border-bottom: none;
            }

            .bc-stats-table tbody tr:hover {
                background-color: rgba(16, 185, 129, 0.06);
            }

            .bc-stats-table td {
                padding: 0.8rem 1rem;
                vertical-align: middle;
            }

            .bc-stats-num {
                text-align: right;
                font-variant-numeric: tabular-nums;
                white-space: nowrap;
                color: #334155;
            }

            .dark .bc-stats-num {
                color: #e2e8f0;
            }

            .bc-stats-num--muted {
                color: #94a3b8;
            }

            .dark .bc-stats-num--muted {
                color: #64748b;
            }

            .bc-stats-num--today {
                font-weight: 700;
                color: #059669;
            }

            .dark .bc-stats-num--today {
                color: #34d399;
            }

            .bc-stats-num--total {
                font-weight: 700;
                color: #0f172a;
            }

            .dark .bc-stats-num--total {
                color: #ffffff;
            }

            .bc-stats-link {
                display: inline-block;
                font-weight: 600;
                color: #0f172a;
                text-decoration: none;
            }

            .bc-stats-link:hover {
                color: #059669;
            }

            .dark .bc-stats-link {
                color: #f8fafc;
            }

            .dark .bc-stats-link:hover {
                color: #34d399;
            }

            .bc-stats-group {
                margin-top: 0.15rem;
                font-size: 0.75rem;
                color: #64748b;
            }

            .dark .bc-stats-group {
                color: #94a3b8;
            }

            .bc-stats-badge {
                display: inline-flex;
                align-items: center;
                padding: 0.25rem 0.625rem;
                border-radius: 0.375rem;
                font-size: 0.75rem;
                font-weight: 600;
                white-space: nowrap;
                border: 1px solid transparent;
            }

            .bc-stats-badge--warning {
                background-color: rgba(245, 158, 11, 0.12);
                color: #b45309;
                border-color: rgba(245, 158, 11, 0.3);
            }

            .dark .bc-stats-badge--warning {
                color: #fbbf24;
            }

            .bc-stats-badge--success {
                background-color: rgba(16, 185, 129, 0.12);
                color: #047857;
                border-color: rgba(16, 185, 129, 0.3);
            }

            .dark .bc-stats-badge--success {
                color: #34d399;
            }

            .bc-stats-badge--info {
                background-color: rgba(14, 165, 233, 0.12);
                color: #0369a1;
                border-color: rgba(14, 165, 233, 0.3);
            }

            .dark .bc-stats-badge--info {
                color: #38bdf8;
            }

            .bc-stats-badge--gray {
                background-color: rgba(148, 163, 184, 0.12);
                color: #475569;
                border-color: rgba(148, 163, 184, 0.28);
            }

            .dark .bc-stats-badge--gray {
                color: #cbd5e1;
            }
        </style>

        <div class="bc-stats-table-wrap">
            <table class="bc-stats-table">
                <thead>
                    <tr>
                        <th style="text-align: left; min-width: 240px;">Hạng mục</th>
                        <th style="text-align: right;">Hôm nay</th>
                        <th style="text-align: right;">Tuần này</th>
                        <th style="text-align: right;">Tháng này</th>
                        <th style="text-align: right;">Năm nay</th>
                        <th style="text-align: right;">Tổng cộng</th>
                        <th style="text-align: left; min-width: 170px;">Trạng thái / Chi tiết</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($this->getRows() as $row)
                        @php
                            $badgeModifier = match ($row['highlight_tone']) {
                                'warning' => 'bc-stats-badge--warning',
                                'success' => 'bc-stats-badge--success',
                                'info' => 'bc-stats-badge--info',
                                default => 'bc-stats-badge--gray',
                            };
                        @endphp
                        <tr>
                            <td>
                                <a href="{{ $row['url'] }}" class="bc-stats-link">
                                    {{ $row['label'] }}
                                </a>
                                <div class="bc-stats-group">
                                    {{ $row['group'] }}
                                </div>
                            </td>
                            <td class="bc-stats-num {{ $row['today'] > 0 ? 'bc-stats-num--today' : 'bc-stats-num--muted' }}">
                                {{ number_format($row['today']) }}
                            </td>
                            <td class="bc-stats-num">
                                {{ number_format($row['week']) }}
                            </td>
                            <td class="bc-stats-num">
                                {{ number_format($row['month']) }}
                            </td>
                            <td class="bc-stats-num">
                                {{ number_format($row['year']) }}
                            </td>
                            <td class="bc-stats-num bc-stats-num--total">
                                {{ number_format($row['total']) }}
                            </td>
                            <td>
                                <span class="bc-stats-badge {{ $badgeModifier }}">
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
