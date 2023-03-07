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