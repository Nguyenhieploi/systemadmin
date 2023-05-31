<?php

function connectDb($dsn='mysql:host=localhost;dbname=admin;charset=utf8',$username='root',$password=''){
    $connect = new PDO($dsn,$username,$password);
    $connect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    return $connect;
}


// lấy tất cả giá trị từ bảng
function getAll($query){ // $query sẽ thực hiện đoạn query sql
    $db = connectDb();
    $prepare = $db->prepare($query);  // perpare dùng để chuẩn bị câu sql
    $prepare->execute();  // execute thực thi câu lệnh sql từ biến prepare
    $result = $prepare->fetchAll(); // fetAll() lấy tât cả dữ liệu
    return $result;
}

// lấy 1 giá trị từ bảng
function first($query){
    $db = connectDb();
    $prepare = $db->prepare($query);  // perpare dùng để chuẩn bị câu sql 
    $prepare->execute();// execute thực thi câu lệnh sql từ biến prepare
    $result = $prepare->fetch(PDO::FETCH_ASSOC);// fetch() lấy 1 dữ liệu
    return $result;
}

//hàm thực hiện câu lệnh từ cái khac file
function executesql($query){
    $db = connectDb();
    $prepare = $db->prepare($query); // perpare dùng để chuẩn bị câu sql 
     $prepare->execute();  // execute thực thi câu lệnh sql từ biến prepare
}