@extends('layouts.app-dashboard')
@section('content')

<div class="container-fluid px-4 py-6">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Business Card Preview</h5>
                    <div>
                        <button id="download-pdf" class="btn btn-primary">
                            <i class="bi bi-download me-2"></i>Download as PDF
                        </button>
                        <a href="{{ route('cards.create') }}" class="btn btn-outline-secondary ms-2">
                            <i class="bi bi-arrow-left me-2"></i>Back to Editor
                        </a>
                    </div>
                </div>
                <div class="card-body preview-container" style="background: #f8fafc; border-radius: 12px; min-height: 500px; display: flex; align-items: center; justify-content: center;">
                    <div id="card-container" class="card-wrapper" style="width: 100%; max-width: 842px; aspect-ratio: 842/595; position: relative; transform-origin: center center;">
                        @if($card->template === 'landscape')
                            @include('cards.templates.landscape', $data)
                        @else
                            @include('cards.templates.portrait', $data)
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Overlay for PDF export -->
<div id="pdf-overlay" class="pdf-overlay" style="position: absolute; width: 595px; height: 842px; background: #fff; z-index: 99999; visibility: hidden;">
    @include("cards.templates.{$card->template}", $data)
</div>

{{-- Include html2pdf.js --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>
.preview-container {
    transition: all 0.3s ease;
    min-height: 80vh; /* Make preview area taller */
    background: #f8fafc;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

.card-wrapper {
    width: 100%;
    max-width: 595px;
    aspect-ratio: 595 / 842;
    position: relative;
    transform-origin: center center;
    display: flex;
    align-items: center;
    justify-content: center;
}

@media (max-width: 768px) {
    .preview-container {
        min-height: 400px;
    }
}

/* A4 Page Styles */
.a4-page {
    width: 595px;
    height: 842px;
    background: white;
    position: relative;
    overflow: hidden;
}

/* Print Styles */
@media print {
    .preview-container {
        background: none;
        padding: 0;
    }
    
    .card-wrapper {
        transform: none !important;
        max-width: none;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const downloadButton = document.getElementById('download-pdf');
    const pdfOverlay = document.getElementById('pdf-overlay');
    const cardContainer = document.getElementById('card-container');
    const previewArea = cardContainer.parentElement;

    // Function to handle image loading
    async function loadImages(element) {
        const images = element.querySelectorAll('img');
        await Promise.all(Array.from(images).map(img => {
            if (img.complete) return Promise.resolve();
            return new Promise(resolve => { img.onload = img.onerror = resolve; });
        }));
    }

    // Function to ensure proper scaling
    function adjustScale() {
        const areaWidth = previewArea.clientWidth;
        const areaHeight = previewArea.clientHeight;
        const cardWidth = 595; // A4 width in px
        const cardHeight = 842; // A4 height in px
        // Calculate scale based on container size while maintaining aspect ratio
        const scaleX = areaWidth / cardWidth;
        const scaleY = areaHeight / cardHeight;
        const scale = Math.min(scaleX, scaleY, 1); // Don't upscale beyond 1
        cardContainer.style.transform = `scale(${scale})`;
        cardContainer.style.height = cardHeight + 'px';
        cardContainer.style.width = cardWidth + 'px';
    }

    // Initial scale adjustment
    adjustScale();
    
    // Debounced resize handler
    let resizeTimeout;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(adjustScale, 250);
    });

    downloadButton.addEventListener('click', async function() {
        try {
            downloadButton.disabled = true;
            downloadButton.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Generating PDF...';

            // Make overlay visible but keep it off-screen
            pdfOverlay.style.visibility = 'visible';
            pdfOverlay.style.position = 'absolute';
            pdfOverlay.style.top = '0';
            pdfOverlay.style.left = '0';

            // Wait for images to load
            await loadImages(pdfOverlay);

            // Get template-specific settings
            const template = '{{ $card->template }}';
            let backgroundColor = '#ffffff';
            let quality = 1;
            let scale = 2;

            // PDF options
            const opt = {
                margin: 0,
                filename: '{{ $card->full_name }}-business-card.pdf',
                image: { type: 'jpeg', quality: quality },
                html2canvas: { 
                    scale: scale,
                    useCORS: true,
                    logging: true,
                    backgroundColor: backgroundColor,
                    width: 595,
                    height: 842,
                    windowWidth: 595,
                    windowHeight: 842,
                    x: 0,
                    y: 0,
                    scrollX: 0,
                    scrollY: 0,
                    onclone: function(clonedDoc) {
                        const cardContainer = clonedDoc.querySelector('#pdf-overlay');
                        if (cardContainer) {
                            cardContainer.style.position = 'absolute';
                            cardContainer.style.top = '0';
                            cardContainer.style.left = '0';
                            cardContainer.style.margin = '0';
                            cardContainer.style.padding = '0';
                            cardContainer.style.visibility = 'visible';
                            cardContainer.style.background = backgroundColor;
                        }
                    }
                },
                jsPDF: { 
                    unit: 'px', 
                    format: 'a4',
                    orientation: 'portrait',
                    compress: true
                }
            };

            // Generate PDF
            await html2pdf().set(opt).from(pdfOverlay).save();

            // Reset overlay visibility
            pdfOverlay.style.visibility = 'hidden';

            downloadButton.disabled = false;
            downloadButton.innerHTML = '<i class="bi bi-download me-2"></i>Download as PDF';
        } catch (error) {
            console.error('PDF generation error:', error);
            alert('Failed to generate PDF. Please try again.');
            pdfOverlay.style.visibility = 'hidden';
            downloadButton.disabled = false;
            downloadButton.innerHTML = '<i class="bi bi-download me-2"></i>Download as PDF';
        }
    });
});
</script>
@endsection 