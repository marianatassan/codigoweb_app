<?php

$response = array();
$con = pg_connect(getenv("DATABASE_URL"));

$result = pg_query($con, "SELECT * FROM publicacoes");

if (pg_num_rows($result) > 0) {
    $response["publicacoes"] = array();

    while ($row = pg_fetch_array($result)) {
        $publicacao = array();
        $publicacao["id_publicacao"] = $row["id_publicacao"];
        $publicacao["titulo"] = $row["titulo"];
        $publicacao["img"] = $row["img"];

        array_push($response["publicacoes"], $publicacao);
    }

    $response["success"] = 1;
    pg_close($con);
    echo json_encode($response);
} else {
    $response["success"] = 0;
    $response["message"] = "Nao ha postagens";

    pg_close($con);

    echo json_encode($response);
}

?>