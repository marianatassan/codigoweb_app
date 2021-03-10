<?php

    $login = 'teste';
    $senha = '123';
	$id_usuario = '1';
    $titulo = 'titulo teste';
    $legenda = 'legenda teste';

    $img = 'asdffd';
	
	$con = pg_connect(getenv("DATABASE_URL"));

    $result = pg_query($con, "INSERT INTO publicacoes(id_usuario, legenda, titulo, img) VALUES ('$id_usuario','$legenda','$titulo','$img')");

    if ($result) {
        $response["success"] = 1;
        $response["message"] = "Postagem realizada com sucesso";
		
    } else {
        $response["success"] = 0;
        $response["message"] = "Erro ao criar produto no BD";
    }
pg_close($con);

?>