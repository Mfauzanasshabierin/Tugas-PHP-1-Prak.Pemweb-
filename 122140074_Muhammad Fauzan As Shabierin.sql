CREATE DATABASE IF NOT EXISTS data_mahasiswa;

USE data_mahasiswa;

CREATE TABLE IF NOT EXISTS mahasiswa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    nim VARCHAR(15) NOT NULL,
    prodi VARCHAR(100) NOT NULL
);

INSERT INTO mahasiswa (nama, nim, prodi) VALUES
('John Doe', '122140001', 'Teknik Informatika'),
('Jane Smith', '122140002', 'Sistem Informasi'),
('Alice Johnson', '122140003', 'Teknik Elektro'),
('Bob Brown', '122140004', 'Teknik Sipil'),
('Charlie White', '122140005', 'Arsitektur Lanskap'),
('Diana King', '122140006', 'Teknik Mesin'),
('Eve Adams', '122140007', 'Teknik Geomatika'),
('Frank Miller', '122140008', 'Teknik Lingkungan'),
('Grace Lee', '122140009', 'Teknik Industri'),
('Hank Hill', '122140010', 'Teknik Kelautan'),
('Ivy Carter', '122140011', 'Teknik Perkeretaapian'),
('Jake Wilson', '122140012', 'Farmasi');