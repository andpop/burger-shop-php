CREATE TABLE users
(
    id int(5) PRIMARY KEY AUTO_INCREMENT,
    email char(60) NOT NULL,
    name char(80),
    phone char(20)
);
CREATE UNIQUE INDEX users_email_uindex ON users (email);
