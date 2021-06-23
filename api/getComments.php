<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
$mysqli = new mysqli("localhost", "id16847637_admin", "7?*09~J>@9X%I8Vb", "id16847637_honeyhuntersmanagement",3306);
if ($mysqli->connect_errno) {
    echo json_encode(0);
}
else
{
    if (!($stmt = $mysqli->prepare("SELECT * FROM comments WHERE id > ?"))) {
     echo json_encode(-1);
    }
    else{
        $id = $_GET["id"];
        if (!$stmt->bind_param("i", $id)) {
            echo json_encode(-2);
        }
        else{
            if (!$stmt->execute()) {
                echo json_encode(-3);
            }
            else{
                if (!($res = $stmt->get_result())) {
                    echo json_encode(-4);
                }
                else
                {
                    echo json_encode($res->fetch_all());
                }
            }
        }
    }
}
?>