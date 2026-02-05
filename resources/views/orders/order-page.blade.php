@extends('layouts.app')

@section('title', 'Yangi buyurtma berish - Tarjimonlar Platformasi')

@section('content')
    <!-- Enhanced Hero Section -->
    <div class="bg-gradient-to-br from-primary/5 to-purple-600/5 border-b border-gray-100 dark:border-gray-800 mb-8 -mx-6 lg:-mx-8 px-6 lg:px-8 py-12">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-8">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-primary/10 text-primary rounded-full text-sm font-semibold mb-6">
                    <span class="material-symbols-outlined text-lg">rocket_launch</span>
                    Yangi buyurtma yaratish
                </div>
                <h1 class="text-4xl md:text-5xl font-black leading-tight tracking-tight text-[#121117] dark:text-white mb-4">
                    Professional <span class="text-primary">Tarjima</span> Xizmati
                </h1>
                <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    Sifatli tarjima uchun professional tarjimonlarimizdan biri bilan ishlang. Sizning loyihangiz ehtiyojlariga mos tarjimonni tanlang.
                </p>
            </div>

            <!-- Progress Steps -->
            <div class="flex items-center justify-center mb-8">
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-primary text-white rounded-full flex items-center justify-center text-sm font-bold">1</div>
                        <span class="text-sm font-medium text-primary">Ma'lumotlar</span>
                    </div>
                    <div class="w-12 h-0.5 bg-gray-300 dark:bg-gray-600"></div>
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 rounded-full flex items-center justify-center text-sm font-bold">2</div>
                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Tasdiqlash</span>
                    </div>
                    <div class="w-12 h-0.5 bg-gray-300 dark:bg-gray-600"></div>
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 rounded-full flex items-center justify-center text-sm font-bold">3</div>
                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Tugallandi</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Form Container -->
    <div class="max-w-4xl mx-auto px-6 lg:px-8 pb-12">
        <!-- Enhanced Form Card -->
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="p-8">
                <!-- Form Header -->
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Asar ma'lumotlari</h2>
                        <p class="text-gray-600 dark:text-gray-400">Tarjima qilinishi kerak bo'lgan asar haqida to'liq ma'lumot bering</p>
                    </div>
                    <a href="{{ route('orders') }}"
                       class="inline-flex items-center gap-2 px-4 py-2 text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 transition-colors">
                        <span class="material-symbols-outlined">arrow_back</span>
                        Orqaga
                    </a>
                </div>

                {{-- Display validation errors --}}
                @if ($errors->any())
                    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-6 mb-8">
                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 bg-red-100 dark:bg-red-900/50 rounded-full flex items-center justify-center shrink-0 mt-0.5">
                                <span class="material-symbols-outlined text-red-600 dark:text-red-400 text-sm">error</span>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-red-800 dark:text-red-300 mb-3">Ma'lumotlarni tekshiring</h3>
                                <div class="space-y-2">
                                    @foreach ($errors->all() as $error)
                                        <div class="flex items-start gap-2">
                                            <span class="material-symbols-outlined text-red-500 text-sm mt-0.5">arrow_right</span>
                                            <span class="text-red-700 dark:text-red-300">{{ $error }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Enhanced Form -->
                <form action="{{ route('orders.store') }}" method="POST" class="space-y-8">
                    @csrf

                    <!-- Project Information Section -->
                    <div class="space-y-6">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center">
                                <span class="material-symbols-outlined text-primary">description</span>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Asar ma'lumotlari</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Tarjima qilinadigan asar haqida ma'lumot</p>
                            </div>
                        </div>

                        <!-- Project Title -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                <span class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-lg">title</span>
                                    Asar nomi
                                    <span class="text-red-500">*</span>
                                </span>
                            </label>
                            <input name="title"
                                   value="{{ old('title') }}"
                                   class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 transition-all duration-200"
                                   type="text"
                                   placeholder="Masalan: 'Sherlock Holmes hikoyalari'"
                                   required>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Asar yoki matnning to'liq nomini kiriting</p>
                        </div>

                        <!-- Author Name -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                <span class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-lg">person_outline</span>
                                    Muallif nomi
                                    <span class="text-red-500">*</span>
                                </span>
                            </label>
                            <input name="author_name"
                                   value="{{ old('author_name') }}"
                                   class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 transition-all duration-200"
                                   type="text"
                                   placeholder="Masalan: Arthur Conan Doyle"
                                   required>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Asar muallifining to'liq ismini kiriting</p>
                        </div>

                        <!-- Project Description -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                <span class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-lg">notes</span>
                                    Asar tavsifi
                                    <span class="text-red-500">*</span>
                                </span>
                            </label>
                            <textarea name="description"
                                      class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 min-h-[120px] resize-none transition-all duration-200"
                                      placeholder="Loyiha haqida batafsil ma'lumot: janr, hajmi, o'ziga xos talablar va boshqa muhim tafsilotlar..."
                                      required>{{ old('description') }}</textarea>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Tarjimonning ishini yaxshiroq bajarishi uchun batafsil ma'lumot bering</p>
                        </div>
                    </div>

                    <!-- Selection Section -->
                    <div class="space-y-6 pt-8 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 bg-blue-500/10 rounded-lg flex items-center justify-center">
                                <span class="material-symbols-outlined text-blue-500">settings</span>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Xizmat parametrlari</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Tarjimon va til tanlovlari</p>
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <!-- Translator Selection -->
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    <span class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-lg">person</span>
                                        Tarjimon tanlang
                                        <span class="text-red-500">*</span>
                                    </span>
                                </label>
                                <div class="relative">
                                    <select name="translator_id"
                                            class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white appearance-none transition-all duration-200"
                                            required>
                                        <option disabled {{ old('translator_id') ? '' : 'selected' }} value="">Professional tarjimonni tanlang</option>
                                        @foreach($translators as $translator)
                                            <option value="{{ $translator->id }}" {{ old('translator_id') == $translator->id ? 'selected' : '' }}>
                                                {{ $translator->user->name ?? 'Unknown' }} -
                                                @if($translator->average_rating)
                                                    ⭐ {{ number_format($translator->average_rating, 1) }}
                                                @else
                                                    Yangi tarjimon
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="material-symbols-outlined text-gray-400">expand_more</span>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Reytingi yuqori bo'lgan tarjimonni tanlashni tavsiya qilamiz</p>
                            </div>

                            <!-- Language Selection -->
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    <span class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-lg">language</span>
                                        Tarjima tili
                                        <span class="text-red-500">*</span>
                                    </span>
                                </label>
                                <div class="relative">
                                    <select name="language_id"
                                            class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white appearance-none transition-all duration-200"
                                            required>
                                        <option disabled {{ old('language_id') ? '' : 'selected' }} value="">Qaysi tilga tarjima qilish kerak</option>
                                        @foreach($languages as $language)
                                            <option value="{{ $language->id }}" {{ old('language_id') == $language->id ? 'selected' : '' }}>
                                                {{ $language->lang_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="material-symbols-outlined text-gray-400">expand_more</span>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Tarjima qilinadigan til</p>
                            </div>
                        </div>
                    </div>

                    <!-- Timeline Section -->
                    <div class="space-y-6 pt-8 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 bg-orange-500/10 rounded-lg flex items-center justify-center">
                                <span class="material-symbols-outlined text-orange-500">schedule</span>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Vaqt rejasi</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Loyiha tugash muddati</p>
                            </div>
                        </div>

                        <!-- Deadline -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                <span class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-lg">event</span>
                                    Tugash muddati
                                    <span class="text-red-500">*</span>
                                </span>
                            </label>
                            <input name="deadline"
                                   value="{{ old('deadline') }}"
                                   class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white transition-all duration-200"
                                   type="datetime-local"
                                   min="{{ now()->format('Y-m-d\TH:i') }}"
                                   required/>
                            <div class="flex items-start gap-2 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-3">
                                <span class="material-symbols-outlined text-blue-500 text-sm mt-0.5">info</span>
                                <div class="text-sm text-blue-700 dark:text-blue-300">
                                    <p class="font-medium mb-1">Muhim eslatma:</p>
                                    <p>Sifatli tarjima uchun tarjimonlarga yetarli vaqt ajratish muhim. Murakkab matnlar uchun ko'proq vaqt berish tavsiya etiladi.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-8 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                            <span class="material-symbols-outlined text-lg">security</span>
                            <span>Barcha ma'lumotlar xavfsiz saqlanadi</span>
                        </div>

                        <div class="flex items-center gap-4">
                            <a href="{{ route('orders') }}"
                               class="px-6 py-3 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors font-medium">
                                Bekor qilish
                            </a>
                            <button type="submit"
                                    class="inline-flex items-center gap-2 px-8 py-3 bg-primary hover:bg-primary/90 text-white rounded-xl font-semibold transition-all duration-200 hover:shadow-lg hover:shadow-primary/25 focus:outline-none focus:ring-2 focus:ring-primary/50">
                                <span>Buyurtma berish</span>
                                <span class="material-symbols-outlined text-lg">send</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Additional Information -->
        <div class="mt-8 grid md:grid-cols-3 gap-6">
            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700 p-6 text-center">
                <div class="w-12 h-12 bg-green-500/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="material-symbols-outlined text-green-500 text-2xl">verified</span>
                </div>
                <h4 class="font-bold text-gray-900 dark:text-white mb-2">Sifat kafolati</h4>
                <p class="text-sm text-gray-600 dark:text-gray-400">Professional tarjimonlar tomonidan sifatli xizmat</p>
            </div>

            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700 p-6 text-center">
                <div class="w-12 h-12 bg-blue-500/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="material-symbols-outlined text-blue-500 text-2xl">support_agent</span>
                </div>
                <h4 class="font-bold text-gray-900 dark:text-white mb-2">24/7 Yordam</h4>
                <p class="text-sm text-gray-600 dark:text-gray-400">Istalgan vaqtda professional yordam olish</p>
            </div>

            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700 p-6 text-center">
                <div class="w-12 h-12 bg-purple-500/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="material-symbols-outlined text-purple-500 text-2xl">speed</span>
                </div>
                <h4 class="font-bold text-gray-900 dark:text-white mb-2">Tez yetkazib berish</h4>
                <p class="text-sm text-gray-600 dark:text-gray-400">Belgilangan muddatda tarjima tayyor bo'ladi</p>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        /* Simplified hover effects for better UX */
        input:focus, select:focus, textarea:focus {
            transition: all 0.2s ease;
        }

        input:hover, select:hover, textarea:hover {
            border-color: rgba(99, 102, 241, 0.3);
        }

        .form-section {
            animation: fadeInUp 0.6s ease forwards;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
    @endpush

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Form validation and UX improvements
        const form = document.querySelector('form');
        const submitBtn = document.querySelector('button[type="submit"]');

        // Enhanced form submission
        form.addEventListener('submit', function(e) {
            // Add loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="material-symbols-outlined animate-spin">hourglass_empty</span> Jo\'natilmoqda...';

            // Re-enable after timeout (in case of errors)
            setTimeout(() => {
                if (submitBtn.disabled) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<span>Buyurtma berish</span><span class="material-symbols-outlined text-lg">send</span>';
                }
            }, 10000);
        });

        // Form field enhancements - simplified
        const formFields = document.querySelectorAll('input, select, textarea');
        formFields.forEach(field => {
            field.addEventListener('focus', function() {
                // Simple focus styling handled by CSS
            });

            field.addEventListener('blur', function() {
                // Simple blur styling handled by CSS
            });
        });

        // Deadline validation
        const deadlineInput = document.querySelector('input[name="deadline"]');
        if (deadlineInput) {
            deadlineInput.addEventListener('change', function() {
                const selectedDate = new Date(this.value);
                const now = new Date();
                const diffDays = Math.ceil((selectedDate - now) / (1000 * 60 * 60 * 24));

                const infoBox = this.parentElement.querySelector('.bg-blue-50');
                if (diffDays < 3) {
                    infoBox.className = infoBox.className.replace('bg-blue-50', 'bg-orange-50').replace('border-blue-200', 'border-orange-200');
                    infoBox.querySelector('.text-blue-500').className = 'material-symbols-outlined text-orange-500 text-sm mt-0.5';
                    infoBox.querySelector('.text-blue-700').className = 'text-sm text-orange-700 dark:text-orange-300';
                    infoBox.querySelector('p:last-child').textContent = 'Diqqat: Qisqa muddat sifatga ta\'sir qilishi mumkin. Imkon bo\'lsa, ko\'proq vaqt ajrating.';
                }
            });
        }
    });
    </script>
    @endpush
@endsection

