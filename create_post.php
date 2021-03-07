<?php

$response = array();

if (isset($_POST['titulo']) && isset($_POST['legenda']) && isset($_FILES['img']) && isset($_POST['login']) && isset($_POST['senha']) && isset($_POST['id_usuario'])) {
    $login = trim($_POST['login']);
    $senha = trim($_POST['senha']);
    $id_usuario_str = trim($_POST['id_usuario']);
	$id_usuario = intval(id_usuario_str);
    $titulo = trim($_POST['titulo']);
    $legenda = trim($_POST['legenda']);

    $imageFileType = strtolower(pathinfo(basename($_FILES["img"]["name"]),PATHINFO_EXTENSION));
    $image_base64 = base64_encode(file_get_contents($_FILES['img']['tmp_name']) );
    $img = 'data:image/'.$imageFileType.';base64,'.$image_base64;
	
	$con = pg_connect(getenv("DATABASE_URL"));

    $result = pg_query($con, "INSERT INTO publicacoes(id_usuario, legenda, titulo, img) VALUES ('$id_usuario','$legenda','$titulo','$img')");

    if ($result) {
        $response["success"] = 1;
        $response["message"] = "Postagem realizada com sucesso";
		
		pg_close($con);
    } else {
        $response["success"] = 0;
        $response["message"] = "Erro ao criar produto no BD";
		
		pg_close($con);
    }
} else {
    $response["success"] = 0;
    $response["message"] = "Campo requerido nao preenchido";
}
echo json_encode($response);

?>