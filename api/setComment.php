<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
$mysqli = new mysqli("localhost", "id16847637_admin", "7?*09~J>@9X%I8Vb", "id16847637_honeyhuntersmanagement",3306);
if ($mysqli->connect_errno) {
    echo json_encode(0);
}
else
{
    if (!($stmt = $mysqli->prepare("INSERT INTO comments(t_uuid,name,email,c_text) VALUES (?,?,?,?)"))) {
     echo json_encode(-1);
    }
    else{
        $uuid = uniqid();
        $idlast = $_GET["id"];
        $name = $_POST["name"];
        $email = $_POST["email"];
        $c_text = $_POST["c_text"];
        /*echo $name ;
        echo $email;
        echo $c_text;
        echo preg_match("/^[A-Za-zА-Яа-яЁё]{1,}$/m",  $name);
        echo preg_match('/^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/m', $email);
        echo json_encode(strlen($c_text) > 0);*/
        
        if (preg_match("/^[A-Za-zА-Яа-яЁё]{1,}$/m",  $name)&&
             preg_match('/^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/m', $email)&&
            strlen($c_text) > 0){
            if (!$stmt->bind_param("ssss", $uuid, $name, $email, $c_text)) {
                echo json_encode(-2);
            }
            else{
            if (!$stmt->execute()) {
                echo json_encode(-3);
            }
            else{
                $stmt->close();
                if (!($stmt = $mysqli->prepare("SELECT * FROM comments WHERE id > ?"))) {
                    echo json_encode(-4);
                }
                else{
                    $id = $_GET["id"];
                    if (!$stmt->bind_param("i", $id)) {
                        echo json_encode(-5);
                    }
                    else{
                        if (!$stmt->execute()) {
                            echo json_encode(-6);
                        }
                        else{
                            if (!($res = $stmt->get_result())) {
                                echo json_encode(-7);
                            }
                            else
                            {
                                echo json_encode($res->fetch_all());
                            }
                        }
                    }
                }
            }
        }    
        }
        else{
             echo json_encode(-10);
        }
        
    }
}
?>