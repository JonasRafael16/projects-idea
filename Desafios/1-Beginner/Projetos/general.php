<?php
date_default_timezone_set('America/Sao_Paulo');
/** O nome do banco de dados*/
define('DB_NAME', 'classicmodels');
/** Usuario do banco de dados MySQL */
define('DB_USER', 'root');
/** Senha do banco de dados MySQL */
define('DB_PASSWORD', '');
/** nome do host do MySQL */
define('DB_HOST', 'localhost');
//Conectar com o banco
function open_database()
{
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($conn->connect_error) {
        return null;
    }
    mysqli_set_charset($conn, "utf8");
    return $conn;
}
//Fechar conexão com banco

function close_database($conn)
{
    try {
        mysqli_close($conn);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

//PRINCIPAIS--------------------------

function login($user, $senha)
{
    $database = open_database();
    $found = null;
    try {
        $sql = "SELECT * FROM usuarios WHERE `username` = '$user' AND `senha` = '$senha' AND ativo = 's'";
        $result = $database->query($sql);
        if ($result->num_rows > 0)
            $found = $result->fetch_all(MYSQLI_ASSOC);
    } catch (Exception $e) {
        $_SESSION['message'] = $e->GetMessage();
        $_SESSION['type'] = 'danger';
    }

    close_database($database);
    return $found;
}

function Geral($sql = null, $all = true)
{
    $database = open_database();
    $found = null;
    try {
        $result = $database->query($sql);
        if ($result->num_rows > 0)
            $found = $result->fetch_all(MYSQLI_ASSOC);
    } catch (Exception $e) {
        echo ($e->GetMessage());
    }
    close_database($database);
    return $result;
}

function search_customers(){
    $con = Geral("SELECT * FROM customers ");
    return $con;
}