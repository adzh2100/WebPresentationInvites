<<<<<<< HEAD
use webInvites;

INSERT INTO `users` (`username`, `password`, `first_name`, `last_name`, `email`, `specification`, `year`, `faculty_number`)
      VALUES('adzh', 'pass123', 'Ayshe', 'Dzhindzhi', 'adzh21@abv.bg', 'СИ', 3, 62470);

INSERT INTO `invitations` (`user_id`, `presentation_theme`, `date`, `time`, `description`)
      VALUES(1, 'CSS Grid', '2022-06-22', '22:30', 'Ще бъде много яко');

=======
use webInvites;

INSERT INTO `users` (`username`, `password`, `first_name`, `last_name`, `email`, `specification`, `year`, `academical_number`, `role`)
      VALUES('adzh', 'pass123', 'Ayshe', 'Dzhindzhi', 'adzh21@abv.bg', 'СИ', 3, 62470, 'student');

INSERT INTO `invitations` (`user_id`, `presentation_theme`, `date`, `time`, `description`)
      VALUES(1, 'CSS Grid', '2022-06-22', '22:30', 'Ще бъде много яко');

>>>>>>> main
