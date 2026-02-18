<div class="space-y-6">
    <!-- Quick Info -->
    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
        <div class="flex items-start gap-3">
            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <h4 class="font-semibold text-blue-900 dark:text-blue-100">Menggunakan Survei via API</h4>
                <p class="text-sm text-blue-700 dark:text-blue-300 mt-1">
                    Survei ini dapat diakses oleh aplikasi eksternal melalui API.
                    Aplikasi Anda dapat membuat tampilan sendiri, sistem ini hanya sebagai backend.
                </p>
            </div>
        </div>
    </div>

    <!-- Survey Info -->
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Survey UUID</label>
            <div class="flex items-center gap-2 mt-1">
                <code
                    class="flex-1 text-sm bg-gray-100 dark:bg-gray-800 px-3 py-2 rounded font-mono">{{ $record->uuid }}</code>
                <button type="button"
                    onclick="navigator.clipboard.writeText('{{ $record->uuid }}'); alert('UUID disalin!');"
                    class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z">
                        </path>
                    </svg>
                </button>
            </div>
        </div>
        <div>
            <label class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Tipe Akses</label>
            <div class="mt-1">
                <span
                    class="inline-flex items-center px-3 py-2 rounded-full text-sm font-medium
                    {{ $record->type === 'api_only' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200' : 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' }}">
                    @if($record->type === 'api_only')
                    🔌 API Only
                    @elseif($record->type === 'public')
                    🌐 Publik (Web + API)
                    @else
                    {{ ucfirst($record->type) }}
                    @endif
                </span>
            </div>
        </div>
    </div>

    <!-- API Endpoints -->
    <div class="space-y-3">
        <h4 class="font-semibold text-gray-900 dark:text-gray-100">📡 API Endpoints</h4>

        <div class="space-y-2">
            <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-3">
                <div class="flex items-center justify-between mb-1">
                    <span class="text-xs font-medium text-green-600 dark:text-green-400">GET</span>
                    <span class="text-xs text-gray-500">Mendapatkan Struktur Survei</span>
                </div>
                <code
                    class="text-xs text-gray-700 dark:text-gray-300 break-all">{{ url('/api/v1/survey-api/' . $record->uuid . '/structure') }}</code>
            </div>

            <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-3">
                <div class="flex items-center justify-between mb-1">
                    <span class="text-xs font-medium text-blue-600 dark:text-blue-400">POST</span>
                    <span class="text-xs text-gray-500">Submit Jawaban</span>
                </div>
                <code
                    class="text-xs text-gray-700 dark:text-gray-300 break-all">{{ url('/api/v1/survey-api/' . $record->uuid . '/submit') }}</code>
            </div>

            <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-3">
                <div class="flex items-center justify-between mb-1">
                    <span class="text-xs font-medium text-green-600 dark:text-green-400">GET</span>
                    <span class="text-xs text-gray-500">Statistik Survei</span>
                </div>
                <code
                    class="text-xs text-gray-700 dark:text-gray-300 break-all">{{ url('/api/v1/survey-api/' . $record->uuid . '/stats') }}</code>
            </div>
        </div>
    </div>

    <!-- Authentication -->
    <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
        <div class="flex items-start gap-3">
            <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400 mt-0.5" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                </path>
            </svg>
            <div class="flex-1">
                <h5 class="font-semibold text-yellow-900 dark:text-yellow-100 mb-2">Autentikasi Diperlukan</h5>
                <p class="text-sm text-yellow-700 dark:text-yellow-300 mb-2">
                    Semua request harus menyertakan <strong>API Key</strong>. Request tanpa API Key akan ditolak.
                </p>
                <div class="mt-2">
                    <p class="text-xs text-yellow-600 dark:text-yellow-400 mb-1">Cara menambahkan API Key:</p>
                    <div class="bg-yellow-100 dark:bg-yellow-900/40 rounded p-2">
                        <code
                            class="text-xs text-yellow-800 dark:text-yellow-200">Header: X-API-Key: your-api-key-here</code>
                    </div>
                </div>
                <p class="text-xs text-yellow-600 dark:text-yellow-400 mt-2">
                    💡 Dapatkan API Key dari menu <strong>API Management → API Keys</strong>
                </p>
            </div>
        </div>
    </div>

    <!-- Code Example -->
    <div class="space-y-3">
        <h4 class="font-semibold text-gray-900 dark:text-gray-100">💻 Contoh Kode Integrasi</h4>

        <div class="relative">
            <div class="absolute top-2 right-2 z-10">
                <button type="button"
                    onclick="navigator.clipboard.writeText(this.parentElement.nextElementSibling.textContent); alert('Code disalin!');"
                    class="text-xs px-2 py-1 bg-gray-700 hover:bg-gray-600 text-white rounded border border-gray-600">
                    Salin
                </button>
            </div>
            <pre class="rounded-lg p-4 overflow-x-auto text-xs"
                style="background-color: #1a202c; color: #e2e8f0; border: 1px solid #2d3748;"><code>// JavaScript / Fetch API
const API_KEY = 'your-api-key-here';
const SURVEY_UUID = '{{ $record->uuid }}';

// 1. Get survey structure
const response = await fetch(
  `{{ url('/api/v1/survey-api') }}/${SURVEY_UUID}/structure`,
  {
    headers: {
      'X-API-Key': API_KEY
    }
  }
);
const survey = await response.json();

// 2. Submit response
const submitResponse = await fetch(
  `{{ url('/api/v1/survey-api') }}/${SURVEY_UUID}/submit`,
  {
    method: 'POST',
    headers: {
      'X-API-Key': API_KEY,
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      answers: [
        { question_id: 1, answer: "John Doe" },
        { question_id: 2, answer: 1 }
      ]
    })
  }
);
const result = await submitResponse.json();
console.log('Response UUID:', result.data.response_uuid);</code></pre>
        </div>
    </div>

    <!-- Documentation Link -->
    <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
        <div class="flex items-center justify-between">
            <div>
                <h5 class="font-medium text-gray-900 dark:text-gray-100">📚 Dokumentasi Lengkap</h5>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Lihat dokumentasi lengkap untuk contoh kode di berbagai bahasa pemrograman
                </p>
            </div>
            <a href="{{ route('docs.api') }}" target="_blank"
                class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition">
                Buka Dokumentasi
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                </svg>
            </a>
        </div>
    </div>
</div>