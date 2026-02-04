@props([
    'filename' => 'book.pdf',
    'currentPage' => 1,
    'totalPages' => 1,
    'pages' => [],
    'isPurchased' => false,
    'previewPages' => 2,
    'pdfPath' => '/book.pdf'
])

<section class="w-full flex flex-col items-center bg-[#525659] rounded-xl overflow-hidden shadow-inner h-[800px] relative group/viewer">
    {{-- PDF Toolbar --}}
    <div class="w-full bg-[#323639] text-white p-3 flex items-center justify-between shadow-md z-10 sticky top-0">
        <div class="flex items-center gap-4">
            <button class="text-gray-300 hover:text-white" id="menu-btn">
                <span class="material-symbols-outlined">menu</span>
            </button>
{{--            <span class="font-medium text-sm">{{ $filename }}</span>--}}
        </div>

        {{-- Zoom Controls --}}
        <div class="flex items-center bg-[#1a1d20] rounded px-2 py-1 gap-2">
            <button class="text-gray-300 hover:text-white text-xs flex items-center justify-center w-6 h-6" id="zoom-out">
                <span class="material-symbols-outlined text-base">remove</span>
            </button>
            <span class="text-sm font-mono w-12 text-center" id="zoom-level">100%</span>
            <button class="text-gray-300 hover:text-white text-xs flex items-center justify-center w-6 h-6" id="zoom-in">
                <span class="material-symbols-outlined text-base">add</span>
            </button>
        </div>

        {{-- Page Controls --}}
        <div class="flex items-center gap-3">
            <div class="bg-[#1a1d20] rounded px-3 py-1 text-sm font-mono">
                <span class="text-white" id="current-page">{{ $currentPage }}</span>
                <span class="text-gray-500">/</span>
                <span class="text-gray-400" id="total-pages">{{ $totalPages }}</span>
            </div>
            @if($isPurchased)
                <button class="text-gray-300 hover:text-white" onclick="printPDF()">
                    <span class="material-symbols-outlined">print</span>
                </button>
                <button class="text-gray-300 hover:text-white" onclick="downloadPDF()">
                    <span class="material-symbols-outlined">download</span>
                </button>
            @else
                <button class="text-gray-400 cursor-not-allowed" disabled title="Purchase to enable">
                    <span class="material-symbols-outlined">print</span>
                </button>
                <button class="text-gray-400 cursor-not-allowed" disabled title="Purchase to enable">
                    <span class="material-symbols-outlined">download</span>
                </button>
            @endif
        </div>
    </div>

    {{-- PDF Content Area --}}
    <div class="w-full flex-1 relative bg-[#525659]" id="pdf-container">
        @if(($isPurchased || !empty($pdfPath)) && $pdfPath)
            {{-- Simple iframe for PDF viewing --}}
            <iframe
                id="pdf-iframe"
                src="{{ $pdfPath }}#page={{ $currentPage }}"
                class="w-full h-full border-0 bg-white"
                loading="lazy">
                <div class="text-white text-center p-4">Your browser does not support iframes.
                <a href="{{ $pdfPath }}" target="_blank" class="text-primary underline">Open PDF in new tab</a></div>
            </iframe>
        @else
            {{-- Placeholder for unpurchased content --}}
            <div class="flex flex-col items-center justify-center h-full text-white p-8">
                <div class="bg-white/10 rounded-full p-6 mb-6">
                    <span class="material-symbols-outlined text-6xl">lock</span>
                </div>
                <h3 class="text-xl font-semibold mb-2">Premium kontent</h3>
                <p class="text-center text-gray-300 mb-6">
                    To'liq kitobni o'qish uchun sotib oling
                </p>
                <button class="px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors">
                    Sotib olish
                </button>
            </div>
        @endif
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let currentZoom = 100;

        // Zoom controls
        const zoomInBtn = document.getElementById('zoom-in');
        const zoomOutBtn = document.getElementById('zoom-out');

        if (zoomInBtn) {
            zoomInBtn.addEventListener('click', function() {
                currentZoom = Math.min(currentZoom + 25, 200);
                updateZoom();
            });
        }

        if (zoomOutBtn) {
            zoomOutBtn.addEventListener('click', function() {
                currentZoom = Math.max(currentZoom - 25, 50);
                updateZoom();
            });
        }
    });

    function updateZoom() {
        const zoomLevel = document.getElementById('zoom-level');
        if (zoomLevel) {
            zoomLevel.textContent = currentZoom + '%';
        }

        // Apply zoom to iframe container
        const container = document.getElementById('pdf-container');
        if (container) {
            container.style.transform = `scale(${currentZoom / 100})`;
            container.style.transformOrigin = 'top center';
            container.style.height = `${800 * (100 / currentZoom)}px`;
        }
    }

    function printPDF() {
        const iframe = document.getElementById('pdf-iframe');
        if (iframe) {
            try {
                iframe.contentWindow.print();
            } catch (error) {
                // Fallback: open in new window
                window.open('{{ $pdfPath }}', '_blank');
            }
        }
    }

    function downloadPDF() {
        @if($pdfPath)
            const link = document.createElement('a');
            link.href = '{{ $pdfPath }}';
            link.download = '{{ $filename }}';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        @endif
    }
</script>
