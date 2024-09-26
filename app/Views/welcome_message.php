<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loading Animation</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f0f0f0;
            font-family: sans-serif;
        }

        /* Loading container */
        .loader {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100px;
            height: 100px;
            position: relative;
        }

        /* Lingkaran luar */
        .circle {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 8px solid #e0e0e0;
            border-top-color: #3498db;
            animation: spin 1.5s linear infinite;
        }

        /* Lingkaran tengah */
        .circle::before {
            content: '';
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: #3498db;
            position: absolute;
            top: 10px;
            left: 10px;
            opacity: 0.1;
            animation: pulse 1s infinite alternate;
        }

        /* Animasi lingkaran berputar */
        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        /* Animasi denyut pada lingkaran dalam */
        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 0.1;
            }
            100% {
                transform: scale(1.2);
                opacity: 0.3;
            }
        }

        /* Pesan 'Loading' di bawah animasi */
        .loading-text {
            position: absolute;
            top: 120px;
            font-size: 18px;
            color: #333;
            animation: fadeIn 2s infinite;
        }

        /* Animasi teks memudar */
        @keyframes fadeIn {
            0%, 100% {
                opacity: 0;
            }
            50% {
                opacity: 1;
            }
        }
    </style>
</head>
<body>

    <div class="loader">
        <div class="circle"></div>
        <div class="loading-text">Loading...</div>
    </div>

</body>
</html>
