use webInvites;

INSERT INTO `users` (`username`, `password`, `first_name`, `last_name`, `email`, `specification`, `year`, `academical_number`, `role`)
      VALUES('sheki', '5f4dcc3b5aa765d61d8327deb882cf99', 'Айше', 'Джинджи', 'adzh2100@abv.bg', 'СИ', 3, 62470, 'student');

INSERT INTO `users` (`username`, `password`, `first_name`, `last_name`, `email`, `specification`, `year`, `academical_number`, `role`)
      VALUES('angel_marinski', '5f4dcc3b5aa765d61d8327deb882cf99', 'Aнгел', 'Марински', 'angel@abv.bg', 'СИ', 3, 62469, 'student');

INSERT INTO `users` (`username`, `password`, `first_name`, `last_name`, `email`, `specification`, `year`, `academical_number`, `role`)
      VALUES('stoilow', '5f4dcc3b5aa765d61d8327deb882cf99', 'Aлександър', 'Стоилов', 'alex@abv.bg', 'СИ', 3, 62382, 'student');

INSERT INTO `users` (`username`, `password`, `first_name`, `last_name`, `email`, `specification`, `year`, `academical_number`, `role`)
      VALUES('gsabev', '5f4dcc3b5aa765d61d8327deb882cf99', 'Георги', 'Събев', 'sabev@abv.bg', 'СИ', 3, 62380, 'student');

INSERT INTO `invitations` (`user_id`, `presentation_theme`, `date`, `time`, `description`)
      VALUES(2, 'CSS Grid', '2022-06-22', '10:30', 'Ще бъде много яко');

INSERT INTO `invitations` (`user_id`, `presentation_theme`, `date`, `time`, `description`)
      VALUES(1, 'WebSocket в PHP', '2022-06-22', '09:30', 'Чакам ви!');

INSERT INTO `invitations` (`user_id`, `presentation_theme`, `date`, `time`, `description`)
      VALUES(3, 'Object Oriented CSS (OOCSS)', '2022-06-22', '12:30', 'Най-добрия реферат до сега!');

INSERT INTO `invitations` (`user_id`, `presentation_theme`, `date`, `time`, `description`)
      VALUES(4, 'Javascript Lint', '2022-06-21', '10:30', 'Toва не го знаете, обещавам!');
