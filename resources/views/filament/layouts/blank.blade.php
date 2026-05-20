<!DOCTYPE html>
<html lang="en">

<head>
    @filamentStyles
    @vite('resources/css/app.css')
    <!-- Notiflix alert message -->
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        /* Hilangkan tombol */
        .notiflix-report-button {
            display: none !important;
        }

        .notiflix-report * {
            font-family: 'Poppins', sans-serif !important;
        }

        /* Isi pesan */
        .notiflix-report-message {
            font-size: 15px !important;
            font-weight: 400 !important;
            line-height: 1.8 !important;
        }

        /* Rapikan footer */
        .notiflix-report-buttons {
            padding: 0 !important;
            margin: 0 !important;
            height: 0 !important;
        }

        /* Center text */
        .notiflix-report-content {
            text-align: center !important;
        }

        /* Tambah ruang atas bawah */
        .notiflix-report-content {
            padding-top: 40px !important;
            padding-bottom: 40px !important;
        }

        /* Rapikan text */
        .notiflix-report-message {
            margin-bottom: 0 !important;
            line-height: 1.7 !important;
        }

        /* font */
    </style>

</head>

<body class="bg-gray-100 min-h-screen">

    {{ $slot }}

    @filamentScripts
    @vite('resources/js/app.js')

    <script src="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/notiflix"></script>
</body>

</html>