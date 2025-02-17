<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <title>Exemplo PHP</title>
    <meta charset="UTF-8">
</head>
<body>

    <h1>Inserir Dados</h1>

    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        Endereço IP do Servidor: <input type="text" name="servername" required><br>
        Nome de Usuário: <input type="text" name="username" required><br>
        Senha: <input type="password" name="password" required><br>
        Nome do Banco de Dados: <input type="text" name="database" required><br>
        <input type="submit" value="Inserir">
    </form>

    <?php
    // Verifica se o formulário foi enviado
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Habilita a exibição de todos os erros do PHP
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        // Obtém os valores do formulário
        $servername = $_POST['servername'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $database = $_POST['database'];

        // Cria a conexão com o banco de dados
        $conn = new mysqli($servername, $username, $password, $database);

        // Verifica se a conexão falhou
        if ($conn->connect_error) {
            die("Falha na conexão: " . $conn->connect_error);
        }

        // Gera valores aleatórios para os campos
        $valor_rand1 = rand(1, 999);
        $valor_rand2 = bin2hex(random_bytes(4));

        // Obtém o nome do host
        $host_name = gethostname();

        // Prepara a query SQL para inserir os dados
        $stmt = $conn->prepare("INSERT INTO dados (AlunoID, Nome, Sobrenome, Endereco, Cidade, Host) VALUES (?, ?, ?, ?, ?, ?)");

        // Vincula os parâmetros aos seus respectivos tipos
        $stmt->bind_param("isssss", $valor_rand1, $valor_rand2, $valor_rand2, $valor_rand2, $valor_rand2, $host_name);

        // Executa a query
        if ($stmt->execute()) {
            echo "Novo registro criado com sucesso";
        } else {
            echo "Erro: " . $stmt->error;
        }

        // Fecha o statement
        $stmt->close();

        // Fecha a conexão com o banco de dados
        $conn->close();
    }
    ?>

</body>
</html>
