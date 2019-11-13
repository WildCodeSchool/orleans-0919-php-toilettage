

CREATE DATABASE toilettage_seduction;

​

USE toilettage_seduction;

​

CREATE TABLE animal (id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, name VARCHAR(100));

​

CREATE TABLE category (id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, name VARCHAR(100), animal_id INT, CONSTRAINT fk_animal_id FOREIGN KEY (animal_id) REFERENCES animal(id));

​

CREATE TABLE race (id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, name VARCHAR(100), price FLOAT, category_id INT, CONSTRAINT fk_category_id FOREIGN KEY (category_id) REFERENCES category(id));

​
CREATE TABLE advice (id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, name VARCHAR(100), description TEXT, race_id INT, CONSTRAINT fk_race_id FOREIGN KEY (race_id) REFERENCES race(id));


​

INSERT INTO animal (name) 

VALUES ('Chien'), ('Chat');

​

​

INSERT INTO category (name, animal_id) 

VALUES ('Tibétains', 1), ('Caniches', 1), ('Terriers', 1);

​

INSERT INTO race (name, price, category_id) 

VALUES ('Shih-tzu', 35, 1), ('Lhassa Apso', 35, 1), ('Caniche Nain', 35, 2), ('Caniche Cordés', 80, 2), ('Caniche Toy', 30, 2), ('Yorkshire', 30, 3), ('Teckel', 40, 3), ('Jack Russell', 40, 3);

​


