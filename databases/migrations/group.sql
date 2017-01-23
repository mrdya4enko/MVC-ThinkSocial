ALTER TABLE ts.roles MODIFY name VARCHAR(45) NOT NULL UNIQUE;
insert into ts.roles (name) values
	(unknown),(groupOwner),(groupSubscriber);
