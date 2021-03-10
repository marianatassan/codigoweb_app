<?php

$response = array();

// verifica se todos os parâmetros foram enviados pela aplicação;
if (isset($_POST['titulo']) && isset($_POST['legenda']) && isset($_FILES['img']) && isset($_POST['login']) && isset($_POST['senha']) && isset($_POST['id_usuario'])) {
	//atribui os valore à variáveis;
    $login = trim($_POST['login']);
    $senha = trim($_POST['senha']);
    $id_usuario_str = trim($_POST['id_usuario']);
	$id_usuario = intval($id_usuario_str);
    $titulo = trim($_POST['titulo']);
    $legenda = trim($_POST['legenda']);

	//converte a imagem em string
    $imageFileType = strtolower(pathinfo(basename($_FILES["img"]["name"]),PATHINFO_EXTENSION));
    $image_base64 = base64_encode(file_get_contents($_FILES['img']['tmp_name']) );
    $img = 'data:image/'.$imageFileType.';base64,'.$image_base64;
	
	//abre a conexão com o banco
	$con = pg_connect(getenv("DATABASE_URL"));

	//realiza a inserção dos dados na tabela de publicações
    $result = pg_query($con, "INSERT INTO publicacoes(id_usuario, legenda, titulo, img) VALUES ('$id_usuario','$legenda','$titulo','$img')");

    if ($result) {
        $response["success"] = 1;
        $response["message"] = "Postagem realizada com sucesso";
		
		pg_close($con);
		echo json_encode($response);
		
    } else {
        $response["success"] = 0;
        $response["message"] = "Erro ao criar produto no BD";
		
		pg_close($con);
		echo json_encode($response);
    }
} else {
    $response["success"] = 0;
    $response["message"] = "Campo requerido nao preenchido";
	
	pg_close($con);
	echo json_encode($response);
}


?>