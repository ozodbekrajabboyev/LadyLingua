@props([
    'filename' => 'book.pdf',
    'currentPage' => 1,
    'totalPages' => 1,
    'pages' => [],
    'isPurchased' => false,
    'previewPages' => 2,
    'pdfPath' => '/book.pdf'
])

@php
    // Validate and sanitize PDF path
    $validPdfPath = \App\Helpers\PdfHelper::validatePdfPath($pdfPath);
    $safeIframeParams = \App\Helpers\PdfHelper::generateIframeParams($pdfPath, [
        'page' => $currentPage,
        'toolbar' => 1,
        'navpanes' => 0,
        'scrollbar' => 1,
        'view' => 'FitH'
    ]);
@endphp

<section class="w-full flex flex-col items-center bg-[#525659] rounded-xl overflow-hidden shadow-inner h-[800px] relative group/viewer">
    {{-- PDF Toolbar --}}
    <div class="w-full bg-[#323639] text-white p-3 flex items-center justify-between shadow-md z-10 sticky top-0">
        <div class="flex items-center gap-4">
            <button class="text-gray-300 hover:text-white" id="menu-btn">
                <span class="material-symbols-outlined">menu</span>
            </button>
            <span class="font-medium text-sm">{{ $filename }}</span>
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

    {{-- PDF Content Area with Iframe --}}
    <div class="w-full flex-1 relative bg-[#525659]" id="pdf-container">
        @if(($isPurchased || !empty($pdfPath)) && $validPdfPath)
            {{-- PDF Iframe --}}
            <iframe
                id="pdf-iframe"
                src="{{ asset($validPdfPath) }}{{ $safeIframeParams }}"
                class="w-full h-full border-0 bg-white"
                title="PDF Viewer: {{ e($filename) }}"
                loading="lazy"
                sandbox="allow-scripts allow-same-origin allow-popups allow-forms"
                onload="handleIframeLoad()"
                onerror="handleIframeError()">
                {{-- Fallback content for browsers that don't support iframe --}}
                <div class="flex flex-col items-center justify-center h-full text-white p-8">
                    <span class="material-symbols-outlined text-6xl mb-4">error</span>
                    <p class="text-lg mb-4">PDF viewer not supported in your browser</p>
                    <a href="{{ asset($validPdfPath) }}"
                       target="_blank"
                       class="px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors">
                        Open PDF in new tab
                    </a>
                </div>
            </iframe>

            {{-- Loading overlay --}}
            <div id="pdf-loading" class="absolute inset-0 bg-[#525659] flex flex-col items-center justify-center text-white">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-white mb-4"></div>
                <p>Loading PDF...</p>
            </div>

            {{-- Error overlay --}}
            <div id="pdf-error" class="absolute inset-0 bg-[#525659] flex flex-col items-center justify-center text-white hidden">
                <span class="material-symbols-outlined text-6xl mb-4">error</span>
                <p class="text-lg mb-4">Failed to load PDF</p>
                <button onclick="reloadPDF()" class="px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors">
                    Retry
                </button>
                <a href="{{ asset($validPdfPath) }}"
                   target="_blank"
                   class="mt-2 text-blue-300 hover:text-blue-100 underline">
                    Open in new tab instead
                </a>
            </div>
        @elseif(!$validPdfPath)
            {{-- Invalid PDF path error --}}
            <div class="flex flex-col items-center justify-center h-full text-white p-8">
                <span class="material-symbols-outlined text-6xl mb-4">error</span>
                <h3 class="text-2xl font-bold mb-4">PDF Not Found</h3>
                <p class="text-center text-gray-300 mb-6 max-w-md">
                    The requested PDF file is not available or cannot be displayed safely.
                </p>
            </div>
        @else
            {{-- Preview/Purchase required content --}}
            <div class="flex flex-col items-center justify-center h-full text-white p-8">
                <div class="bg-white/10 rounded-full p-6 mb-6">
                    <span class="material-symbols-outlined text-6xl">lock</span>
                </div>
                <h3 class="text-2xl font-bold mb-4">Premium Content</h3>
                <p class="text-center text-gray-300 mb-6 max-w-md">
                    This PDF requires purchase to view the full content. You can preview the first few pages for free.
                </p>
                <button class="px-8 py-3 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors font-semibold">
                    Purchase Now - 15,000 UZS
                </button>
            </div>
        @endif
    </div>
</section>

@push('scripts')
    <script>
        let currentZoom = 100;
        let pdfIframe = null;

        document.addEventListener('DOMContentLoaded', function() {
            pdfIframe = document.getElementById('pdf-iframe');

            // Initialize zoom controls
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

        function handleIframeLoad() {
            console.log('PDF loaded successfully');
            const loadingElement = document.getElementById('pdf-loading');
            const errorElement = document.getElementById('pdf-error');

            if (loadingElement) {
                loadingElement.style.display = 'none';
            }
            if (errorElement) {
                errorElement.style.display = 'none';
            }

            // Try to get total pages from PDF (this might not work due to cross-origin restrictions)
            try {
                const iframe = document.getElementById('pdf-iframe');
                if (iframe && iframe.contentWindow) {
                    // This might be blocked by CORS policies
                    // You might need to implement server-side page counting
                    console.log('PDF iframe loaded');
                }
            } catch (error) {
                console.log('Cannot access iframe content due to security restrictions');
            }
        }

        function handleIframeError() {
            console.error('Failed to load PDF');
            const loadingElement = document.getElementById('pdf-loading');
            const errorElement = document.getElementById('pdf-error');

            if (loadingElement) {
                loadingElement.style.display = 'none';
            }
            if (errorElement) {
                errorElement.style.display = 'flex';
            }
        }

        function reloadPDF() {
            const iframe = document.getElementById('pdf-iframe');
            const loadingElement = document.getElementById('pdf-loading');
            const errorElement = document.getElementById('pdf-error');

            if (loadingElement) {
                loadingElement.style.display = 'flex';
            }
            if (errorElement) {
                errorElement.style.display = 'none';
            }

            if (iframe) {
                // Reload the iframe
                iframe.src = iframe.src;
            }
        }

        function downloadPDF() {
            @if($validPdfPath)
                const pdfPath = '{{ asset($validPdfPath) }}';

                // Create a temporary link to download the PDF
                const link = document.createElement('a');
                link.href = pdfPath;
                link.download = '{{ e($filename) }}';
                link.style.display = 'none';

                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            @else
                console.error('Invalid PDF path for download');
            @endif
        }

        function printPDF() {
            const iframe = document.getElementById('pdf-iframe');

            if (iframe) {
                try {
                    // Try to print the iframe content
                    iframe.contentWindow.print();
                } catch (error) {
                    console.log('Cannot print iframe content, opening in new window');
                    // Fallback: open PDF in new window for printing
                    @if($validPdfPath)
                        const printWindow = window.open('{{ asset($validPdfPath) }}', '_blank');
                        if (printWindow) {
                            printWindow.onload = function() {
                                printWindow.print();
                            };
                        }
                    @endif
                }
            }
        }

        // Navigation functions for page controls
        function goToPage(pageNumber) {
            const iframe = document.getElementById('pdf-iframe');
            if (iframe) {
                const currentSrc = iframe.src.split('#')[0];
                iframe.src = currentSrc + '#page=' + pageNumber + '&view=FitH';

                // Update the page display
                const currentPageElement = document.getElementById('current-page');
                if (currentPageElement) {
                    currentPageElement.textContent = pageNumber;
                }
            }
        }

        function nextPage() {
            const currentPageElement = document.getElementById('current-page');
            const totalPagesElement = document.getElementById('total-pages');

            if (currentPageElement && totalPagesElement) {
                const currentPage = parseInt(currentPageElement.textContent);
                const totalPages = parseInt(totalPagesElement.textContent);

                if (currentPage < totalPages) {
                    goToPage(currentPage + 1);
                }
            }
        }

        function previousPage() {
            const currentPageElement = document.getElementById('current-page');

            if (currentPageElement) {
                const currentPage = parseInt(currentPageElement.textContent);

                if (currentPage > 1) {
                    goToPage(currentPage - 1);
                }
            }
        }

        // Add keyboard shortcuts
        document.addEventListener('keydown', function(event) {
            if (event.target.tagName !== 'INPUT' && event.target.tagName !== 'TEXTAREA') {
                switch(event.key) {
                    case 'ArrowLeft':
                        previousPage();
                        break;
                    case 'ArrowRight':
                        nextPage();
                        break;
                    case '+':
                    case '=':
                        if (event.ctrlKey || event.metaKey) {
                            event.preventDefault();
                            document.getElementById('zoom-in')?.click();
                        }
                        break;
                    case '-':
                        if (event.ctrlKey || event.metaKey) {
                            event.preventDefault();
                            document.getElementById('zoom-out')?.click();
                        }
                        break;
                }
            }
        });
    </script>
@endpush
