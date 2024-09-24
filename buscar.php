<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

// Conexão com o banco de dados (opcional)
$conn = new mysqli('localhost', 'root', '', 'busca_filmes');

// Verifica se houve erro na conexão
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

// Inicializa a variável para os resultados
$resultados = [];

// Verifica se o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['filme'])) {
    $filme = $conn->real_escape_string($_POST['filme']);
    
    // URL da API com sua chave
    $url = "http://www.omdbapi.com/?s=" . urlencode($filme) . "&apikey=aaecf544&language=pt-BR"; // Substitua SUA_API_KEY pela sua chave da API.
    
    // Faz a requisição à API
    $response = file_get_contents($url);
    $dados = json_decode($response, true);

    // Verifica se a API retornou resultados
    if (isset($dados['Search'])) {
        $resultados = $dados['Search'];
    } else {
        echo "<p>Nenhum filme encontrado.</p>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Filmes</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Bem-vindo, <?php echo $_SESSION['usuario_nome']; ?>!</h1>
    <form method="POST" action="buscar.php">
        <label for="filme">Buscar Filme:</label>
        <input type="search" id="filme" name="filme" required>
        <button type="submit">Buscar</button>
    </form>

    <!-- Exibe os resultados da busca -->
    <?php if (!empty($resultados)): ?>
        <div class="resultados">
            <h2>Resultados da Busca:</h2>
            <?php foreach ($resultados as $filme): ?>
                <div class="filme">
                    <h3><?php echo htmlspecialchars($filme['Title']); ?> (<?php echo htmlspecialchars($filme['Year']); ?>)</h3>
                    <img src="<?php echo htmlspecialchars($filme['Poster']); ?>" alt="<?php echo htmlspecialchars($filme['Title']); ?>">
                    <p>ID: <?php echo htmlspecialchars($filme['imdbID']); ?></p>
                    <a href="detalhes.php?id=<?php echo htmlspecialchars($filme['imdbID']); ?>">Ver Detalhes</a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <a href="logout.php">Sair</a>
</body>
</html>
