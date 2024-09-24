<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Filmes</title>
    <link rel="stylesheet" href="style.css"> <!-- Importando o CSS -->
</head>
<body>
    <h1>Buscar Filme ou Série</h1>
    <form method="POST" action="buscar.php">
        <label for="filme">Nome do Filme:</label>
        <input type="text" id="filme" name="filme" required>
        <button type="submit">Buscar</button>
    </form>
</body>
</html>
