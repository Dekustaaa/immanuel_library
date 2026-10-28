<?php
require_once __DIR__ . "/../repositories/user-repository.php";
function getRegisterRequest($request)
{
    return [
        'name' => trim(htmlspecialchars($request['name'])),
        'email' => trim(htmlspecialchars($request['email'])),
        'password' => $request['password'],
        'password_confirmation' => $request['password_confirmation'],
    ];
}

function validateRegister($request)
{
    $errors = [];
    
    if ($request['name'] === '') {
        $errors['name'] = "Nama lengkap wajib diisi";
    } elseif (mb_strlen($request['name']) > 150) {
        $errors['name'] = "Nama lengkap tidak boleh melebihi dari 150 karakter";
    }
    if ($request['email'] === '') {
        $errors['email'] = "Email wajib diisi";
    } elseif (mb_strlen($request['email']) > 150) {
        $errors['email'] = "Email tidak boleh melebihi dari 150 karakter";
    } elseif (!filter_var($request['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Email yang dikirimkan tidak valid";
    } elseif (isEmailTaken($request['email'])) {
        $errors['email'] = "Email sudah didaftarkan sebelumnya";
    }
    if ($request['password'] === '') {
        $errors['password'] = "Kata sandi wajib diisi";
    } elseif (mb_strlen($request['password']) < 8) {
        $errors['password'] = "Kata sandi tidak boleh kurang dari 8 karakter";
    }
    if ($request['password_confirmation'] === '') {
        $errors['password_confirmation'] = "Kata sandi wajib diisi";
    } elseif (mb_strlen($request['password_confirmation']) < 8) {
        $errors['password_confirmation'] = "Kata sandi tidak boleh kurang dari 8 karakter";
    } elseif ($request['password'] != $request['password_confirmation']) {
        $errors['password_confirmation'] = "Kata sandi yang dimasukan tidak cocok";
    }
    return $errors;
}

function getLoginRequest($request)
{
    return [
        'email' => $request['email'],
        'password' => $request['password']
    ];
}

function validateLogin($request)
{
    $errors = [];
    if ($request['email'] === '') {
        $errors['email'] = "Email wajib diisi";
    }
    if ($request['password'] === '') {
        $errors['password'] = "Kata sandi wajib diisi";
    }
    return $errors;
}

?>