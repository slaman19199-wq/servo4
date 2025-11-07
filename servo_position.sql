-- إنشاء قاعدة بيانات خاصة بالسيرفو
CREATE DATABASE IF NOT EXISTS servo_control;

-- استخدام قاعدة البيانات
USE servo_control;

-- إنشاء جدول لتخزين زوايا 4 سيرفو
CREATE TABLE IF NOT EXISTS servo_angles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    servo1_angle INT NOT NULL,
    servo2_angle INT NOT NULL,
    servo3_angle INT NOT NULL,
    servo4_angle INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);