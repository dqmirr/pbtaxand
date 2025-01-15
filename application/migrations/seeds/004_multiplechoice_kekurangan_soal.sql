INSERT INTO multiplechoice_question (jenis_soal,sulit,nomor,question,parent_nomor,multiplechoice_img_code,jawaban) VALUES 
('accounting',2.33,40,'Laba bersih akan dihasilkan dalam suatu periode jika:',NULL,NULL,'A')
,('auditing',0.39,40,'Jasa asurans lainnya yang dapat diberikan oleh akuntan publik berupa perikatan asurans selain jasa audit atau reviu atas informasi keuangan historis adalah:',NULL,NULL,'D')
,('english',-1.83,50,'The bus will leave promptly  _____________  08.30.',NULL,NULL,'C')
;

INSERT INTO multiplechoice_choices (multiplechoice_question_id,choice,label) VALUES 
(128,'A','Aset melebihi liabilitas')
,(128,'B','Aset melebihi pendapatan')
;

INSERT INTO multiplechoice_choices (multiplechoice_question_id,choice,label) VALUES 
(128,'C','Beban melebihi pendapatan')
,(128,'D','Pendapatan melebihi beban')
,(129,'A','Evaluasi atas efektivitas pengendalian internal')
,(129,'B','Jasa internal audit')
,(129,'C','Jasa perpajakan')
,(129,'D','Jasa kompilasi laporan keuangan')
,(130,'A','until')
,(130,'B',' to')
,(130,'C','at')
,(130,'D','for')
;
