<<<<<<< HEAD
<?php
$usuid = $_GET['login'];
$con = pg_connect(getenv("DATABASE_URL"));
$result = pg_query($con, "SELECT id FROM usuarios WHERE login=$usuid LIMIT 1");
$usuid = NULL;
if ($result && pg_num_rows($result) > 0) {
    $usuid = pg_fetch_array($result, NULL, MYSQLI_ASSOC)['id'];
}

$response = array();
if (isset($_POST['titulo']) && isset($_POST['legenda'])  && isset($_FILES['img'])) {
    $titulo = $_POST['titulo'];
    $legenda = $_POST['legenda'];

    $imageFileType = strtolower(pathinfo(basename($_FILES["img"]["name"]),PATHINFO_EXTENSION));
    $image_base64 = base64_encode(file_get_contents($_FILES['img']['tmp_name']) );
    $img = 'data:image/'.$imageFileType.';base64,'.$image_base64;

    $con = pg_connect(getenv("DATABASE_URL"));
    $result = pg_query($con, "INSERT INTO postagens(titulo, legenda, img, usuid) VALUES('$titulo', '$legenda', '$img', '$usuid')");

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

    echo json_encode($response);
}
?>