--建库
CREATE DATABASE  myapi;
CHARACTER SET 'utf8';
COLLATE 'utf8_general_ci';

--城市表
Create table city(
	id int auto_increment not null primary key, 
	name varchar(50) not null
)CHARSET=utf8;

--景点表
Create table places(
	id int auto_increment not null primary key,
	name varchar(50) not null,
	cityid int not null,
	postion varchar(20),
	excerpt longtext,
	description longtext,
	sortid int not null,
	headimg varchar(100),
	FOREIGN KEY (cityid) REFERENCES city(id),
	FOREIGN KEY (sortid) REFERENCES sort(id)
)CHARSET=utf8;

--景点分类表
Create table sort(
	id int auto_increment not null primary key,
	name varchar(50) not null
)CHARSET=utf8;