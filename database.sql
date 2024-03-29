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


create table group_chat(
	id int primary key auto_increment,
    name varchar(255) not null unique
);


DELIMITER //

create procedure `get_group` (in namex varchar(255), out can_create tinyint)
begin
	declare chat_exist int default 0;
    
	select count(name) into chat_exist from group_chat where name = namex;
    
    if chat_exist = 0
    then
		set can_create = 1;
	else
		set can_create = 0;
	end if;
end //

DELIMITER ;


create table message(
	id int primary key auto_increment,
    message varchar(255) not null,
    group_id int,
    foreign key (group_id) references group_chat(id),
    user_id int,
    foreign key (user_id) references users(id)
);


DELIMITER //

CREATE PROCEDURE insert_message(
    IN message_text VARCHAR(255),
    IN group_name VARCHAR(255),
    IN user_name VARCHAR(255)
)
BEGIN
    DECLARE group_id_val INT;
    DECLARE user_id_val INT;

    -- Get group_id based on group_name
    SELECT id INTO group_id_val FROM group_chat WHERE name = group_name;

    -- Get user_id based on user_name
    SELECT id INTO user_id_val FROM users WHERE name = user_name;

    -- Insert the message
    INSERT INTO message (message, group_id, user_id)
    VALUES (message_text, group_id_val, user_id_val);

END //

DELIMITER ;
