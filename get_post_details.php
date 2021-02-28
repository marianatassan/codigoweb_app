<?php

$response = array();

if (isset($_GET["id_publicacao"])) {
    $id_publicacao = $_GET['id_publicacao'];

    $con = pg_connect(getenv("DATABASE_URL"));
    $result = pg_query($con, "SELECT * FROM publicacoes WHERE id_publicacao = $id_publicacao");

    if (!empty($result)) {
        if (pg_num_rows($result) > 0) {
            $result = pg_fetch_array($result);

            $publicacao = array();
            $publicacao["titulo"] = $result["titulo"];
            $publicacao["legenda"] = $result["legenda"];
			$publicacao["img"] = $result["img"];

            $response["success"] = 1;
            $response["publicacao"] = array();
            array_push($response["publicacao"], $publicacao);
            pg_close($con);

            echo json_encode($response);
        } else {
            $response["success"] = 0;
            $response["message"] = "Postagem não encontrada";

            pg_close($con);
            echo json_encode($response);
        }
    } else {
        $response["success"] = 0;
        $response["message"] = "Postagem não encontrada";

        pg_close($con);
        echo json_encode($response);
    }
} else {
    $response["success"] = 0;
    $response["message"] = "Campo requerido não preenchido";

    echo json_encode($response);
}

?>