CREATE DATABASE sales_commission;

USE sales_commission;

CREATE TABLE sales_data (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    month VARCHAR(20),
    sales_amount DECIMAL(10, 2),
    commission DECIMAL(10, 2)
);
