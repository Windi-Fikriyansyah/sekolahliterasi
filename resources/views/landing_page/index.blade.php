<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Program</title>
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
    @foreach ($programs as $row)
        @if ($row->type_file === 'video')
            <div class="video-block" style="width:100vw; height:100vh; background:#000;">
                <video controls controlsList="nodownload noplaybackrate" oncontextmenu="return false;"
                    style="width:100%; height:100%; object-fit:contain;">
                    <source src="{{ asset('storage/' . $row->file) }}" type="video/mp4">
                </video>
            </div>
        @endif

        @if ($row->type_file === 'pdf')
            <div class="pdf-container pdf-block" data-pdf="{{ asset('storage/' . $row->file) }}">
                <div class="loading">Memuat PDF...</div>
            </div>
        @endif
    @endforeach

    <!-- Tombol WhatsApp bawah -->
    <a class="whatsapp-bar" href="{{ $product->link_formulir ?? '' }}" target="_blank" rel="noopener">
        DAFTAR SEKARANG
    </a>



    <script>
        pdfjsLib.GlobalWorkerOptions.workerSrc =
            'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

        // Render semua PDF berdasarkan urutan
        document.querySelectorAll('.pdf-block').forEach(async (container) => {

            const pdfUrl = container.getAttribute('data-pdf');

            const loadingTask = pdfjsLib.getDocument(pdfUrl);

            loadingTask.promise.then(async pdf => {
                container.innerHTML = ''; // Hapus loading

                for (let pageNum = 1; pageNum <= pdf.numPages; pageNum++) {
                    const page = await pdf.getPage(pageNum);

                    const viewport = page.getViewport({
                        scale: 1.8
                    });
                    const canvas = document.createElement("canvas");
                    const context = canvas.getContext("2d");

                    canvas.width = viewport.width;
                    canvas.height = viewport.height;
                    canvas.style.width = "100%";

                    await page.render({
                        canvasContext: context,
                        viewport: viewport,
                    }).promise;

                    container.appendChild(canvas);
                }

            }).catch(err => {
                container.innerHTML =
                    `<div class="loading" style="color:red">Gagal memuat PDF: ${err.message}</div>`;
            });

        });
    </script>


</body>

</html>
