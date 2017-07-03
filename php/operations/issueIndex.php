<?php require_once("connection/dbConnection.php");

$indexNo = $_POST['index'];
if(isset($indexNo)) {
    $query = "INSERT INTO student (indexNumber) VALUE ('$indexNo')";
    if (runQuery($query)) {
        return $indexNo;

    }
}else{
    echo "Error";
}

?>