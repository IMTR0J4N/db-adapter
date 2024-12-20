-- Création de la base de données
CREATE DATABASE IF NOT EXISTS ? CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Sélection de la base de données
USE ?;

-- Création de la table `customers` (doit être créée avant `contracts` car elle est référencée)
CREATE TABLE IF NOT EXISTS `customers` (
    `id` VARCHAR(13) PRIMARY KEY,
    `firstname` VARCHAR(255) NOT NULL,
    `lastname` VARCHAR(255) NOT NULL,
    `adress` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `driver_license_number` VARCHAR(255) NOT NULL UNIQUE
) ENGINE=InnoDB;

-- Création de la table `vehicles` (doit être créée avant `contracts` car elle est référencée)
CREATE TABLE IF NOT EXISTS `vehicles` (
    `id` VARCHAR(13) PRIMARY KEY,
    `model` VARCHAR(255) NOT NULL,
    `brand` VARCHAR(255) NOT NULL,
    `license_plate` VARCHAR(255) NOT NULL UNIQUE,
    `informations` TEXT NOT NULL,
    `km` DECIMAL(10, 2) NOT NULL
) ENGINE=InnoDB;

-- Création de la table `contracts` avec les contraintes de clés étrangères
CREATE TABLE IF NOT EXISTS `contracts` (
    `id` VARCHAR(13) PRIMARY KEY,
    `vehicle_id` VARCHAR(13) NOT NULL,
    `customer_id` VARCHAR(13) NOT NULL,
    `sign_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `begin_at` TIMESTAMP NOT NULL,
    `end_at` TIMESTAMP NOT NULL,
    `returning_at` TIMESTAMP NOT NULL,
    `price` DECIMAL(10, 2) NOT NULL,
    -- Définition des clés étrangères
    FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`customer_id`) REFERENCES `customers`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- Création de la table `billings` avec les contraintes de clés étrangères
CREATE TABLE IF NOT EXISTS `billings` (
    `id` VARCHAR(13) PRIMARY KEY,
    `contract_id` VARCHAR(13) NOT NULL,
    `amount` DECIMAL(10, 2) NOT NULL,
    -- Définition de la clé étrangère
    FOREIGN KEY (`contract_id`) REFERENCES `contracts`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;
