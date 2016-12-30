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

insert into friends (user_sender, user_receiver) values (4,5);

insert into users_cities (user_id, city_id) values (5,2), (4,1), (6,3);

insert into friends (user_sender, user_receiver) values (6,5);


