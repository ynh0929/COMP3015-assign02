create database article_aggregator_co;
use article_aggregator_co;

create table users (sch
   id int auto_increment not null primary key,
   password_digest varchar(255),
   email varchar(255) not null unique,
   name varchar(255) not null,
   description varchar(512) null,
   profile_picture varchar(255) default 'default.jpg'
);

create table articles (
   id int auto_increment not null primary key,
   title varchar(255) not null,
   url varchar(255) not null,
   created_at datetime not null,
   updated_at datetime,
   author_id int not null,
   foreign key (author_id) references users (id)
);
