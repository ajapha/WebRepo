<?php
include_once '../PhpProject1/databaseHandle.php';

function getInfo($key) {
        $dbHandle = new dbManage();
        $dbHandle->dbConnect('electronics', 'dba', 'pcs');
        $STH  = $dbHandle->select('*', 'products', "type = '$key'");
        $info = $STH->fetchAll ( PDO::FETCH_ASSOC );
        return json_encode($info);
    }
  
    echo(getInfo($_GET['key']));

