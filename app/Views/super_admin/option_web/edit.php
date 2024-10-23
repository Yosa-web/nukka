<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Option</title>
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
            const textInput = document.getElementById('textInput');

            if (tipe === 'image') {
                imageInput.style.display = 'block';
                textInput.style.display = 'none';
            } else if (tipe === 'text') {
                imageInput.style.display = 'none';
                textInput.style.display = 'block';
            }
        }
    </script>
</head>

<body>
    <div class="container">
        <h1>Edit Option</h1>
        <form action="/superadmin/optionweb/update/<?= $options['id_setting'] ?>" method="post" enctype="multipart/form-data">
            <label for="value">Current Value:</label>
            <input type="text" name="value" value="<?= isset($options['value']) ? $options['value'] : '' ?>" readonly>

            <label for="tipe">Tipe:</label>
            <select name="tipe" required onchange="toggleInput()">
                <option value="image" <?= isset($options['tipe']) && $options['tipe'] == 'image' ? 'selected' : '' ?>>Image</option>
                <option value="text" <?= isset($options['tipe']) && $options['tipe'] == 'text' ? 'selected' : '' ?>>Text</option>
            </select>

            <div id="imageInput" style="display: <?= isset($options['tipe']) && $options['tipe'] == 'image' ? 'block' : 'none' ?>;">
                <label for="image">Upload Gambar:</label>
                <input type="file" name="image">
            </div>

            <div id="textInput" style="display: <?= isset($options['tipe']) && $options['tipe'] == 'text' ? 'block' : 'none' ?>;">
                <label for="text">Text Value:</label>
                <input type="text" name="text" value="<?= isset($options['text']) ? $options['text'] : '' ?>">
            </div>

            <button type="submit">Update</button>
        </form>
    </div>
    <script>
        toggleInput();
    </script>
</body>

</html>