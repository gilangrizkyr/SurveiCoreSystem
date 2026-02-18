<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    class="h-full antialiased bg-gray-50 text-gray-900 dark:bg-gray-950 dark:text-white">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Changelog - DPMPTSP Survei</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 flex flex-col min-h-screen font-sans dark:bg-gray-950">
    <div class="container mx-auto max-w-4xl px-6 py-12">
        <header class="mb-10 text-center">
            <h1 class="text-4xl font-bold tracking-tight text-primary-600 dark:text-primary-400">Changelog & Pembaruan
                Sistem</h1>
            <p class="mt-4 text-lg text-gray-600 dark:text-gray-400">Riwayat perubahan dan peningkatan pada Sistem
                Survei DPMPTSP Tanah Bumbu.</p>
        </header>

        <main class="space-y-8">
            <!-- Versi 1.1 -->
            <section
                class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">Versi 1.1.0 - Administrasi &
                        Keamanan</h2>
                    <span
                        class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Terbaru
                        (Feb 2026)</span>
                </div>
                <div class="space-y-4 text-gray-600 dark:text-gray-300">
                    <ul class="space-y-3 list-disc list-inside marker:text-primary-500">
                        <li>
                            <strong class="text-gray-800 dark:text-gray-200">Sistem Administrator Terstruktur:</strong>
                            Pemisahan peran antara Super Admin (Full Access) dan Operator Survei (Only Survey Access).
                        </li>
                        <li>
                            <strong class="text-gray-800 dark:text-gray-200">Pencegahan Duplikasi Lanjutan:</strong>
                            Penambahan opsi pembatasan respons berdasarkan Cookie Browser yang lebih ketat.
                        </li>
                        <li>
                            <strong class="text-gray-800 dark:text-gray-200">Ekspor Data CSV:</strong>
                            Fitur ekspor data survei ke format CSV yang lebih cepat dan kompatibel dengan Excel.
                        </li>
                        <li>
                            <strong class="text-gray-800 dark:text-gray-200">Perbaikan Tampilan Admin:</strong>
                            Menu-menu admin kini dikelompokkan dan diterjemahkan ke Bahasa Indonesia yang mudah
                            dipahami.
                        </li>
                    </ul>
                </div>
            </section>

            <!-- Versi 1.0 -->
            <section
                class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-8 opacity-75 hover:opacity-100 transition-opacity">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">Versi 1.0.0 - Rilis Awal</h2>
                    <span
                        class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">Jan
                        2026</span>
                </div>
                <div class="space-y-4 text-gray-600 dark:text-gray-300">
                    <ul class="space-y-3 list-disc list-inside marker:text-gray-400">
                        <li>Peluncuran Survei Builder (Drag & Drop).</li>
                        <li>Integrasi AI untuk Analisis Sentimen otomatis.</li>
                        <li>API Terbuka untuk integrasi dengan aplikasi pihak ketiga (SiPinter, dll).</li>
                        <li>Dashboard Statistik Real-time.</li>
                    </ul>
                </div>
            </section>
        </main>

        <footer class="mt-12 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} DPMPTSP Kabupaten Tanah Bumbu. All rights reserved.
        </footer>
    </div>
</body>

</html>