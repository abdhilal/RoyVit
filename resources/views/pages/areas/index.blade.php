@extends('layouts.app')
@section('title')
    {{ __('Areas list') }}
@endsection
@section('subTitle')
    {{ __('Areas list') }}
@endsection
@section('breadcrumb')
    {{ __('Areas') }}
@endsection
@section('breadcrumbActive')
    {{ __('Areas') }}
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5>{{ __('Areas list') }}</h5>
                        {{-- <x-create :action="route('areas.create')" /> --}}
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header card-no-border pb-0">
                                    <h4>{{ __('Areas Summary') }}</h4>
                                </div>
                                <div class="card-body apex-chart" style="overflow-x: auto; overflow-y: hidden; width: 90%;">
                                    <div id="areas-summary-bar" style="min-width: 800px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Warehouse') }}</th>
                                    <th>{{ __('Total Income') }}</th>
                                    <th>{{ __('Total Output') }}</th>
                                    <th>{{ __('actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($areas as $index => $area)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td> <a href="{{ route('areas.show', $area) }}" class="text-decoration-none">
                                                {{ $area->name }}
                                            </a></td>
                                        <td>{{ $area->warehouse?->name }}</td>
                                        <td>{{ $area->transactions_sum_value_income }}</td>
                                        <td>{{ $area->transactions_sum_value_output }}</td>
                                        <td>
                                            <x-show :action="route('areas.show', $area)" />
                                            {{-- <x-edit :action="route('areas.edit', $area)" /> --}}
                                            {{-- <x-delete-form :action="route('areas.destroy', $area)" /> --}}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">{{ __('No areas found') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($areas->count())
                    <div class="card-footer">
                        @include('layouts.partials.pagination', ['page' => $areas])
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function formatNumber(val) {
                return Number(val).toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            }

            function getThemeTextColor() {
                var cs = getComputedStyle(document.body);
                var v = cs.getPropertyValue('--body-font-color');
                return v && v.trim() ? v.trim() : '#222';
            }
            var labelColor = getThemeTextColor();

            var raw = @json($summary ?? []);
            var items = Object.values(raw).sort(function(a, b) {
                return (a.total || 0) - (b.total || 0);
            });
            var categories = items.map(function(d) {
                return d.name;
            });
            var seriesData = items.map(function(d) {
                return parseFloat(d.total || 0);
            });
            var chartWidth = Math.max((categories.length || 1) * 80, 800);
            var el = document.getElementById('areas-summary-bar');
            if (el) el.style.minWidth = chartWidth + 'px';

            var options = {
                series: [{
                    name: "{{ __('Total') }}",
                    data: seriesData
                }],
                chart: {
                    type: 'bar',
                    height: 320,
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '40%',
                        endingShape: 'rounded',
                        dataLabels: {
                            position: 'top'
                        }
                    }
                },
                dataLabels: {
                    enabled: true,
                    formatter: formatNumber,
                    offsetY: -25,
                    style: {
                        fontSize: '10px',
                        colors: [labelColor]
                    }
                },
                stroke: {
                    show: true,
                    width: 1,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: categories,
                    tickPlacement: 'on'
                },
                yaxis: {
                    labels: {
                        formatter: formatNumber
                    },
                    opposite: true
                },
                grid: {
                    padding: {
                        left: 0,
                        right: 0
                    }
                },
                fill: {
                    opacity: 1
                },
                colors: ['#7366ff'],
                legend: {
                    position: 'bottom'
                },
                tooltip: {
                    y: {
                        formatter: formatNumber
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector('#areas-summary-bar'), options);
            chart.render();

            var observer = new MutationObserver(function() {
                labelColor = getThemeTextColor();
                chart.updateOptions({
                    dataLabels: {
                        style: {
                            colors: [labelColor]
                        }
                    }
                });
            });
            observer.observe(document.body, {
                attributes: true,
                attributeFilter: ['class']
            });
        });
    </script>
@endpush
