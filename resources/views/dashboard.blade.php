<x-filament::page>
    <div class="space-y-6">


        <!-- Statistik Utama -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Total Pengguna -->
            <x-filament::card>
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-500">Total Pengguna</h3>
                    <p class="text-3xl font-bold mt-2">1,248</p>
                    <div class="flex items-center text-sm text-success-500 mt-2">
                        <x-heroicon-s-arrow-trending-up class="w-4 h-4 mr-1" />
                        <span>12% dari bulan lalu</span>
                    </div>
                </div>
            </x-filament::card>

            <!-- Total Pesanan -->
            <x-filament::card>
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-500">Total Pesanan</h3>
                    <p class="text-3xl font-bold mt-2">356</p>
                    <div class="flex items-center text-sm text-success-500 mt-2">
                        <x-heroicon-s-arrow-trending-up class="w-4 h-4 mr-1" />
                        <span>8% dari bulan lalu</span>
                    </div>
                </div>
            </x-filament::card>

            <!-- Pendapatan Bulan Ini -->
            <x-filament::card>
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-500">Pendapatan Bulan Ini</h3>
                    <p class="text-3xl font-bold mt-2">Rp 48.750.000</p>
                    <div class="flex items-center text-sm text-danger-500 mt-2">
                        <x-heroicon-s-arrow-trending-down class="w-4 h-4 mr-1" />
                        <span>5% dari bulan lalu</span>
                    </div>
                </div>
            </x-filament::card>
        </div>

        <!-- Dua Kolom Bawah -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Grafik Aktivitas Terbaru -->
            <x-filament::card>
                <div class="p-6">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Aktivitas Terbaru</h2>
                    <div class="space-y-4">
                        @foreach ([['user' => 'Andi', 'action' => 'Membuat pesanan baru #ORD-2024-001', 'time' => '10 menit lalu'], ['user' => 'Budi', 'action' => 'Memperbarui profil pengguna', 'time' => '25 menit lalu'], ['user' => 'Citra', 'action' => 'Mengupload dokumen pembayaran', 'time' => '1 jam lalu'], ['user' => 'Dewi', 'action' => 'Menyelesaikan tugas verifikasi', 'time' => '2 jam lalu']] as $activity)
                            <div class="flex items-start">
                                <div class="bg-primary-100 p-2 rounded-full mr-3">
                                    <x-heroicon-s-user class="w-5 h-5 text-primary-600" />
                                </div>
                                <div>
                                    <p class="font-medium">{{ $activity['user'] }} <span
                                            class="font-normal">{{ $activity['action'] }}</span></p>
                                    <p class="text-sm text-gray-500">{{ $activity['time'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <x-filament::button class="mt-4" size="sm" tag="a" href="">
                        Lihat Semua Aktivitas
                    </x-filament::button>
                </div>
            </x-filament::card>

            <!-- Status Tugas -->
            <x-filament::card>
                <div class="p-6">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Status Tugas</h2>

                    <div class="mb-6">
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Progress Tugas</h3>
                        <div class="flex items-center">
                            <div class="w-full bg-gray-200 rounded-full h-2.5 mr-2">
                                <div class="bg-primary-600 h-2.5 rounded-full" style="width: 33%"></div>
                            </div>
                            <span class="text-sm font-medium">1/3 selesai</span>
                        </div>
                    </div>

                    <div class="space-y-3">
                        @foreach ([['title' => 'Perbaiki Bug Sistem Pembayaran', 'status' => 'Selesai', 'color' => 'success'], ['title' => 'Desain Database Schema', 'status' => 'Dalam Proses', 'color' => 'warning'], ['title' => 'Implementasi Sistem Autentikasi', 'status' => 'Belum Dimulai', 'color' => 'danger']] as $task)
                            <div class="flex items-center justify-between p-3 border rounded-lg">
                                <div>
                                    <p class="font-medium">{{ $task['title'] }}</p>
                                    <p class="text-sm text-gray-500">Terakhir diperbarui:
                                        {{ now()->subDays(rand(1, 5))->format('d/m/Y') }}</p>
                                </div>
                                <x-filament::badge :color="$task['color']">
                                    {{ $task['status'] }}
                                </x-filament::badge>
                            </div>
                        @endforeach
                    </div>
                </div>
            </x-filament::card>
        </div>
    </div>
</x-filament::page>
