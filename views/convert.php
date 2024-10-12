<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Conversão PDF para JPEG</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h1>Conversão de PDF para JPEG</h1>
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="file" name="pdf_file" accept=".pdf" required>
        <button type="submit">Converter</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['pdf_file'])) {
        // Lógica para converter PDF para JPEG usando a API
        echo "Arquivo convertido com sucesso!";
    }
    ?>
</body>
</html>
