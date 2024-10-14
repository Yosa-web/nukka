<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Galeri</title>
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
        input[type="file"],
        input[type="url"],
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
    <script>
        function toggleInput() {
            const tipe = document.querySelector('select[name="tipe"]').value;
            const imageInput = document.getElementById('imageInput');
            const urlInput = document.getElementById('urlInput');

            if (tipe === 'image') {
                imageInput.style.display = 'block';
                urlInput.style.display = 'none';
            } else if (tipe === 'video') {
                imageInput.style.display = 'none';
                urlInput.style.display = 'block';
            }
        }
    </script>
</head>

<body>
    <div class="container">
        <h1>Edit Galeri</h1>
        <form action="/superadmin/galeri/update/<?= $galeri['id_galeri'] ?>" method="post" enctype="multipart/form-data">
            <label for="judul">Judul:</label>
            <input type="text" name="judul" value="<?= $galeri['judul'] ?>" required>

            <label for="tipe">Tipe:</label>
            <select name="tipe" required onchange="toggleInput()">
                <option value="image" <?= $galeri['tipe'] == 'image' ? 'selected' : '' ?>>Image</option>
                <option value="video" <?= $galeri['tipe'] == 'video' ? 'selected' : '' ?>>Video</option>
            </select>

            <div id="imageInput" style="display: <?= $galeri['tipe'] == 'image' ? 'block' : 'none' ?>;">
                <label for="image">Upload Gambar:</label>
                <input type="file" name="image">
            </div>

            <div id="urlInput" style="display: <?= $galeri['tipe'] == 'video' ? 'block' : 'none' ?>;">
                <label for="url">URL Video:</label>
                <input type="url" name="url" value="<?= $galeri['url'] ?>">
            </div>

            <button type="submit">Update</button>
        </form>
    </div>
    <script>
        // Run this to set the correct input visibility on page load
        toggleInput();
    </script>
</body>

</html>