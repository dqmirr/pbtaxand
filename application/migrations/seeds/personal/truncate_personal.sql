set foreign_key_checks = 0;
truncate table personal_jawaban;
truncate table personal_questions;
delete from users_quiz_log where quiz_code in ('hexaco','d3ad','cti');
set foreign_key_checks = 1;
