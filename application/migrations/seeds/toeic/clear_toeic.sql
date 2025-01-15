truncate table multiplechoice_story;
delete from multiplechoice_jawaban where jenis_soal = 'toeic';
delete from multiplechoice_choices where multiplechoice_question_id in (select id from multiplechoice_question where jenis_soal = 'toeic');
delete from multiplechoice_question where jenis_soal = 'toeic';
