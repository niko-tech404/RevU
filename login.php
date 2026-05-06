<?php
session_start();
include 'connect_db.php';
// ... logica login invariata ...
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .auth-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
        }
        .auth-card {
            background: rgba(28, 28, 30, 0.6);
            backdrop-filter: blur(30px);
            padding: 40px;
            border-radius: 30px;
            border: 0.5px solid rgba(255, 255, 255, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .form-group { margin-bottom: 20px; text-align: left; }
        .form-group label { display: block; margin-bottom: 8px; color: #888; font-size: 13px; }
        .form-group input { 
            width: 100%; 
            padding: 15px; 
            background: rgba(255,255,255,0.05); 
            border: none; 
            border-radius: 12px; 
            color: #fff;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="container auth-wrapper">
        <div class="auth-card">
            <h2 style="margin-bottom: 10px;">Bentornato</h2>
            <p style="color: #888; margin-bottom: 30px;">Accedi al tuo account</p>
            
            <form action="login.php" method="POST">
                <div class="form-group">
                    <label>NICKNAME</label>
                    <input type="text" name="nickname" required>
                </div>
                <div class="form-group">
                    <label>PASSWORD</label>
                    <input type="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 10px;">Accedi</button>
                <a href="signup.php" class="btn btn-secondary" style="width: 100%; margin-top: 10px;">Crea Account</a>
            </form>
        </div>
    </div>
</body>
</html>