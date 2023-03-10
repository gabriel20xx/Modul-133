CREATE TABLE users (
    id int NOT NULL AUTO_INCREMENT,
    uuid NOT NULL char(36),
    username varchar(20),
    email varchar(50),
    password varchar(200),
    PRIMARY KEY (id)
)

CREATE TABLE blogs (
    id int NOT NULL AUTO_INCREMENT,
    uuid NOT NULL char(36),
    title varchar(50),
    description varchar(2000),
    createdAt datetime,
    user_uuid int,
    PRIMARY KEY (id),
    FOREIGN KEY (user_uuid) REFERENCES users(uuid) 
)


CREATE TABLE comments ( 
    id int NOT NULL AUTO_INCREMENT,
    uuid NOT NULL char(36),
    description varchar(2000),
    createdAt datetime,
    blog_uuid int,
    user_uuid int,
    PRIMARY KEY (id),
    FOREIGN KEY (blog_uuid) REFERENCES blogs(uuid),
    FOREIGN KEY (user_uuid) REFERENCES users(uuid)
);