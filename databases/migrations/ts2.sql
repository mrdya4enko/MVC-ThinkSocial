use ts;
insert into groups (name, description) values ('Наш сад', 'Группа для любителей садоводства'), 
					('Готовим вкусно', 'Кулинарная группа'), 
                                        ('Вышиваем вместе', 'Группа для истинных любителей художественной вышивки');
insert into users_groups (group_id, user_id) values
			 (1, 5), (2,5), (3, 5);

insert into albums (name) values ('Друзья'), ('Путешествия');
insert into albums_users (user_id, album_id) values (5,6),  (5,7);

insert into albums_photos (album_id, file_name, description) values
	(6, 'Sasha.JPG', 'Мой друг Саша');
insert into albums_photos (album_id, file_name, description) values
	(7, 'mars1.jpg', 'Атмосфера Марса'), (7, 'mars2.jpg', 'Марс');

insert into news (title, text, picture, published) values
	('2030: Высадка китайцев на Марс', 'Вы скажете, что это невозможно? Однако еще 20 лет назад мир и понятия не имел о "китайском чуде"...', 'chinese.jpeg', CURRENT_TIMESTAMP);
insert into news (title, text, picture, published) values
	('1 Сентября - День Знаний', 'Поздравляем всех школьников и студентов, а также их родителей и учителей, бабушек и дедушек, работников транспорта и остальное прогрессивное человечество', 'school_07.jpg', '2016-09-01');
insert into news (title, text, picture, published) values
	('День народження Марко Вовчок', 'Марко́ Вовчо́к (справжнє ім\'я: Марія Олександрівна Вілінська, за першим чоловіком — Маркович, за другим чоловіком — Лобач-Жученко; * 10 (22) грудня 1833, маєток Єкатерининське Єлецького повіту[ru] Орловської губернії, тепер Липецька область РФ — † 28 липня (10 серпня) 1907, Нальчик, Росія) — українська письменниця, перекладачка. Дружина етнографа Опанаса Маркевича (Марковича). Мати публіциста Богдана Марковича. Троюрідна сестра російського літературного критика Д.І.Писарєва.
Була знайома з Тарасом Шевченком, Пантелеймоном Кулішем, Миколою Костомаровим, Іваном Тургенєвим, Олександром Герценом, Жулем Верном. Її твори мали антикріпацьке спрямування. Також описувала історичне минуле України.', 'google_Vovchok.jpg', '2015-12-22');

insert into users_news (news_id, user_id) values (3,5), (4,5), (5,5);

insert into users_avatars (user_id, file_name) values (5, 'red.JPG');
insert into users_avatars (user_id, file_name) values (4, 'zveropolis.jpeg');

insert into users_cities (user_id, city_id) values (5,2), (4,1), (6,3);

insert into comments (user_id, text, published) values
(4, 'Можно с Вами познакомиться?  :)', '2017-01-11 12:33:16'),
(6, 'Просто красотка', '2017-01-11 12:33:16'),
(4, 'Если из полутора миллиардов китайцев построить пирамиду, то она достанет до Марса', '2017-01-11 12:33:16'),
(6, 'Присоединяюсь! Мой сыночек пошел в первый класс', '2017-01-11 12:33:16'),
(6, 'А это что еще за друг?', '2017-01-11 12:33:16');

insert into users_avatars_comments (user_avatar_id, comment_id) values (1, 1), (1, 2);

insert into news_comments (news_id, comment_id) values (3, 3), (4, 4);

insert into albums_photos_comments (comment_id, albums_photos_id) values (5, 1);

DROP TABLE IF EXISTS `friends`;
CREATE TABLE `friends` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_sender` INT(11) NOT NULL,
  `user_receiver` INT(11) NOT NULL,
  `status` enum('applied','unapplied', 'declined') NOT NULL DEFAULT 'unapplied',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_table1_users1_idx` (`user_sender`),
  KEY `fk_table1_users2_idx` (`user_receiver`),
  CONSTRAINT `fk_table1_users1` FOREIGN KEY (`user_sender`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE RESTRICT,
  CONSTRAINT `fk_table1_users2` FOREIGN KEY (`user_receiver`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE  RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE friends ADD UNIQUE KEY sender_receiver (user_sender, user_receiver);

DELIMITER //
CREATE TRIGGER friends_insert
	BEFORE INSERT
    ON friends FOR EACH ROW
BEGIN
	DECLARE row_num INT;
	SELECT COUNT(*) FROM friends
		WHERE user_receiver=NEW.user_sender
			AND user_sender=NEW.user_receiver
		INTO row_num;
	IF row_num>0 THEN
		SIGNAL SQLSTATE '02000' SET message_text="This friendship request already exists";
	END IF;
	IF NEW.user_receiver=NEW.user_sender THEN
		SIGNAL SQLSTATE '02000' SET message_text="It is impossible to be a friend of yourself";
	END IF;
END //
DELIMITER ;

insert into friends (user_sender, user_receiver) values (4,5);

INSERT INTO `friends` (user_sender, user_receiver, status) VALUES (1,2,'applied'),(1,3,'unapplied'),(1,4,'applied'),(5,1,'applied'),(2,3,'applied');

insert into friends (user_sender, user_receiver) values (6,5);

insert into passwords (user_id, password) values (5, '111111');

insert into users_cities (user_id, city_id) values (5, 1);

insert into comments (user_id, text, status, published) values
(4, 'Ненавижу!!!!!', 'block', '2017-01-19 12:33:16'),
(6, 'Тебе что, дура, больше заняться нечем?', 'delete', '2017-01-19 12:33:16');

insert into news_comments (news_id, comment_id) values (3, 6), (3, 7);
