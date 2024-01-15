create database chat;
use chat;

create table users(
	id int primary key auto_increment,
    name varchar(255) not null unique,
	password varchar(255) not null check(length(password) > 5),
    email varchar(255) not null unique check(email like '%@%')
);

DELIMITER //

create procedure `add_user` (in namex varchar(20), in emailx varchar(200), in passwordx varchar(255), out success tinyint)
begin
	declare exist int default 0;
    
    select count(id) into exist from users where namex = name or emailx = email;
    
    if exist = 0
    then
		insert into users(name, email, password)
			values
				(namex, emailx, passwordx);

		set success = 1;
	else
		set success = 0;
	end if;
end //

DELIMITER ;


DELIMITER //

create procedure `get_hash` (in emailx varchar(200), out hashx varchar(255))
begin
	select password into hashx from users where email = emailx;
end //

DELIMITER ;

select * from users;
