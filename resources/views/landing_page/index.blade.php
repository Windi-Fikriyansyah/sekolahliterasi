<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $landing->title }}</title>

    <!-- CSS dari GrapesJS -->
    <style>
        {!! $landing->css_content !!}
    </style>

    <!-- CSS tambahan jika diperlukan -->
    <style>
        /* Reset CSS dasar */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }

        /* Responsive images */
        img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>

<body>
    <!-- HTML dari GrapesJS -->
    {!! $landing->html_content !!}

    <!-- JavaScript tambahan jika diperlukan -->
    <script>
        // Fungsi untuk membuat link external terbuka di tab baru
        document.addEventListener('DOMContentLoaded', function() {
            const links = document.querySelectorAll('a');
            links.forEach(link => {
                if (link.hostname !== window.location.hostname) {
                    link.setAttribute('target', '_blank');
                    link.setAttribute('rel', 'noopener noreferrer');
                }
            });

            // Smooth scroll untuk anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        });
    </script>
</body>

</html>
