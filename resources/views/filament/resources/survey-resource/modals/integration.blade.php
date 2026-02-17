<div class="space-y-4">
    <div class="p-4 bg-gray-50 border border-gray-200 rounded-lg dark:bg-gray-800 dark:border-gray-700">
        <h4 class="text-sm font-semibold text-gray-900 dark:text-gray-100 flex items-center gap-2">
            <x-heroicon-s-link class="w-4 h-4 text-indigo-500" />
            URL Tautan Langsung
        </h4>
        <div class="mt-2 flex items-center gap-2">
            <code
                class="block w-full text-xs font-mono bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded p-2 overflow-x-auto">
                {{ url('/api/v1/surveys/' . $record->uuid) }}
            </code>
            <button onclick="navigator.clipboard.writeText('{{ url('/api/v1/surveys/' . $record->uuid) }}')"
                class="p-2 text-gray-500 hover:text-indigo-600 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
                <x-heroicon-o-clipboard class="w-4 h-4" />
            </button>
        </div>
        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
            Gunakan URL ini untuk mengambil struktur survei (pertanyaan & opsi) dalam format JSON.
        </p>
    </div>

    <div class="p-4 bg-gray-50 border border-gray-200 rounded-lg dark:bg-gray-800 dark:border-gray-700">
        <h4 class="text-sm font-semibold text-gray-900 dark:text-gray-100 flex items-center gap-2">
            <x-heroicon-s-paper-airplane class="w-4 h-4 text-green-500" />
            Endpoint Pengiriman Jawaban (POST)
        </h4>
        <div class="mt-2 flex items-center gap-2">
            <code
                class="block w-full text-xs font-mono bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded p-2 overflow-x-auto">
                {{ url('/api/v1/surveys/' . $record->uuid . '/submit') }}
            </code>
            <button onclick="navigator.clipboard.writeText('{{ url('/api/v1/surveys/' . $record->uuid . '/submit') }}')"
                class="p-2 text-gray-500 hover:text-green-600 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
                <x-heroicon-o-clipboard class="w-4 h-4" />
            </button>
        </div>
        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
            Kirimkan respons pengguna ke endpoint ini menggunakan metode POST.
        </p>
    </div>

    <div class="p-4 bg-gray-50 border border-gray-200 rounded-lg dark:bg-gray-800 dark:border-gray-700">
        <h4 class="text-sm font-semibold text-gray-900 dark:text-gray-100 flex items-center gap-2">
            <x-heroicon-s-code-bracket class="w-4 h-4 text-blue-500" />
            Contoh Format JSON (Body)
        </h4>
        <div class="mt-2 relative">
            <pre
                class="block w-full text-xs font-mono bg-gray-900 text-gray-100 dark:bg-black border border-gray-700 rounded p-3 overflow-x-auto whitespace-pre-wrap">
{
  "respondent_identity": "user_12345", 
  "answers": [
    {
      "question_id": 1, 
      "value": "Sangat Puas"
    },
    {
      "question_id": 2, 
      "value": ["Opsi A", "Opsi B"]
    }
  ]
}</pre>
        </div>
        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
            Pastikan mengirim Header <code>Content-Type: application/json</code>.
        </p>
    </div>
</div>