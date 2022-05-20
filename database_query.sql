/* Criação, caso não exista, e uso do banco de dados */
create database if not exists `moviews`;
use `moviews`;

/* Remoção das tabelas, caso exista, resetando os dados */
drop table if exists `moviews`.`reviews`;
drop table if exists `moviews`.`movies`;
drop table if exists `moviews`.`categories`;
drop table if exists `moviews`.`users`;

/* Criação da tabela usuários */
create table `moviews`.`users` (
	`use_id` int unsigned not null auto_increment,
	`use_name` varchar(100) not null,
	`use_lastname` varchar(100) null,
	`use_email` varchar(100) not null,
	`use_password` varchar(200) not null,
	`use_image` varchar(200) null,
	`use_bio` text null,
	`use_token` varchar(200) null,
	primary key (`use_id`)
) engine = InnoDB;

/* Criação da tabela categorias */
create table `moviews`.`categories` (
	`cat_id` int unsigned not null auto_increment,
	`cat_genre` varchar(100) not null,
	primary key (`cat_id`)
) engine = InnoDB;

/* Inserção de dados na tabela categorias */
insert into `moviews`.`categories` (cat_genre) values ('Ação'), ('Drama'), ('Comédia'), ('Ficção científica'), ('Romance');

/* Criação da tabela filmes */
create table `moviews`.`movies` (
	`mov_id` int unsigned not null auto_increment,
	`mov_title` varchar(100) not null,
	`mov_description` text not null,
	`mov_image` varchar(200) null,
	`mov_trailer` varchar(100) null,
	`mov_length` int null,
	`use_id` int unsigned not null,
	`cat_id` int unsigned not null,
	primary key (`mov_id`),
	index `fk_movies_users1_idx` (`use_id` asc),
	index `fk_movies_categories1_idx` (`cat_id` asc),
	constraint `fk_movies_users1`
		foreign key (`use_id`)
		references `moviews`.`users` (`use_id`)
		on delete no action
		on update no action,
	constraint `fk_movies_categories1`
		foreign key (`cat_id`)
		references `moviews`.`categories` (`cat_id`)
		on delete no action
		on update no action
) engine = InnoDB;

/* Criação da tabela avaliações */
create table `moviews`.`reviews` (
	`rev_id` int unsigned not null auto_increment,
	`rev_rating` int not null,
	`rev_review` text not null,
	`use_id` int unsigned not null,
	`mov_id` int unsigned not null,
	primary key (`rev_id`),
	index `fk_reviews_users1_idx` (`use_id` asc),
	index `fk_reviews_movies1_idx` (`mov_id` asc),
	constraint `fk_reviews_users1`
		foreign key (`use_id`)
		references `moviews`.`users` (`use_id`)
		on delete no action
		on update no action,
	constraint `fk_reviews_movies1`
		foreign key (`mov_id`)
		references `moviews`.`movies` (`mov_id`)
		on delete no action
		on update no action
) engine = InnoDB;