-- lyricTune.artist definition


SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

CREATE SCHEMA IF NOT EXISTS `LyricTune` DEFAULT CHARACTER SET utf8 ; 
-- -----------------------------------------------------
-- Schema test
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema music_site
-- -----------------------------------------------------
USE `LyricTune` ;


DROP table IF EXISTS client_playlist;
DROP table IF EXISTS client_album;
DROP table IF EXISTS client_artist;
DROP table IF EXISTS genre_music;
DROP table IF EXISTS playlist_music;
DROP table IF EXISTS playlist;
DROP table IF EXISTS music;
DROP table IF EXISTS client;
DROP table IF EXISTS album;
DROP table IF EXISTS admin;
DROP table IF EXISTS user;
DROP table IF EXISTS genre;
DROP table IF EXISTS artist;


CREATE TABLE `artist` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `genre` varchar(45) DEFAULT 'Unknown Genre',
  `description` varchar(500) DEFAULT 'No Description',
  `photo_url` varchar(200) DEFAULT 'https://i.ibb.co/xFFfc2N/default-profile-img.jpg',
  `description_photo_url` varchar(200) DEFAULT 'https://i.ibb.co/tXNsJpn/description-default-img.jpg',
  PRIMARY KEY (`id`)
);


-- lyricTune.genre definition

CREATE TABLE `genre` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
); 


-- lyricTune.`user` definition

CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `photo_url` varchar(200) DEFAULT 'https://i.ibb.co/xFFfc2N/default-profile-img.jpg',
  PRIMARY KEY (`id`)
) ;


-- lyricTune.admin definition

CREATE TABLE `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_admin_user1_idx` (`user_id`),
  CONSTRAINT `fk_admin_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ;


-- lyricTune.album definition

CREATE TABLE `album` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `photo_url` varchar(200) DEFAULT 'https://i.ibb.co/kG7GDb7/album-default-img.png',
  `release_date` date DEFAULT '2000/01/01',
  `runtime` int NOT NULL,
  `artist_id` int NOT NULL,
  `description` varchar(500) DEFAULT 'No Description',
  `description_photo_url` varchar(200) DEFAULT 'https://i.ibb.co/tXNsJpn/description-default-img.jpg',
  PRIMARY KEY (`id`),
  KEY `fk_album_artist1_idx` (`artist_id`),
  CONSTRAINT `fk_album_artist1` FOREIGN KEY (`artist_id`) REFERENCES `artist` (`id`)
) ;


-- lyricTune.client definition

CREATE TABLE `client` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `description` varchar(45) DEFAULT 'Hello There',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id_UNIQUE` (`user_id`),
  KEY `fk_client_user_idx` (`user_id`),
  CONSTRAINT `fk_client_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ;


-- lyricTune.client_album definition

CREATE TABLE `client_album` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `client_id` int NOT NULL,
  `album_id` int NOT NULL,
  KEY `fk_client_has_album_album1_idx` (`album_id`),
  KEY `fk_client_has_album_client1_idx` (`client_id`),
  CONSTRAINT `fk_client_has_album_album1` FOREIGN KEY (`album_id`) REFERENCES `album` (`id`),
  CONSTRAINT `fk_client_has_album_client1` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`)
) ;


-- lyricTune.client_artist definition

CREATE TABLE `client_artist` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `client_id` int NOT NULL,
  `artist_id` int NOT NULL,
  KEY `fk_client_has_artist_artist1_idx` (`artist_id`),
  KEY `fk_client_has_artist_client1_idx` (`client_id`),
  CONSTRAINT `fk_client_has_artist_artist1` FOREIGN KEY (`artist_id`) REFERENCES `artist` (`id`),
  CONSTRAINT `fk_client_has_artist_client1` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`)
) ;


-- lyricTune.music definition

CREATE TABLE `music` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `runtime` time NOT NULL,
  `description` varchar(45) DEFAULT 'No Description',
  `composer` varchar(45) DEFAULT 'No Composer',
  `release_date` date DEFAULT '2000/01/01',
  `photo_url` varchar(45) DEFAULT 'https://i.ibb.co/cTNmNM7/song-cover.png',
  `lyrics` varchar(45) DEFAULT 'No Lyrics',
  `status` ENUM('Available', 'Suspended', 'Banned') NOT NULL,
  `url` varchar(45) NOT NULL,
  `album_id` int DEFAULT NULL,
  `artist_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_music_album1_idx` (`album_id`),
  KEY `fk_music_artist1_idx` (`artist_id`),
  CONSTRAINT `fk_music_album1` FOREIGN KEY (`album_id`) REFERENCES `album` (`id`),
  CONSTRAINT `fk_music_artist1` FOREIGN KEY (`artist_id`) REFERENCES `artist` (`id`)
) ;


-- lyricTune.playlist definition

CREATE TABLE `playlist` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `client_id` int NOT NULL,
  `photo_url` varchar(200) DEFAULT 'https://i.ibb.co/G2NyD9B/playlist-default-img.png',
  PRIMARY KEY (`id`),
  KEY `fk_playlist_client1_idx` (`client_id`),
  CONSTRAINT `fk_playlist_client1` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`)
) ;


-- lyricTune.playlist_music definition

CREATE TABLE `playlist_music` (
  `id` int PRIMARY KEY AUTO_INCREMENT,  
  `playlist_id` int NOT NULL,
  `music_id` int NOT NULL,
  KEY `fk_playlist_has_music_music1_idx` (`music_id`),
  KEY `fk_playlist_has_music_playlist1_idx` (`playlist_id`),
  CONSTRAINT `fk_playlist_has_music_music1` FOREIGN KEY (`music_id`) REFERENCES `music` (`id`),
  CONSTRAINT `fk_playlist_has_music_playlist1` FOREIGN KEY (`playlist_id`) REFERENCES `playlist` (`id`)
) ;


-- lyricTune.client_playlist definition

CREATE TABLE `client_playlist` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `client_id` int NOT NULL,
  `playlist_id` int NOT NULL,
  KEY `fk_client_has_playlist_playlist1_idx` (`playlist_id`),
  KEY `fk_client_has_playlist_client1_idx` (`client_id`),
  CONSTRAINT `fk_client_has_playlist_client1` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`),
  CONSTRAINT `fk_client_has_playlist_playlist1` FOREIGN KEY (`playlist_id`) REFERENCES `playlist` (`id`)
) ;


-- lyricTune.genre_music definition

CREATE TABLE `genre_music` (
  `id` int PRIMARY KEY AUTO_INCREMENT,   
  `genre_id` int NOT NULL,
  `music_id` int NOT NULL,
  KEY `fk_genre_has_music_music1_idx` (`music_id`),
  KEY `fk_genre_has_music_genre1_idx` (`genre_id`),
  CONSTRAINT `fk_genre_has_music_genre1` FOREIGN KEY (`genre_id`) REFERENCES `genre` (`id`),
  CONSTRAINT `fk_genre_has_music_music1` FOREIGN KEY (`music_id`) REFERENCES `music` (`id`)
) ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
