<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Galeri</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 500px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="url"],
        input[type="file"],
        select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Tambah Galeri Baru</h1>
        <form id="galeriForm" method="post" enctype="multipart/form-data">
            <label for="judul">Judul:</label>
            <input type="text" name="judul" required>

            <label for="tipe">Tipe:</label>
            <select name="tipe" id="tipe" required onchange="toggleInput()">
                <option value="image">Image</option>
                <option value="video">Video</option>
            </select>

            <!-- Input untuk gambar -->
            <div id="imageInput" style="display: none;">
                <label for="image">Upload Gambar:</label>
                <input type="file" name="image">
            </div>

            <!-- Input untuk URL video -->
            <div id="urlInput" style="display: none;">
                <label for="url">URL Video:</label>
                <input type="url" name="url">
            </div>

            <button type="submit">Simpan</button>
        </form>

        <script>
            function toggleInput() {
                const tipe = document.getElementById('tipe').value;
                if (tipe === 'image') {
                    document.getElementById('imageInput').style.display = 'block';
                    document.getElementById('urlInput').style.display = 'none';
                    document.getElementById('galeriForm').setAttribute('action', '/superadmin/galeri/storeImage');
                } else if (tipe === 'video') {
                    document.getElementById('imageInput').style.display = 'none';
                    document.getElementById('urlInput').style.display = 'block';
                    document.getElementById('galeriForm').setAttribute('action', '/superadmin/galeri/storeVideo');
                }
            }

            // Initialize visibility based on selected type
            toggleInput();
        </script>

</body>

</html>