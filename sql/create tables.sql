USE m133;

CREATE TABLE users (
    uuid CHAR(36) NOT NULL,
    username VARCHAR(20),
    email VARCHAR(50),
    password VARCHAR(200),
    salt VARCHAR(50),
    PRIMARY KEY (uuid)
);

CREATE TABLE categories (
    id CHAR(36) NOT NULL,
    name VARCHAR(30),
    PRIMARY KEY (id)
);

CREATE TABLE blogs (
    uuid CHAR(36) NOT NULL,
    title VARCHAR(50),
    description VARCHAR(2000),
    category_id CHAR(36),
    createdAt DATETIME,
    user_uuid CHAR(36),
    PRIMARY KEY (uuid),
    FOREIGN KEY (user_uuid) REFERENCES users(uuid),
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

CREATE TABLE comments ( 
    uuid CHAR(36) NOT NULL,
    description VARCHAR(2000),
    createdAt DATETIME,
    blog_uuid CHAR(36),
    user_uuid CHAR(36),
    PRIMARY KEY (uuid),
    FOREIGN KEY (blog_uuid) REFERENCES blogs(uuid),
    FOREIGN KEY (user_uuid) REFERENCES users(uuid)
);

INSERT INTO categories (id, name) VALUES
('1', 'home'),
('2', 'drei'),
('3', 'test'),
('4', 'Cornel');