USE m133;

CREATE TABLE categories (
    id int NOT NULL,
    name varchar(30),
    PRIMARY KEY (id)
);

INSERT INTO categories (id, name) VALUES
(1, 'home'),
(2, 'drei'),
(3, 'test'),
(4, 'Cornel');