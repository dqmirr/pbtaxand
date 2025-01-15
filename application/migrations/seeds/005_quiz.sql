INSERT INTO `group_quiz` (`code`) VALUES
('akademis');

INSERT INTO `quiz` (`code`, `label`, `description`, `library_code`, `group_quiz_code`, `active`) VALUES
('accounting', 'Accounting', 'Test untuk akuntansi', 'multiplechoice', NULL, 1),
('auditing', 'Auditing', 'Test untuk Auditing', 'multiplechoice', NULL, 1),
('english', 'English', 'Test untuk Bahasa Inggris', 'multiplechoice', NULL, 1),
('akademis', 'Akademis', 'Test gabungan, Accounting, Auditing, dan Bahasa Inggris', NULL, 'akademis', 1);

INSERT INTO `group_quiz_items` (`group_quiz_code`, `quiz_code`) VALUES
('akademis', 'accounting'),
('akademis', 'auditing');
