<x-filament::page>
    <div class="space-y-6">
        {{-- Header Section --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <h1 class="text-2xl font-bold text-primary-600">TaskManager</h1>
                </div>

            </div>

        </div>

        {{-- Welcome Section --}}
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl font-semibold mb-1 text-gray-800">Welcome back, {{ Auth::user()->name }}! 👋</h2>
                    <p class="text-gray-600">Here's what's happening with your tasks today</p>
                </div>
                <div class="text-sm px-4 py-2 bg-primary-50 text-primary-700 rounded-lg border border-primary-100">
                    Last updated: <span class="font-medium">{{ now()->format('F j, Y') }}</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
            <!-- Total Tugas -->
            <x-filament::card>
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-500">Total Task</h3>
                        <x-heroicon-s-clipboard-document-list class="w-6 h-6 text-primary-500" />
                    </div>
                    <p class="text-3xl font-bold mt-2">{{ \App\Models\Task::where('user_id', Auth::id())->count() }}</p>
                    <div class="flex items-center text-sm text-success-500 mt-2">
                        <x-heroicon-s-arrow-trending-up class="w-4 h-4 mr-1" />
                        <span>
                            {{ \App\Models\Task::where('user_id', Auth::id())->whereDate('created_at', now()->toDateString())->count() }}
                            tugas baru hari ini
                        </span>
                    </div>
                </div>
            </x-filament::card>

            <!-- Tugas Selesai -->
            <x-filament::card>
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-500">Finish Task</h3>
                        <x-heroicon-s-check-circle class="w-6 h-6 text-success-500" />
                    </div>
                    <p class="text-3xl font-bold mt-2">
                        {{ \App\Models\Task::where('task_status_id', \App\Models\TaskStatus::where('name', 'completed')->value('id'))->where('user_id', Auth::id())->count() }}
                    </p>
                    <div class="flex items-center text-sm text-gray-500 mt-2">
                        <span>
                            {{ \App\Models\Task::where('task_status_id', \App\Models\TaskStatus::where('name', 'completed')->value('id'))->count() }}
                            tugas selesai
                        </span>
                    </div>
                </div>
            </x-filament::card>

            <!-- Tugas Berjalan -->
            <x-filament::card>
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-500">Progress</h3>
                        <x-heroicon-s-arrow-path class="w-6 h-6 text-warning-500 animate-spin" />
                    </div>
                    <p class="text-3xl font-bold mt-2">
                        {{ \App\Models\Task::where('task_status_id', \App\Models\TaskStatus::where('name', 'in_progress')->value('id'))->count() }}
                    </p>
                    <div class="flex items-center text-sm text-gray-500 mt-2">
                        <span>
                            {{ \App\Models\Task::count() > 0
                                ? round(
                                    (\App\Models\Task::where(
                                        'task_status_id',
                                        \App\Models\TaskStatus::where('name', 'in_progress')->value('id'),
                                    )->count() /
                                        \App\Models\Task::count()) *
                                        100,
                                )
                                : 0 }}%
                            dari total
                        </span>
                    </div>
                </div>
            </x-filament::card>

            <!-- Tugas Terlambat -->
            <x-filament::card>
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-500">Cencel</h3>
                        <x-heroicon-s-exclamation-triangle class="w-6 h-6 text-danger-500" />
                    </div>
                    <p class="text-3xl font-bold mt-2">
                        {{ \App\Models\Task::where('task_status_id', \App\Models\TaskStatus::where('name', 'cancelled')->value('id'))->count() }}
                    </p>
                    <div class="flex items-center text-sm text-danger-500 mt-2">
                        <x-heroicon-s-arrow-trending-up class="w-4 h-4 mr-1" />
                        <span>
                            {{ \App\Models\Task::where('task_status_id', \App\Models\TaskStatus::where('name', 'cancelled')->value('id'))->count() }}
                            total cancel
                        </span>
                    </div>
                </div>
            </x-filament::card>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Task Completion Rate -->
            <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-800">Task Completion Rate</h3>
                </div>

                <div class="flex items-center justify-between gap-6">
                    <div class="flex-1 space-y-2">
                        <p class="text-sm text-gray-600">Progress</p>
                        @php
                            $totalTasks = \App\Models\Task::where('user_id', Auth::id())->count();
                            $completedTasks = \App\Models\Task::where('user_id', Auth::id())
                                ->where(
                                    'task_status_id',
                                    \App\Models\TaskStatus::where('name', 'completed')->value('id'),
                                )
                                ->count();
                            $completionPercent = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;
                        @endphp
                        <div class="w-full bg-gray-200 rounded-full h-4 mb-2 flex items-center">
                            <div class="bg-primary-500 h-4 rounded-full transition-all duration-300"
                                style="width: {{ $completionPercent }}%"></div>
                        </div>
                        <p class="font-medium">{{ $completedTasks }} of {{ $totalTasks }} tasks completed
                            ({{ $completionPercent }}%)</p>
                    </div>
                    <div class="flex-shrink-0 w-20 h-20 flex items-center justify-center">
                        <svg class="w-full h-full" viewBox="0 0 36 36">
                            <circle cx="18" cy="18" r="16" fill="none" class="stroke-gray-200"
                                stroke-width="3"></circle>
                            <circle cx="18" cy="18" r="16" fill="none" class="stroke-primary-500"
                                stroke-width="3" stroke-dasharray="100"
                                stroke-dashoffset="{{ 100 - $completionPercent }}" stroke-linecap="round"
                                style="transition: stroke-dashoffset 0.3s;"></circle>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Task Progress Chart -->
            <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-800">Task Progress Chart</h3>
                </div>

                @php
                    $statusCounts = \App\Models\TaskStatus::withCount([
                        'tasks' => function ($query) {
                            $query->where('user_id', Auth::id());
                        },
                    ])->get();
                    $labels = $statusCounts->pluck('name');
                    $data = $statusCounts->pluck('tasks_count');
                    $colors = $statusCounts->map(function ($status) {
                        return $status->color
                            ? (str_starts_with($status->color, '#')
                                ? $status->color
                                : '#' . $status->color)
                            : '#6b7280';
                    });
                @endphp

                <div style="height:200px;">
                    <canvas id="taskStatusChart"></canvas>
                </div>

                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const ctx = document.getElementById('taskStatusChart').getContext('2d');
                        new Chart(ctx, {
                            type: 'doughnut',
                            data: {
                                labels: {!! $labels->toJson() !!},
                                datasets: [{
                                    data: {!! $data->toJson() !!},
                                    backgroundColor: {!! $colors->values()->toJson() !!},
                                    borderWidth: 1,
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        position: 'bottom',
                                    },
                                    tooltip: {
                                        enabled: true,
                                    }
                                }
                            }
                        });
                    });
                </script>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Recent Activity -->
            <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100 lg:col-span-2">
                <h3 class="text-lg font-medium text-gray-800 mb-4">Recent Activity</h3>

                <div class="space-y-4">
                    <!-- Activity Item 1 -->
                    @php
                        $recentTasks = \App\Models\Task::where('user_id', Auth::id())
                            ->orderBy('updated_at', 'desc')
                            ->take(5)
                            ->get();
                    @endphp

                    @foreach ($recentTasks as $task)
                        <div class="border-b border-gray-100 pb-4 last:border-0 last:pb-0">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-medium text-gray-800">{{ $task->title }}</h4>
                                    <p class="text-sm text-gray-500 mt-1">Updated
                                        {{ $task->updated_at->format('n/j/Y') }}</p>
                                </div>
                                @php
                                    $severity = $task->severity; // assuming relation 'severity'
                                @endphp
                                @if ($severity)
                                    <span
                                        class="px-2 py-1 bg-{{ $severity->color ?? 'gray' }}-100 text-{{ $severity->color ?? 'gray' }}-800 text-xs rounded-full">
                                        {{ $severity->name }}
                                    </span>
                                @else
                                    <span
                                        class="px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded-full">Unknown</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>


        </div>

    </div>
</x-filament::page>
