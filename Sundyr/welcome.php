<?php
        session_start();

        // Проверяем, залогинен ли пользователь
        if (isset($_SESSION['username'])) {
            $username = $_SESSION['username'];
            echo "<p>Привет, $username!</p>";
        } else {
            // Если пользователь не авторизован, перенаправляем на страницу входа
            header('Location: login.php');
            exit();
        }
        ?>