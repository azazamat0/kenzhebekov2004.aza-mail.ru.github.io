-- Создание базы данных
CREATE DATABASE IF NOT EXISTS aza CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Создание пользователя
CREATE USER 'your_username'@'localhost' IDENTIFIED BY 'your_password';

-- Предоставление пользователю прав доступа к базе данных
GRANT ALL PRIVILEGES ON your_database.* TO 'your_username'@'localhost';