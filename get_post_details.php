<?php

$response = array();

if (isset($_GET["id_postagem"])) {
    $id_postagem = $_GET['id_postagem'];

    $con = pg_connect(getenv("DATABASE_URL"));
    $result = pg_query($con, "SELECT * FROM postagens WHERE id_postagem = $id_postagem");

    if (!empty($result)) {
        if (pg_num_rows($result) > 0) {
            $result = pg_fetch_array($result);

            $postagem = array();
            $postagem["titulo"] = $result["titulo"];
            $postagem["legenda"] = $result["legenda"];
			$postagem["img"] = $result["img"];
            $postagem["created_at"] = $result["created_at"];

            $response["success"] = 1;
            $response["postagem"] = array();
            array_push($response["postagem"], $postagem);
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