<x-filament::page>
    <div class="space-y-6">


        <!-- Statistik Utama -->
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
            <!-- Total Tugas -->
            <x-filament::card>
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-500">Total Task</h3>
                        <x-heroicon-s-clipboard-document-list class="w-6 h-6 text-primary-500" />
                    </div>
                    <p class="text-3xl font-bold mt-2">{{ \App\Models\Task::count() }}</p>
                    <div class="flex items-center text-sm text-success-500 mt-2">
                        <x-heroicon-s-arrow-trending-up class="w-4 h-4 mr-1" />
                        <span>
                            {{ \App\Models\Task::whereDate('created_at', now()->toDateString())->count() }} tugas baru
                            hari ini
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
                    <p class="text-3xl font-bold mt-2">{{ \App\Models\Task::where('task_status_id')->count() }}
                    </p>
                    <div class="flex items-center text-sm text-gray-500 mt-2">
                        <span>
                            {{ \App\Models\Task::count() > 0
                                ? round((\App\Models\Task::where('task_status_id', 'complete')->count() / \App\Models\Task::count()) * 100)
                                : 0 }}%
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
                        {{ \App\Models\Task::where('task_status_id', 'in_progress')->count() }}</p>
                    <div class="flex items-center text-sm text-gray-500 mt-2">
                        <span>
                            {{ \App\Models\Task::count() > 0
                                ? round((\App\Models\Task::where('task_status_id', 'in_progress')->count() / \App\Models\Task::count()) * 100)
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
                        {{ \App\Models\Task::where('task_status_id', 'cancelled')->count() }}</p>
                    <div class="flex items-center text-sm text-danger-500 mt-2">
                        <x-heroicon-s-arrow-trending-up class="w-4 h-4 mr-1" />
                        <span>{{ \App\Models\Task::where('task_status_id', 'cancelled')->count() }} total cancel</span>
                    </div>
                </div>
            </x-filament::card>
        </div>

        <!-- Dua Kolom Bawah -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Daftar Tugas Terbaru -->
            <x-filament::card>
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-medium text-gray-900">Task New</h2>
                        <x-filament::button size="sm" tag="a"
                            href="{{ route('filament.admin.resources.tasks.index') }}">
                            Lihat Semua
                        </x-filament::button>
                    </div>
                    <div class="space-y-4">
                        @foreach (\App\Models\Task::latest()->take(4)->get() as $task)
                            <div class="border rounded-lg p-4 hover:bg-gray-50 transition-colors">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-sm text-gray-500">{{ $task->title }}</p>
                                        <p class="font-medium">{{ $task->description }}</p>
                                    </div>

                                    <div class="flex items-center text-sm"
                                        style="color: {{ $task->severity->color ?? '#6B7280' }}">
                                        <x-heroicon-s-flag class="w-4 h-4 mr-1" />
                                        <span>{{ $task->severity->name ?? 'Tidak Diketahui' }}</span>
                                    </div>

                                </div>
                                <div class="flex items-center justify-between mt-3">
                                    <div class="flex items-center text-sm text-gray-500">
                                        <x-heroicon-s-user-circle class="w-4 h-4 mr-1" />
                                        <span>{{ $task->assignee->name }}</span>
                                    </div>

                                    <div
                                        class="flex items-center text-sm {{ $task->severity->color ?? 'text-gray-500' }}">
                                        <x-heroicon-s-clock class="w-4 h-4 mr-1" />
                                        <span>Batas:
                                            {{ \Carbon\Carbon::parse($task->deadline)->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </x-filament::card>


        </div>
    </div>
</x-filament::page>
