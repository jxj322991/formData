<?php
header("Access-Control-Allow-Origin: *");
$id = isset($_GET["id"]) ? $_GET["id"] : '';
// 连主库
//$conn = mysqli_connect('路径'.':'.'端口','账号','密码','库名');
include 'conn_sql.php';

// Check connection
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}
$sql = "SELECT * FROM `form_data_code` WHERE id = '" . $id . "'";
$result = $conn->query($sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        if (!strpos($row["content"], "//")) {
            $k = "//" . $row["content"];
        } else {
            $k = $row["content"];
        }
        $v=$row["num"]+1;
$sql = "UPDATE `form_data_code` SET `num` = '".$v."' WHERE `form_data_code`.`id` = '".$id."'";
$result2 = $conn->query($sql);
        Header("HTTP/1.1 303 See Other");
        Header("Location: $k");
    }
} else {
    exit('错误路径!');
}
// Header("Location:$result");

?>

