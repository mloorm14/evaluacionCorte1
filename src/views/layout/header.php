<?php declare(strict_types=1); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Materias - UTEQ</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f6f9; color: #333; margin: 0; padding: 20px; }
        .container { max-width: 900px; background: #fff; margin: 0 auto; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        h1, h2 { color: #005a36; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #005a36; color: white; }
        .btn { display: inline-block; padding: 8px 12px; color: white; background: #005a36; text-decoration: none; border-radius: 4px; border: none; cursor: pointer; }
        .btn-danger { background: #b22222; }
        .btn-secondary { background: #6c757d; }
        .alert { background: #f8d7da; color: #721c24; padding: 10px; border-radius: 4px; margin-bottom: 15px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input, .form-group select { width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        .nav-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 2px solid #005a36; padding-bottom: 10px; }
        .inline-form { display: inline; }
    </style>
</head>
<body>
<div class="container">
