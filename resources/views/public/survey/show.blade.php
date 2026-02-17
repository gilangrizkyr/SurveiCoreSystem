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
            @else
            <form action="{{ route('public.survey.store', $survey->uuid) }}" method="POST">
                @csrf

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
                                @elseif($question->type === 'text')
                                <textarea name="answers[{{ $question->id }}]" rows="3"
                                    class="w-full rounded-2xl border-2 border-slate-100 p-4 focus:border-indigo-500 focus:ring-indigo-500 transition-all"
                                    placeholder="Ketik jawaban Anda di sini..." {{
                                    $question->is_required ? 'required' : '' }}></textarea>
                                @elseif($question->type === 'rating')
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