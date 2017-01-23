ALTER TABLE ts.roles MODIFY name VARCHAR(45) NOT NULL UNIQUE;
insert into ts.roles (name) values
	('unknown'),('groupOwner'),('groupSubscriber');
ALTER TABLE ts.users_groups ADD role_id int(11) NOT NULL DEFAULT '2';
ALTER TABLE ts.users_groups ADD status enum('active','block','delete') DEFAULT 'active';

