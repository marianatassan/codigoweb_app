<?php

$response = array();
$con = pg_connect(getenv("DATABASE_URL"));

if(isset($_POST['novoLogin']) && isset($_POST['novaSenha'])){
    $login_passado = trim($_POST['novoLogin']);
    $senha_passada = trim($_POST['novaSenha']);

    $result1 = pg_query($con, "SELECT * FROM usuarios WHERE login = '$login_passado' ");

    if (pg_num_rows($result1) > 0) {
        $response["success"] = 0;
        $response["message"] = "Esse login ja esta sendo utilizado.";
    } else {
        $result2 = pg_query($con, "INSERT INTO usuarios(login, senha) VALUES('$login_passado', '$senha_passada')");

        if ($result2) {
            $response["success"] = 1;
            $response["message"] = "Cadastro realizado com sucesso";

        } else {
            $response["success"] = 0;
            $response["message"] = "Erro ao realizar cadastro";
        }
    }
} else {
    $response["success"] = 0;
    $response["message"] = "Campo requerido nao preenchido";
}
pg_close($con);
echo json_encode($response);

?>