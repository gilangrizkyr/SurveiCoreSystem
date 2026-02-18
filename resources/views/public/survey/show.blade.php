<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $survey->title }} - Survei Layanan Publik</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }

        .glass {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
        }

        .gradient-bg {
            background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
        }
    </style>
</head>

<body class="bg-slate-50 min-h-screen">
    <div class="gradient-bg h-64 w-full absolute top-0 z-0"></div>

    <main class="relative z-10 pt-12 pb-24 px-4">
        <div class="max-w-3xl mx-auto">
            <!-- Header Card -->
            <div class="glass rounded-3xl shadow-xl overflow-hidden mb-8 border border-white/20">
                <div class="p-8 md:p-12 text-center">
                    @if($survey->tenant)
                    <span
                        class="inline-block px-4 py-1 rounded-full bg-indigo-100 text-indigo-700 text-sm font-medium mb-4">
                        {{ $survey->tenant->name }}
                    </span>
                    @endif
                    <h1 class="text-3xl md:text-4xl font-bold text-slate-900 mb-4">{{ $survey->title }}</h1>
                    <p class="text-slate-600 text-lg leading-relaxed">
                        {{ $survey->description ?? 'Bantu kami meningkatkan kualitas layanan dengan mengisi survei
                        singkat ini.' }}
                    </p>
                </div>
            </div>

            @if(session('success'))
            <div
                class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-8 py-6 rounded-2xl mb-8 flex items-center shadow-sm">
                <svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
            @elseif(session('error'))
            <div
                class="bg-red-50 border border-red-200 text-red-700 px-8 py-6 rounded-2xl mb-8 flex items-center shadow-sm">
                <svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
            @elseif(isset($alreadySubmitted) && $alreadySubmitted)
            <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 px-8 py-6 rounded-2xl mb-8">
                <div class="flex items-start">
                    <svg class="w-6 h-6 mr-4 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                        </path>
                    </svg>
                    <div>
                        <h4 class="font-bold mb-1">Anda Sudah Mengisi Survei Ini</h4>
                        <p class="text-sm">Terima kasih, jawaban Anda sudah kami terima sebelumnya. Survei ini hanya
                            dapat diisi satu kali.</p>
                    </div>
                </div>
            </div>
            @else
            <form action="{{ route('public.survey.store', $survey->uuid) }}" method="POST">
                @csrf

                @if($survey->require_respondent_identity)
                <!-- Respondent Identity Section -->
                <div class="bg-white rounded-3xl shadow-md border border-slate-100 mb-8 overflow-hidden">
                    <div class="bg-indigo-50 px-8 py-5 border-b border-indigo-100">
                        <h2 class="text-xl font-semibold text-indigo-900">📋 Data Responden</h2>
                        <p class="text-indigo-600 text-sm mt-1">Mohon isi data Anda terlebih dahulu</p>
                    </div>
                    <div class="p-8 space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-slate-900 mb-2">
                                Nama Lengkap <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="respondent_name" required
                                class="w-full rounded-2xl border-2 border-slate-100 p-4 focus:border-indigo-500 focus:ring-indigo-500 transition-all"
                                placeholder="Masukkan nama lengkap Anda" value="{{ old('respondent_name') }}">
                            @error('respondent_name')
                            <p class="text-rose-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-900 mb-2">
                                Email <span class="text-rose-500">*</span>
                            </label>
                            <input type="email" name="respondent_email" required
                                class="w-full rounded-2xl border-2 border-slate-100 p-4 focus:border-indigo-500 focus:ring-indigo-500 transition-all"
                                placeholder="email@example.com" value="{{ old('respondent_email') }}">
                            @error('respondent_email')
                            <p class="text-rose-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-900 mb-2">
                                    Nomor HP
                                </label>
                                <input type="tel" name="respondent_phone"
                                    class="w-full rounded-2xl border-2 border-slate-100 p-4 focus:border-indigo-500 focus:ring-indigo-500 transition-all"
                                    placeholder="08XX-XXXX-XXXX" value="{{ old('respondent_phone') }}">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-900 mb-2">
                                    NIK (Opsional)
                                </label>
                                <input type="text" name="respondent_nik"
                                    class="w-full rounded-2xl border-2 border-slate-100 p-4 focus:border-indigo-500 focus:ring-indigo-500 transition-all"
                                    placeholder="XXXXXXXXXXXXXXXX" value="{{ old('respondent_nik') }}">
                            </div>
                        </div>

                        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-blue-600 mr-3 mt-0.5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                                <p class="text-sm text-blue-800">
                                    Data Anda akan kami jaga kerahasiaannya dan hanya digunakan untuk keperluan analisis
                                    survei.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @foreach($survey->sections as $section)
                <div
                    class="bg-white rounded-3xl shadow-md border border-slate-100 mb-8 overflow-hidden transition-all hover:shadow-lg">
                    <div class="bg-slate-50 px-8 py-5 border-b border-slate-100">
                        <h2 class="text-xl font-semibold text-slate-800">{{ $section->title }}</h2>
                        @if($section->description)
                        <p class="text-slate-500 text-sm mt-1">{{ $section->description }}</p>
                        @endif
                    </div>
                    <div class="p-8 space-y-8">
                        @foreach($section->questions as $question)
                        <div class="space-y-4">
                            <label class="block text-lg font-medium text-slate-900">
                                {{ $question->title }}
                                @if($question->is_required) <span class="text-rose-500">*</span> @endif
                            </label>

                            @if($question->description)
                            <p class="text-slate-500 text-sm italic">{{ $question->description }}</p>
                            @endif

                            <div class="space-y-3">
                                @if($question->type === 'multiple_choice')
                                @foreach($question->options as $option)
                                <label
                                    class="flex items-center p-4 rounded-2xl border-2 border-slate-100 cursor-pointer transition-all hover:bg-indigo-50 hover:border-indigo-200 group">
                                    <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option->id }}"
                                        class="w-5 h-5 text-indigo-600 border-slate-300 focus:ring-indigo-500" {{
                                        $question->is_required ? 'required' : '' }}>
                                    <span class="ml-4 text-slate-700 group-hover:text-indigo-900 transition-colors">{{
                                        $option->label }}</span>
                                </label>
                                @endforeach

                                @elseif($question->type === 'checkboxes')
                                @foreach($question->options as $option)
                                <label
                                    class="flex items-center p-4 rounded-2xl border-2 border-slate-100 cursor-pointer transition-all hover:bg-indigo-50 hover:border-indigo-200 group">
                                    <input type="checkbox" name="answers[{{ $question->id }}][]"
                                        value="{{ $option->id }}"
                                        class="w-5 h-5 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500">
                                    <span class="ml-4 text-slate-700 group-hover:text-indigo-900 transition-colors">{{
                                        $option->label }}</span>
                                </label>
                                @endforeach

                                @elseif($question->type === 'dropdown')
                                <select name="answers[{{ $question->id }}]"
                                    class="w-full rounded-2xl border-2 border-slate-100 p-4 focus:border-indigo-500 focus:ring-indigo-500 transition-all"
                                    {{ $question->is_required ? 'required' : '' }}>
                                    <option value="">Pilih salah satu...</option>
                                    @foreach($question->options as $option)
                                    <option value="{{ $option->id }}">{{ $option->label }}</option>
                                    @endforeach
                                </select>

                                @elseif($question->type === 'short_text')
                                <input type="text" name="answers[{{ $question->id }}]"
                                    class="w-full rounded-2xl border-2 border-slate-100 p-4 focus:border-indigo-500 focus:ring-indigo-500 transition-all"
                                    placeholder="{{ $question->placeholder ?? 'Ketik jawaban Anda...' }}" {{
                                    $question->is_required ? 'required' : '' }}>

                                @elseif($question->type === 'long_text')
                                <textarea name="answers[{{ $question->id }}]" rows="4"
                                    class="w-full rounded-2xl border-2 border-slate-100 p-4 focus:border-indigo-500 focus:ring-indigo-500 transition-all"
                                    placeholder="{{ $question->placeholder ?? 'Ketik jawaban Anda di sini...' }}" {{
                                    $question->is_required ? 'required' : '' }}></textarea>

                                @elseif($question->type === 'email')
                                <input type="email" name="answers[{{ $question->id }}]"
                                    class="w-full rounded-2xl border-2 border-slate-100 p-4 focus:border-indigo-500 focus:ring-indigo-500 transition-all"
                                    placeholder="email@example.com" {{ $question->is_required ? 'required' : '' }}>

                                @elseif($question->type === 'phone')
                                <input type="tel" name="answers[{{ $question->id }}]"
                                    class="w-full rounded-2xl border-2 border-slate-100 p-4 focus:border-indigo-500 focus:ring-indigo-500 transition-all"
                                    placeholder="08XXXXXXXXXX" {{ $question->is_required ? 'required' : '' }}>

                                @elseif($question->type === 'url')
                                <input type="url" name="answers[{{ $question->id }}]"
                                    class="w-full rounded-2xl border-2 border-slate-100 p-4 focus:border-indigo-500 focus:ring-indigo-500 transition-all"
                                    placeholder="https://example.com" {{ $question->is_required ? 'required' : '' }}>

                                @elseif($question->type === 'number')
                                <input type="number" name="answers[{{ $question->id }}]"
                                    class="w-full rounded-2xl border-2 border-slate-100 p-4 focus:border-indigo-500 focus:ring-indigo-500 transition-all"
                                    placeholder="0" {{ $question->is_required ? 'required' : '' }}>

                                @elseif($question->type === 'date')
                                <input type="date" name="answers[{{ $question->id }}]"
                                    class="w-full rounded-2xl border-2 border-slate-100 p-4 focus:border-indigo-500 focus:ring-indigo-500 transition-all"
                                    {{ $question->is_required ? 'required' : '' }}>

                                @elseif($question->type === 'time')
                                <input type="time" name="answers[{{ $question->id }}]"
                                    class="w-full rounded-2xl border-2 border-slate-100 p-4 focus:border-indigo-500 focus:ring-indigo-500 transition-all"
                                    {{ $question->is_required ? 'required' : '' }}>

                                @elseif($question->type === 'datetime')
                                <input type="datetime-local" name="answers[{{ $question->id }}]"
                                    class="w-full rounded-2xl border-2 border-slate-100 p-4 focus:border-indigo-500 focus:ring-indigo-500 transition-all"
                                    {{ $question->is_required ? 'required' : '' }}>

                                @elseif($question->type === 'nps')
                                <div class="grid grid-cols-11 gap-2">
                                    @foreach(range(0, 10) as $score)
                                    <label class="text-center cursor-pointer group">
                                        <input type="radio" name="answers[{{ $question->id }}]" value="{{ $score }}"
                                            class="sr-only peer" {{ $question->is_required ? 'required' : '' }}>
                                        <div
                                            class="py-3 rounded-xl border-2 border-slate-100 transition-all peer-checked:bg-indigo-600 peer-checked:border-indigo-600 peer-checked:text-white group-hover:border-indigo-300">
                                            <span class="font-bold">{{ $score }}</span>
                                        </div>
                                    </label>
                                    @endforeach
                                </div>
                                <div class="flex justify-between text-xs text-slate-500 mt-2">
                                    <span>Sangat Tidak Puas</span>
                                    <span>Sangat Puas</span>
                                </div>

                                @elseif($question->type === 'star_rating')
                                <div class="flex space-x-2">
                                    @foreach(range(1, 5) as $star)
                                    <label class="cursor-pointer group">
                                        <input type="radio" name="answers[{{ $question->id }}]" value="{{ $star }}"
                                            class="sr-only peer" {{ $question->is_required ? 'required' : '' }}>
                                        <svg class="w-12 h-12 text-slate-200 peer-checked:text-yellow-400 group-hover:text-yellow-300 transition-colors"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    </label>
                                    @endforeach
                                </div>

                                @elseif($question->type === 'rating' || $question->type === 'linear_scale')
                                <div class="flex space-x-4">
                                    @foreach(range(1, 5) as $rating)
                                    <label class="flex-1 text-center cursor-pointer group">
                                        <input type="radio" name="answers[{{ $question->id }}]" value="{{ $rating }}"
                                            class="sr-only peer" {{ $question->is_required ? 'required' : '' }}>
                                        <div
                                            class="py-4 rounded-2xl border-2 border-slate-100 transition-all peer-checked:bg-indigo-600 peer-checked:border-indigo-600 peer-checked:text-white group-hover:border-indigo-300">
                                            <span class="text-xl font-bold">{{ $rating }}</span>
                                        </div>
                                    </label>
                                    @endforeach
                                </div>

                                @elseif($question->type === 'file_upload')
                                <input type="file" name="answers[{{ $question->id }}]"
                                    class="w-full rounded-2xl border-2 border-slate-100 p-4 focus:border-indigo-500 focus:ring-indigo-500 transition-all file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                                    {{ $question->is_required ? 'required' : '' }}>

                                @else
                                <p class="text-slate-400 italic">Tipe pertanyaan tidak didukung: {{ $question->type }}
                                </p>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach

                <div class="flex justify-center mt-12">
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-12 py-4 rounded-full font-bold text-lg shadow-lg hover:shadow-indigo-500/30 transition-all transform hover:-translate-y-1">
                        Kirim Jawaban
                    </button>
                </div>
            </form>
            @endif
        </div>
    </main>

    <footer class="text-center py-12 text-slate-400 text-sm">
        &copy; {{ date('Y') }} DPMPTSP Survey System. Dikembangkan dengan &hearts; untuk transparansi.
    </footer>
</body>

</html>