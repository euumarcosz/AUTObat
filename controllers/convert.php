<?php
function convertPdfToJpeg($pdfFilePath, $apiKey) {
    $url = 'https://api.pdf.co/v1/pdf/convert/to/image';

    // Dados que serão enviados como JSON
    $data = [
        'url' => $pdfFilePath,
        'name' => 'output.jpg',
        'async' => false,
        'outputFormat' => 'jpeg',
        'dpi' => 300
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // Convertendo o array para JSON
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json', // Define o tipo de conteúdo como JSON
        'x-api-key: ' . $apiKey // Adiciona a chave da API no cabeçalho
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}

// Exemplo de uso
$pdfUrl = 'http://localhost/AUTObat/views/convert.php'; // Substitua pela URL do seu PDF
$apiKey = 'marcosdesigner98@gmail.com_G3DxsXMwDLL6qqUNGOKn6jBO5PJpWFpQu3JIYUOB3oV9oxj6QCuj7FTOLsdBibxI'; // Substitua pela sua chave de API
$response = convertPdfToJpeg($pdfUrl, $apiKey);

if (isset($response['error']) && $response['error'] === false) {
    echo "Imagem gerada com sucesso: " . $response['url'];
} else {
    echo "Erro: " . ($response['message'] ?? 'Erro desconhecido');
}
?>
