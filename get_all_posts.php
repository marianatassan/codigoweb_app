<?php

$response = array();
$con = pg_connect(getenv("DATABASE_URL"));

$result = pg_query($con, "SELECT * FROM postagens");

if (pg_num_rows($result) > 0) {
    $response["postagens"] = array();

    while ($row = pg_fetch_array($result)) {
        $postagem = array();
        $postagem["id_postagem"] = $row["id_postagem"];
        $postagem["titulo"] = $row["titulo"];
        $postagem["img"] = $row["img"];

        array_push($response["postagens"], $postagem);
    }

    $response["success"] = 1;
    pg_close($con);
    echo json_encode($response);
} else {
    $response["success"] = 0;
    $response["message"] = "Nao ha postagens";

    pg_close($con);

    echo json_encode($response);

?>