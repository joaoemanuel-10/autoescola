<?php

require_once "config.php";

header("Content-Type: application/json; charset=utf-8");


function readAlunos()
{
    global $pdo;

    $sql = "SELECT * FROM Alunos";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $alunos = $stmt->fetchAll();

    echo json_encode($alunos);
}

function createAluno()
{
    global $pdo;

    $dados = json_decode(file_get_contents("php://input"), true);

    $nome = $dados["nome"] ?? "";
    $email = $dados["email"] ?? "";
    $telefone = $dados["telefone"] ?? "";
    $data_nascimento = $dados["data_nascimento"] ?? "";

    $sql = "INSERT INTO Alunos
            (nome, email, telefone, data_nascimento)
            VALUES
            (:nome, :email, :telefone, :data_nascimento)";

    try {

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ":nome" => $nome,
            ":email" => $email,
            ":telefone" => $telefone,
            ":data_nascimento" => $data_nascimento
        ]);

        echo json_encode([
            "mensagem" => "Aluno cadastrado com sucesso!"
        ]);

    } catch (PDOException $e) {

        if ($e->getCode() == 23000) {

            http_response_code(409);

            echo json_encode([
                "erro" => "Este e-mail ja esta cadastrado."
            ]);

        } else {

            http_response_code(500);

            echo json_encode([
                "erro" => "Erro ao cadastrar aluno."
            ]);
        }
    }
}


function readInstrutores()
{
    global $pdo;

    $sql = "SELECT * FROM Instrutores";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $instrutores = $stmt->fetchAll();

    echo json_encode($instrutores);
}


function createInstrutor()
{
    global $pdo;

    $dados = json_decode(file_get_contents("php://input"), true);

    $nome = $dados["nome"] ?? "";
    $email = $dados["email"] ?? "";
    $telefone = $dados["telefone"] ?? "";
    $data_nascimento = $dados["data_nascimento"] ?? "";

    $sql = "INSERT INTO Instrutores
            (nome, email, telefone, data_nascimento)
            VALUES
            (:nome, :email, :telefone, :data_nascimento)";

    try {

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ":nome" => $nome,
            ":email" => $email,
            ":telefone" => $telefone,
            ":data_nascimento" => $data_nascimento
        ]);

        echo json_encode([
            "mensagem" => "Instrutor cadastrado com sucesso!"
        ]);

    } catch (PDOException $e) {

        if ($e->getCode() == 23000) {

            http_response_code(409);

            echo json_encode([
                "erro" => "Este e-mail ja esta cadastrado."
            ]);

        } else {

            http_response_code(500);

            echo json_encode([
                "erro" => "Erro ao cadastrar instrutor."
            ]);
        }
    }
}


function readAulas()
{
    global $pdo;

    $sql = "SELECT * FROM Aulas";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $aulas = $stmt->fetchAll();

    echo json_encode($aulas);
}


function createAula()
{
    global $pdo;

    $dados = json_decode(file_get_contents("php://input"), true);

    $nome = $dados["nome"] ?? "";
    $data = $dados["data"] ?? "";
    $horario = $dados["horario"] ?? "";
    $descricao = $dados["descricao"] ?? "";

    $sql = "INSERT INTO Aulas
            (nome, data, horario, descricao)
            VALUES
            (:nome, :data, :horario, :descricao)";

    try {

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ":nome" => $nome,
            ":data" => $data,
            ":horario" => $horario,
            ":descricao" => $descricao
        ]);

        echo json_encode([
            "mensagem" => "Aula cadastrada com sucesso!"
        ]);

    } catch (PDOException $e) {

        http_response_code(500);

        echo json_encode([
            "erro" => "Erro ao cadastrar aula."
        ]);
    }
}


$rota = $_GET["rota"] ?? "";

if ($_SERVER["REQUEST_METHOD"] == "GET" && $rota == "alunos") {

    readAlunos();

} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && $rota == "alunos/create") {

    createAluno();


} elseif ($_SERVER["REQUEST_METHOD"] == "GET" && $rota == "instrutores") {

    readInstrutores();

} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && $rota == "instrutores/create") {

    createInstrutor();


} elseif ($_SERVER["REQUEST_METHOD"] == "GET" && $rota == "aulas") {

    readAulas();

} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && $rota == "aulas/create") {

    createAula();

} else {

    http_response_code(404);

    echo json_encode([
        "erro" => "Rota nao encontrada."
    ]);
}