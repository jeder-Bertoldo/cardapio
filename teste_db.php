<?php
$json = '[{"id":"5","nome":"gregregr","descricao":"egergergerger","preco":"0.11","imagem":"assets/img/6752728cd9115-WhatsApp Image 2024-06-29 at 17.09.44.jpeg","criado_em":"2024-12-06 00:42:04"}]';

// Decodificando o JSON
$data = json_decode($json, true);

// Exibindo erros, se houver
if (json_last_error() !== JSON_ERROR_NONE) {
    echo "Erro ao decodificar JSON: " . json_last_error_msg();
} else {
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}
?>

