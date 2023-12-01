use lyricTune;
SET SQL_SAFE_UPDATES = 0;

delete from client_album;
delete from client_artist;
delete from client_playlist;
delete from genre_music;
delete from playlist_music;
delete from playlist;
delete from genre;
delete from music;
delete from album;
delete from artist;
delete from client;
delete from admin;
delete from user;

ALTER TABLE user AUTO_INCREMENT = 1;
ALTER TABLE admin AUTO_INCREMENT = 1;
ALTER TABLE client AUTO_INCREMENT = 1;
ALTER TABLE artist AUTO_INCREMENT = 1;
ALTER TABLE album AUTO_INCREMENT = 1;
ALTER TABLE music AUTO_INCREMENT = 1;
ALTER TABLE genre AUTO_INCREMENT = 1;
ALTER TABLE playlist AUTO_INCREMENT = 1;
ALTER TABLE playlist_music AUTO_INCREMENT = 1;
ALTER TABLE genre_music AUTO_INCREMENT = 1;
ALTER TABLE client_playlist AUTO_INCREMENT = 1;
ALTER TABLE client_artist AUTO_INCREMENT = 1;
ALTER TABLE client_album AUTO_INCREMENT = 1;

insert into user(name, email, password,photo_url) values("Jose Tavares","jose@gmail.com","jomabata","https://i.ibb.co/Sxzy0gJ/370220406-1798779677235042-7349493873271545530-n.jpg");

insert into user(name, email, password) values("Armando Silva","armando@gmail.com","armando");


insert into client(user_id,description)values(1,"Music Lover");

insert into admin(user_id)values(2);

insert into playlist(name, client_id) values ("my playlist", 1);



insert into artist(name, genre, description, photo_url, description_photo_url) values ("The Strokes", "Rock","American rock band formed in New York City in 1998. The band is composed of lead singer and primary songwriter Julian Casablancas, guitarists Nick Valensi and Albert Hammond Jr., bassist Nikolai Fraiture, and drummer Fabrizio Moretti.","https://i.ibb.co/m4Wd99v/strokes-profile-img.jpg","https://i.ibb.co/LPjFDtd/strokes-description-img.webp");
insert into artist(name, genre, description) values ("Tyla", "R&B","Singer from South Africa");

insert into album(name, photo_url, release_date, runtime, artist_id, description, description_photo_url) values("The New Abnormal","https://i.ibb.co/RBHjJRw/strokes-album6.jpg",'2020/04/10',45,1,"The New Abnormal is the sixth studio album by American rock band the Strokes, released on April 10, 2020, through Cult and RCA Records.","https://i.ibb.co/bNC461Y/The-New-Abnormal-The-Strokes.webp");
insert into album(name, photo_url, release_date, runtime, artist_id, description, description_photo_url) values("Lover Boy","https://i.ibb.co/RBHjJRw/strokes-album6.jpg",'2020/04/10',45,1,"The New Abnormal is the sixth studio album by American rock band the Strokes, released on April 10, 2020, through Cult and RCA Records.","https://i.ibb.co/bNC461Y/The-New-Abnormal-The-Strokes.webp");
INSERT INTO music (`name`,`runtime`,`description`,`composer`,`release_date`,`photo_url`,`lyrics`,`status`,`url`,`album_id`,`artist_id`) VALUES ('Water','00:04:30','A great song','John Doe','2023-01-01','https://example.com/song-cover.jpg','These are the lyrics','Available','https://example.com/song-url',null,2);

insert into client_artist(client_id, artist_id) values(1,1);
insert into client_album(client_id, album_id) values(1,1);
select * from music
