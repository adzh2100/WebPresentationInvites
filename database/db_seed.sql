use webInvites;


INSERT INTO `users` (`username`, `password`, `first_name`, `last_name`, `email`, `specification`, `year`, `academical_number`, `role`)
      VALUES('sheki', '5f4dcc3b5aa765d61d8327deb882cf99', 'Айше', 'Джинджи', 'adzh2100@gmail.com', 'СИ', 3, 62470, 'student');

INSERT INTO `users` (`username`, `password`, `first_name`, `last_name`, `email`, `specification`, `year`, `academical_number`, `role`)
      VALUES('angel_marinski', '5f4dcc3b5aa765d61d8327deb882cf99', 'Aнгел', 'Марински', 'angel@abv.bg', 'СИ', 3, 62469, 'student');

INSERT INTO `users` (`username`, `password`, `first_name`, `last_name`, `email`, `specification`, `year`, `academical_number`, `role`)
      VALUES('stoilow', '5f4dcc3b5aa765d61d8327deb882cf99', 'Aлександър', 'Стоилов', 'alex@abv.bg', 'СИ', 3, 62382, 'student');

INSERT INTO `users` (`username`, `password`, `first_name`, `last_name`, `email`, `specification`, `year`, `academical_number`, `role`)
      VALUES('gsabev', '5f4dcc3b5aa765d61d8327deb882cf99', 'Георги', 'Събев', 'sabev@abv.bg', 'СИ', 3, 62380, 'student');

INSERT INTO `invitations` (`user_id`, `presentation_theme`, `date`, `time`, `description`, `auto_generated`)
      VALUES(2, 'CSS Grid', '2022-06-22', '10:30', 'Ще бъде много яко', 0);

INSERT INTO `invitations` (`user_id`, `presentation_theme`, `date`, `time`, `description`, `auto_generated`)
      VALUES(1, 'WebSocket в PHP', '2022-06-22', '09:30', 'Чакам ви!', 0);

INSERT INTO `invitations` (`user_id`, `presentation_theme`, `date`, `time`, `description`, `auto_generated`)
      VALUES(3, 'Object Oriented CSS (OOCSS)', '2022-06-22', '12:30', 'Най-добрия реферат до сега!', 0);

INSERT INTO `invitations` (`user_id`, `presentation_theme`, `date`, `time`, `description`, `auto_generated`)
      VALUES(4, 'Javascript Lint', '2022-06-21', '10:30', 'Toва не го знаете, обещавам!', 0);

INSERT INTO `users` (`username`, `password`, `first_name`, `last_name`, `email`, `academical_number`, `role`)
      VALUES('milen_petrov', '5f4dcc3b5aa765d61d8327deb882cf99', 'Милен', 'Петров', 'milen.petrov@gmail.com', 62470512, 'teacher');

INSERT INTO `users` (`username`, `password`, `first_name`, `last_name`, `email`, `specification`, `year`, `academical_number`, `role`)
      VALUES('murzelqvec123', '5f4dcc3b5aa765d61d8327deb882cf99', 'Мързелан', 'Иванов', 'murzelan.ivanov@gmail.com','СИ', 3, 62422, 'student');

INSERT INTO `users` (`username`, `password`, `first_name`, `last_name`, `email`, `specification`, `year`, `academical_number`, `role`)
      VALUES('marincho123', '5f4dcc3b5aa765d61d8327deb882cf99', 'Мартин', 'Христов', 'martincho@gmail.com','СИ', 3, 62423, 'student');

INSERT INTO `users` (`username`, `password`, `first_name`, `last_name`, `email`, `specification`, `year`, `academical_number`, `role`)
      VALUES('kukata', '5f4dcc3b5aa765d61d8327deb882cf99', 'Росен', 'Гацов', 'kukatawee2000@gmail.com','СИ', 3, 62444, 'student');