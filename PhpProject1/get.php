<?php
include_once './databaseHandle.php';

    function getInfo($info) {
        $dbHandle = new dbManage();
        $dbHandle->dbConnect('employees', 'dba', 'pcs');
        $STH  = $dbHandle->select('*', 'employees', "last_name like '$info%'");
        $info = $STH->fetchAll ( PDO::FETCH_ASSOC );
        return json_encode($info);
    }
  
    echo(getInfo($_GET['info']));
    //getInfo($_GET['info']);