<?php

$response = array();
$con = pg_connect(getenv("DATABASE_URL"));

if(isset($_POST['login']) && isset($_POST['senha'])){
    $login_passado = trim($_POST['login']);
    $senha_passada = trim($_POST['senha']);

    $result1 = pg_query($con, "SELECT senha FROM usuarios WHERE login = '$login_passado' ");

    if (pg_num_rows($result1) > 0) {
        $row = pg_fetch_array($result1);
		if($senha_passada == $row['senha']){
			$result3 = pg_query($con, "SELECT id FROM usuarios WHERE login = '$login_passado' ");
			$response["success"] = 1;
            $response["id"] = strval($result3['id']);
        } else {
            $response["success"] = 0;
            $response["message"] = "Senha inserida incorreta";
        }
    } else {
        $response["success"] = 0;
        $response["message"] = "Usuario nao cadastrado no sistema.";
    }
} else {
    $response["success"] = 0;
    $response["message"] = "Campo requerido nao preenchido";
}
pg_close($con);
echo json_encode($response);

?>