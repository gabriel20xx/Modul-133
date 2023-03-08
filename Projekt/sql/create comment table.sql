CREATE TABLE users (
    id int NOT NULL AUTO_INCREMENT,
    username varchar(20),
    email varchar(50),
    password varchar(200),
    PRIMARY KEY (id)
)

CREATE TABLE blogs (
    id int NOT NULL AUTO_INCREMENT,
    title varchar(50),
    description varchar(2000),
    createdAt datetime,
    user_id int,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users(id) 
)


CREATE TABLE comments ( 
    id int NOT NULL AUTO_INCREMENT,
    blog_id int,
    description varchar(2000),
    createdAt datetime,
    user_id int,
    PRIMARY KEY (id),
    FOREIGN KEY (blog_id) REFERENCES blogs(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);