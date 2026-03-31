<x-app-layout>
    <style>
        .od-page-wrapper {
            margin-top: 10px;
        }

        .od-breadcrumb-title {
            font-size: 1.4rem;
            font-weight: 600;
        }

        .od-card {
            margin-top: 16px;
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
        }

        .od-card-body {
            padding: 20px 24px;
        }

        .od-table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        .od-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.875rem;
            color: #111827;
            table-layout: auto;
        }

        .od-table thead {
            background: linear-gradient(90deg, #f3f4f6 0%, #eef2ff 100%);
        }

        .od-table th,
        .od-table td {
            padding: 0.75rem 0.9rem;
            border-bottom: 1px solid #e5e7eb;
            border-right: 1px solid #f3f4f6;
            white-space: nowrap;
        }

        .od-table th:last-child,
        .od-table td:last-child {
            border-right: none;
        }

        .od-table th {
            font-weight: 600;
            text-align: left;
            color: #4b5563;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .od-table tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }

        .od-table tbody tr:hover {
            background-color: #eff6ff;
            transition: background-color 0.2s ease;
        }

        .od-table td {
            font-size: 14px;
            color: #111827;
        }

        .od-table td.od-cell-number {
            text-align: right;
            font-variant-numeric: tabular-nums;
        }

        .od-empty-state {
            padding: 2rem 0;
            text-align: center;
            color: #6b7280;
            font-size: 0.95rem;
        }

        .od-empty-state span {
            display: inline-block;
            padding: 0.4rem 0.8rem;
            border-radius: 999px;
            background: #f3f4f6;
        }

        /* header + edit button */
        .od-th-header {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
        }

        .od-th-title {
            display: inline-block;
            max-width: 220px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .od-th-edit-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 22px;
            height: 22px;
            border-radius: 999px;
            border: 1px solid #e5e7eb;
            background: #ffffff;
            padding: 0;
            font-size: 11px;
            color: #4b5563;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.15s ease, color 0.15s ease, border-color 0.15s ease;
        }

        .od-th-edit-btn:hover {
            background: #2563eb;
            color: #ffffff;
            border-color: #2563eb;
        }

        @media (max-width: 768px) {
            .od-card-body {
                padding: 16px 12px;
            }

            .od-breadcrumb-title {
                font-size: 1.1rem;
            }

            .od-table th,
            .od-table td {
                padding: 0.6rem 0.7rem;
                font-size: 0.8rem;
            }

            .od-th-title {
                max-width: 140px;
            }
        }
    </style>
    <div class="od-page-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0 od-breadcrumb-title">
                            Открытые данные: {{ $post->alias }}
                        </h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ url_a() }}">Главная</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ url_a() . 'opendata' }}">Opendata</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    {{ char_lim(_t($post->title), 60) }}
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="od-card">
            <div class="od-card-body">
                @if(empty($rows))
                    <div class="od-empty-state">
                        <span>Данные отсутствуют или API не вернул результат.</span>
                    </div>
                @else
                    <div class="od-table-wrapper">
                        <table class="od-table">
                            <thead>
                            <tr>
                                @foreach($columns as $col)
                                    @php
                                        $metaItem = $meta[$col] ?? null;
                                        $header   = $metaItem ? _t($metaItem->title) : $col;
                                    @endphp
                                    <th>
                                        <div class="od-th-header">
                                            <span class="od-th-title">{{ $header }}</span>

                                            @if($metaItem)
                                                <a href="{{ url_a() . 'opendata/edit/' . $metaItem->id . getPage() }}"
                                                   class="od-th-edit-btn"
                                                   title="Изменить название колонки">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </th>
                                @endforeach
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($rows as $row)
                                <tr>
                                    @foreach($columns as $col)
                                        @php
                                            $value = $row[$col] ?? '';
                                            $isNumeric = is_numeric($value);
                                        @endphp
                                        <td class="{{ $isNumeric ? 'od-cell-number' : '' }}">
                                            {{ $value }}
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
