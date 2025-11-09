<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>PDF Viewer</title>
    <!-- Update ke versi terbaru -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>

    <style>
        :root {
            --green: #22c55e;
            --green-700: #16a34a;
            --shadow: 0 10px 30px rgba(0, 0, 0, .15);
        }

        html,
        body {
            margin: 0;
            padding: 0;
            height: 100%;
            background: #f3f4f6;
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, Ubuntu, "Helvetica Neue", Arial;
            overflow-x: hidden;
        }

        /* Container PDF */
        .pdf-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            min-height: 100vh;
            background: #f3f4f6;
            padding: 20px 0 100px 0;
            gap: 10px;
        }

        .page-wrapper {
            background: white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin: 0;
            max-width: 100%;
        }

        canvas {
            display: block;
            width: 100% !important;
            height: auto !important;
        }

        .loading {
            text-align: center;
            color: #6b7280;
            padding: 40px;
        }

        /* Tombol WhatsApp fixed bawah */
        .whatsapp-bar {
            position: fixed;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 50%;
            max-width: 480px;
            background: var(--green);
            color: #fff;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 16px 0;
            border-radius: 20px 20px 0 0;
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.15);
            font-size: 1rem;
            font-weight: 600;
            z-index: 100;
            transition: background .25s ease, transform .25s ease;
        }

        .whatsapp-bar:hover {
            background: var(--green-700);
            transform: translateX(-50%) scale(1.02);
        }

        .whatsapp-bar svg {
            width: 24px;
            height: 24px;
            fill: currentColor;
        }

        @media(max-width:768px) {
            .whatsapp-bar {
                width: 100%;
                border-radius: 0;
            }

            .pdf-container {
                padding: 10px 0 80px 0;
            }
        }
    </style>
</head>

<body>
    <div class="pdf-container" id="pdfContainer">
        <div class="loading">Memuat konten...</div>
    </div>

    <!-- Tombol WhatsApp bawah -->
    <a id="waBtn" class="whatsapp-bar" href="#" target="_blank" rel="noopener">
        <svg viewBox="0 0 24 24">
            <path
                d="M20.52 3.48A11.93 11.93 0 0 0 12 0C5.38 0 0 5.38 0 12a11.93 11.93 0 0 0 3.48 8.52A11.93 11.93 0 0 0 12 24c6.62 0 12-5.38 12-12 0-3.2-1.24-6.21-3.48-8.52zM12 22.06c-2.16 0-4.18-.67-5.86-1.94l-.42-.31-3.1.82.83-3.02-.32-.43A9.93 9.93 0 0 1 2.06 12C2.06 6.5 6.5 2.06 12 2.06S21.94 6.5 21.94 12 17.5 21.94 12 21.94zm5.12-7.29c-.28-.14-1.67-.82-1.93-.91-.26-.1-.45-.14-.64.14-.19.28-.74.91-.9 1.1-.17.19-.33.21-.61.07-.28-.14-1.18-.44-2.25-1.4-.83-.74-1.4-1.65-1.57-1.93-.16-.28-.02-.43.12-.57.12-.12.28-.33.4-.5.14-.17.19-.28.28-.47.1-.19.05-.36-.02-.5-.07-.14-.64-1.54-.88-2.11-.23-.55-.47-.47-.64-.47h-.55c-.19 0-.5.07-.76.36-.26.28-1 1-1 2.43 0 1.43 1.03 2.81 1.17 3 .14.19 2.01 3.06 4.88 4.29 1.9.82 2.64.9 3.58.76.58-.09 1.67-.68 1.9-1.34.24-.66.24-1.23.17-1.34-.05-.12-.23-.19-.5-.31z" />
        </svg>
        Hubungi via WhatsApp
    </a>

    <script>
        // Setup PDF.js worker
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

        // Ganti dengan URL PDF Anda
        const pdfUrl = "{{ $pdfUrl }}";
        const waNumber = "{{ $whatsapp }}"; // Ganti dengan nomor WA
        const msg = encodeURIComponent("Halo, saya tertarik dengan informasi ini.");
        document.getElementById("waBtn").href = `https://wa.me/${waNumber.replace(/[^0-9]/g,"")}?text=${msg}`;

        const pdfContainer = document.getElementById("pdfContainer");

        // Konfigurasi loading task dengan options tambahan
        const loadingTask = pdfjsLib.getDocument({
            url: pdfUrl,
            cMapUrl: 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/cmaps/',
            cMapPacked: true,
            isEvalSupported: false,
            useSystemFonts: true
        });

        loadingTask.promise.then(pdf => {
            pdfContainer.innerHTML = '';

            // Render semua halaman
            const renderPromises = [];
            for (let pageNum = 1; pageNum <= pdf.numPages; pageNum++) {
                renderPromises.push(
                    pdf.getPage(pageNum).then(page => {
                        // Scale lebih tinggi untuk kualitas lebih baik
                        const scale = 2.0;
                        const viewport = page.getViewport({
                            scale: scale
                        });

                        const pageWrapper = document.createElement('div');
                        pageWrapper.className = 'page-wrapper';

                        const canvas = document.createElement('canvas');
                        const context = canvas.getContext('2d', {
                            alpha: false,
                            willReadFrequently: false
                        });

                        // High DPI rendering
                        const dpr = window.devicePixelRatio || 1;
                        const bsr = context.webkitBackingStorePixelRatio ||
                            context.mozBackingStorePixelRatio ||
                            context.msBackingStorePixelRatio ||
                            context.oBackingStorePixelRatio ||
                            context.backingStorePixelRatio || 1;
                        const ratio = dpr / bsr;

                        canvas.width = viewport.width * ratio;
                        canvas.height = viewport.height * ratio;
                        canvas.style.width = viewport.width + "px";
                        canvas.style.height = viewport.height + "px";

                        context.setTransform(ratio, 0, 0, ratio, 0, 0);

                        const renderContext = {
                            canvasContext: context,
                            viewport: viewport,
                            intent: 'display',
                            enableWebGL: false,
                            renderInteractiveForms: false,
                            background: 'white'
                        };

                        return page.render(renderContext).promise.then(() => {
                            pageWrapper.appendChild(canvas);
                            pdfContainer.appendChild(pageWrapper);
                        });
                    })
                );
            }

            return Promise.all(renderPromises);
        }).catch(err => {
            pdfContainer.innerHTML = '<div class="loading" style="color:red">Gagal memuat PDF: ' + err.message +
                '</div>';
            console.error('PDF Loading Error:', err);
        });
    </script>
</body>

</html>
