<?php
session_start();

// Conexão com o banco de dados (opcional)
$conn = new mysqli('localhost', 'root', '', 'busca_filmes');

// Verifica se houve erro na conexão
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

$detalhes = [];

// Verifica se um ID de filme foi passado
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // URL da API para detalhes do filme
    $url = "https://www.omdbapi.com/?i=" . urlencode($id) . "&apikey=aaecf544&language=pt-BR"; // Substitua SUA_API_KEY pela sua chave da API.
    
    // Faz a requisição à API
    $response = file_get_contents($url);
    $detalhes = json_decode($response, true);
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($detalhes['Title'] ?? 'Detalhes do Filme'); ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php if (!empty($detalhes)): ?>
        <h1><?php echo htmlspecialchars($detalhes['Title']); ?> (<?php echo htmlspecialchars($detalhes['Year']); ?>)</h1>
        <img src="<?php echo htmlspecialchars($detalhes['Poster']); ?>" alt="<?php echo htmlspecialchars($detalhes['Title']); ?>">
        <p><strong>Diretor:</strong> <?php echo htmlspecialchars($detalhes['Director']); ?></p>
        <p><strong>Atores:</strong> <?php echo htmlspecialchars($detalhes['Actors']); ?></p>
        <p><strong>Gênero:</strong> <?php echo htmlspecialchars($detalhes['Genre']); ?></p>
        <p><strong>Sinopse:</strong> <?php echo htmlspecialchars($detalhes['Plot']); ?></p>
        <p><strong>Avaliação IMDb:</strong> <?php echo htmlspecialchars($detalhes['imdbRating']); ?></p>
        <p><strong>Votos IMDb:</strong> <?php echo htmlspecialchars($detalhes['imdbVotes']); ?></p>
    <?php else: ?>
        <p>Filme não encontrado.</p>
    <?php endif; ?>

    <a href="buscar.php">Voltar à busca</a>
</body>
</html>
