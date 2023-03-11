CREATE DATABASE photo_platform;

USE photo_platform;

CREATE TABLE users(
    User_ID int AUTO_INCREMENT NOT NULL,
    First_Name varchar(100),
    Last_Name varchar(100),
    Email varchar(100),
    Username varchar(100),
    Password varchar(255),
    Cover_Photo varchar(255),
    PRIMARY KEY(User_ID)
);

CREATE TABLE photos(
    Photo_ID int AUTO_INCREMENT NOT NULL,
    Username varchar(30),
    Image_Name varchar(100),
    Image_Size float,
    Image_Width int,
    Image_Height int,
    Views int, 
    Downloads int,
    Photo_Location varchar(150),
    Photo_Posted date,
    Category varchar(50),
    Editing_Software varchar(50),
    PRIMARY KEY(Photo_ID)
);

CREATE TABLE comments(
    Comment_ID int AUTO_INCREMENT NOT NULL,
    Photo_ID int,
    User_commented varchar(100),
    Comment_Posted datetime,
    Comment varchar(1000),
    PRIMARY KEY(Comment_ID)
);

CREATE TABLE followers(
    Following_ID int AUTO_INCREMENT NOT NULL,
    Followed varchar(100),
    Follower varchar(100),
    PRIMARY KEY(Following_ID)
);

CREATE TABLE image_id(
    ID int AUTO_INCREMENT NOT NULL,
    Image_Counter int,
    PRIMARY KEY(ID)
);
INSERT INTO image_id(Image_Counter) VALUES (1);
CREATE TABLE admin(
    Admin_ID int AUTO_INCREMENT NOT NULL,
    Admin_Email varchar(100),
    Admin_Password varchar(100),
    PRIMARY KEY(Admin_ID)
);
INSERT INTO admin(Admin_Email, Admin_Password) VALUES ("aljaz.loncaric2@gmail.com", "adminlahkospreminjaostalipane14");