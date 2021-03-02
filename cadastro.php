<?php

$response = array();

if(isset($_POST['login']) && isset($_POST['senha'])){
    $login_passado = $_POST['login'];
    $senha_passada = $_POST['senha'];

    $con = pg_connect(getenv("DATABASE_URL"));
    $result1 = pg_query($con, "SELECT * FROM usuarios WHERE login = $login_passado ");

    if (pg_num_rows($result1) > 0) {
        $response["success"] = 0;
        $response["message"] = "Esse login ja esta sendo utilizado.";

        pg_close($con);

        echo json_encode($response);
    } else {
        $result2 = pg_query($con, "INSERT INTO usuarios(login, senha) VALUES('$login_passado', '$senha_passada')");

        if ($result2) {
            $response["success"] = 1;
            $response["message"] = "Cadastro realizado com sucesso";
    
            pg_close($con);
            echo json_encode($response);

        } else {
            $response["success"] = 0;
            $response["message"] = "Erro ao realizar cadastro";

            pg_close($con);
            echo json_encode($response);
        }
    }
} else {
    $response["success"] = 0;
    $response["message"] = "Campo requerido nao preenchido";

    echo json_encode($response);
}

?>