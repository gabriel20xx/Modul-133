USE m133;
CREATE TABLE users (
    uuid char(36) NOT NULL,
    username varchar(20),
    email varchar(50),
    password varchar(200),
    salt varchar(50),
    PRIMARY KEY (uuid)
);

CREATE TABLE blogs (
    uuid char(36) NOT NULL,
    title varchar(50),
    description varchar(2000),
    category varchar(30),
    createdAt datetime,
    user_uuid char(36),
    PRIMARY KEY (uuid),
    FOREIGN KEY (user_uuid) REFERENCES users(uuid) 
    FOREIGN KEY (category) REFERENCES categories(name)
);


CREATE TABLE comments ( 
    uuid char(36) NOT NULL,
    description varchar(2000),
    createdAt datetime,
    blog_uuid char(36),
    user_uuid char(36),
    PRIMARY KEY (uuid),
    FOREIGN KEY (blog_uuid) REFERENCES blogs(uuid),
    FOREIGN KEY (user_uuid) REFERENCES users(uuid)
);

CREATE TABLE categories (
    id char(36) NOT NULL,
    name varchar(30)
)

INSERT INTO categories (id, name) VALUES
(1, 'home'),
(2, 'drei'),
(3, 'test'),
(4, 'Cornel');
