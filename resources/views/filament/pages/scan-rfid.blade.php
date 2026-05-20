<x-filament-panels::page>
    {{-- Page content --}}
    <a
        href="{{ \App\Filament\Resources\Jadwals\JadwalResource::getUrl() }}"
        class="fixed top-6 left-6 z-50
    inline-flex items-center gap-2
    px-5 py-3
    bg-white hover:bg-slate-50
    border border-slate-200
    rounded-2xl
    shadow-lg
    text-slate-700 font-medium
    transition-all duration-200
    hover:scale-105">
        <svg xmlns="http://www.w3.org/2000/svg"
            class="w-5 h-5"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor">

            <path stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M15 19l-7-7 7-7" />
        </svg>

        Back To App
    </a>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-blue-50 flex items-center justify-center px-8">
        <div class="w-full max-w-7xl grid grid-cols-12 gap-8 items-center">

            {{-- LEFT --}}
            <div class="col-span-3">

                <div class="w-full text-center bg-neutral-primary-soft p-6 border border-default rounded-base shadow-xs">
                    <h5 class="mb-3 text-xl tracking-tight font-semibold text-heading">Work fast from anywhere</h5>

                </div>


            </div>

            {{-- CENTER --}}
            <div class="col-span-6">
                <div class="w-full text-center bg-neutral-primary-soft p-6 border border-default rounded-base shadow-xs">
                    <div class="col-span-8 text-center bg-neutral-primary-soft">
                        <div class="flex flex-col items-center justify-center bg-neutral-primary-soft p-6">
                            {{-- ICON --}}
                            <div class="relative mb-10">
                                <div class="absolute inset-0 rounded-full
                        border border-blue-200
                        scale-125 animate-pulse">
                                </div>
                                <div class="w-40 h-40 rounded-full
                        bg-gradient-to-br from-blue-200 to-blue-400
                        flex items-center justify-center
                        shadow-lg relative z-10">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="w-20 h-20 text-white"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.5"
                                            d="M3 10h18M7 15h1m2 0h2m8-9H4a1
                                1 0 00-1 1v10a1 1 0 001 1h16a1 1
                                0 001-1V7a1 1 0 00-1-1z" />
                                    </svg>
                                </div>
                            </div>
                            {{-- TITLE --}}
                            <h1 class="text-2xl font-semibold text-blue-900 mb-4">
                                Tempelkan kartu anda...
                            </h1>
                            <!-- form scan -->
                            <form wire:submit="prosesScan">

                                {{ $this->form }}

                                <button type="submit">

                                </button>

                            </form>
                            {{-- DESCRIPTION --}}
                            <p class="text-gray-500 text-lg leading-relaxed max-w-2xl">
                                Silakan tempelkan kartu pada reader.
                            </p>
                        </div>
                    </div>
                </div>


            </div>

            {{-- RIGHT --}}

            <div class="col-span-3">

                <div class="w-full text-center bg-neutral-primary-soft p-6 border border-default rounded-base shadow-xs">
                    <h5 class="mb-3 text-xl tracking-tight font-semibold text-heading">Work fast from anywhere</h5>

                </div>


            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                const input = document.getElementById('rfid-input');

                if (!input) return;

                input.addEventListener('keydown', function(e) {

                    if (e.key === 'Enter') {

                        e.preventDefault();

                        this.form.requestSubmit();
                    }

                });

            });
        </script>
        <!-- SweetAlert -->
        <script>
            document.addEventListener('livewire:init', () => {

                const focusInput = () => {

                    const input = document.getElementById('rfid-input');

                    if (input) {

                        input.value = '';

                        input.focus();
                    }
                };

                focusInput();

                // config report
                Notiflix.Report.init({
                    width: '350px',
                    borderRadius: '18px',
                    svgSize: '120px',
                });

                Livewire.on('notify', (data) => {

                    if (data.type === 'success') {

                        Notiflix.Report.success(
                            'Berhasil',
                            data.message,
                            ''
                        );

                    } else if (data.type === 'warning') {

                        Notiflix.Report.warning(
                            'Peringatan',
                            data.message,
                            ''
                        );

                    } else {

                        Notiflix.Report.failure(
                            'Gagal',
                            data.message,
                            ''
                        );
                    }

                    setTimeout(() => {

                        const report = document.querySelector('.notiflix-report');

                        if (report) {

                            report.remove();
                        }

                        const overlay = document.querySelector('.notiflix-overlay');

                        if (overlay) {

                            overlay.remove();
                        }

                        focusInput();

                    }, 2000);

                });

            });
        </script>

    </div>
</x-filament-panels::page>