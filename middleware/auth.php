<?php
const LOGIN_URL = '/pages/auth/login.php';
const HOME_URL = '/pages/books/index.php';
const FORBIDDEN_URL = '/pages/errors/403.php';

function startSession()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

function isLoggedIn()
{
    startSession();

    return isset($_SESSION['user']['id']);
}

function getAuthUser()
{
    startSession();

    return $_SESSION['user'] ?? null;
}

function hasRole(array $roles)
{
    $user = getAuthUser();

    return $user !== null && in_array($user['role'], $roles, true);
}

function requireAuth()
{
    if (!isLoggedIn()) {
        $_SESSION['errors'] = ['login' => "Silakan login terlebih dahulu"];

        header('Location: ' . LOGIN_URL);
        exit;
    }
}

function requireRole(array $roles)
{
    requireAuth();
    if (!hasRole($roles)) {
        header('Location: ' . FORBIDDEN_URL);
        exit;
    }
}

function requireGuest()
{
    if (isLoggedIn()) {
        header('Location: ' . HOME_URL);
        exit;
    }
}