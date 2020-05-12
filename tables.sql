-- create table Users(
--
-- 	uid SERIAL,
-- 	firstName VARCHAR(30) NOT NULL,
-- 	lastName VARCHAR(30) NOT NULL,
-- 	address VARCHAR(50) NOT NULL,
-- 	email VARCHAR(50) NOT NULL,
-- 	password VARCHAR(20) NOT NULL,
-- 	PRIMARY KEY(uid)
-- );

create table Course(

	cid SERIAL,
	name VARCHAR(50) NOT NULL,
	description VARCHAR(4000) NOT NULL,
	credits DECIMAL (6,1),
	fee DECIMAL (6,2),
	PRIMARY KEY(cid)
);

-- create table Registration(
--
-- 	rid SERIAL,
-- 	semester VARCHAR(20) NOT NULL,
-- 	grade CHAR(2),
-- 	uid INT(10) REFERENCES User,
-- 	cid INT(10) REFERENCES Course,
-- 	PRIMARY KEY(rid)
-- );