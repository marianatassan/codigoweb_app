<?php

$response = array();

if(isset($_POST['login']) && isset($_POST['senha'])){
    $login_passado = $_POST['login'];
    $senha_passada = $_POST['senha'];

    $con = pg_connect(getenv("DATABASE_URL"));
    $result1 = pg_query($con, "SELECT * FROM usuarios WHERE login = $login_passado ");

    if (pg_num_rows($result1) > 0) {
        $result2 = pg_query($con, "SELECT senha FROM usuarios WHERE login = $login_passado ");
        if ($senha_passada == $result2) {
            $result3 = pg_query($con, "SELECT * FROM usuarios WHERE senha = $senha_passada ");
            $estado = array();

            $estado["id"] = $result3["id"];
            $estado["login"] = $result3["login"];
			$estado["senha"] = $result3["senha"];

            $response["success"] = 1;
            $response["logado"] = true;
            $response["estado"] = array();
            array_push($response["estado"], $estado);
            pg_close($con);

            echo json_encode($response);
        } else {
            $response["success"] = 0;
            $response["message"] = "Senha inserida incorreta";
            $response["logado"] = false;

            pg_close($con);
            echo json_encode($response);
        }
    } else {
        $response["success"] = 0;
        $response["message"] = "Usuario nao cadastrado no sistema.";
        $response["logado"] = false;

        pg_close($con);

        echo json_encode($response);
    }
} else {
    $response["success"] = 0;
    $response["message"] = "Campo requerido nao preenchido";
    $response["logado"] = false;

    echo json_encode($response);
}

?>