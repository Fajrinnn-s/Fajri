<?php
session_start();
//Masukkan file connection.php
require 'koneksi.php';

if($_SERVER['REQUEST_METHOD'] === "POST");{
    //Ambil Nilai Input fullname
    $fullname = htmlspecialchars($_POST['fullname']);
    //Ambil nilai input email
    $email = htmlspecialchars($_POST['email']);
    //Ambil nilai input Password
    $password=htmlspecialchars($_POST['password']);
    //Ambil nilai input Password Confirm
    $password_confirm=htmlspecialchars($_POST['password_confirm']);

    //Variable Penampung error validasi
    $error=[];

    //Pengecekkan input Fullname tidak boleh kosong
    if(empty($fullname)){
        $error['fullname'] = "Fullname is required";
    }
    //Pengecekkan input email tidak boleh kosong dan harus sesuai dengan format email
    if(empty($email)){
        $error['email'] = "Email is required";
    }
    //Pengecekkan input password tidak boleh kosong 
    if(empty($password)){
        $error['password'] = "Password is required";
    }
    //Pengecekkan input password confirm tidak boleh kosong
    if(empty($password_confirm)){
        $error['password_confirm'] = "Password Confirm is required";
    }
    //Pengecekkan input password dan confirm password sama
    if($password !== $password_confirm){
        $error['password_confirm'] = "Password and Confirm Password do not match";
    }

//Apabila ada error kirim pesan error ke index.php
if(!empty($error)){
    $_SESSION['error'] = $error;
    $_SESSION['old'] =[
        "fullname"=> $fullname,
        "email"=> $email,
    ];
    echo"<meta http-equiv='refresh' content='1;url=register.php'>";
}
//JIka tidak ada error disetiap input simpan data register ke table users
if(empty($error)){
    //Mengubah Password yang diinputkan menjadi random 255 karakter
    $hash_password= password_hash($password,PASSWORD_DEFAULT);
    
$query="INSERT INTO users(fullname, email,password) VALUES ('$fullname','$email','$password')";
if(mysqli_query($con,$query)){
    echo"<meta http-equiv='refresh' content='1;url=login.php'>";
}else{
    echo"Error:" .mysqli_error($con);
}
}
}
