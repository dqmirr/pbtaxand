
-- Skala Simp Fisik

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya merasa sedih' as `soal`, 1 as `nomor`, 'A' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 1 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya merasa pesimis' as `soal`, 2 as `nomor`, 'A' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 2 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya merasa bersalah' as `soal`, 3 as `nomor`, 'A' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 3 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Berat badan saya naik atau turun' as `soal`, 4 as `nomor`, 'A' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 4 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya mengalami sulit tidur' as `soal`, 5 as `nomor`, 'A' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 5 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya kehilangan energi' as `soal`, 6 as `nomor`, 'A' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 6 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya mudah lelah' as `soal`, 7 as `nomor`, 'A' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 7 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya mengalami keringat yang berlebeih' as `soal`, 8 as `nomor`, 'B' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 8 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Berat badan saya turun' as `soal`, 9 as `nomor`, 'B' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 9 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya suka gemetar' as `soal`, 10 as `nomor`, 'B' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 10 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Otot saya lemah' as `soal`, 11 as `nomor`, 'B' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 11 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya merasa gelisah' as `soal`, 12 as `nomor`, 'B' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 12 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya mudah tempramen (marah)' as `soal`, 13 as `nomor`, 'B' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 13 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Sayatidak tahan dengan udara panas' as `soal`, 14 as `nomor`, 'B' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 14 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya mudah lelah' as `soal`, 15 as `nomor`, 'B' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 15 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Konsentrasi saya lemah' as `soal`, 16 as `nomor`, 'B' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 16 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Menstruasi saya tidak teratur' as `soal`, 17 as `nomor`, 'B' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 17 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Jantung saya berdetak tidak beraturan' as `soal`, 18 as `nomor`, 'B' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 18 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya merasa cemas' as `soal`, 19 as `nomor`, 'B' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 19 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya sangat bersemangat dalam tiga bulan terakhir' as `soal`, 20 as `nomor`, 'C' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 20 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya mudah tersinggung dalam tiga bulan terakhir' as `soal`, 21 as `nomor`, 'C' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 21 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya banyak makan dalam tiga bulan terakhir' as `soal`, 22 as `nomor`, 'C' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 22 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya kurang tidur dalam tiga bulan terakhir' as `soal`, 23 as `nomor`, 'C' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 23 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya melakukan tindakan perilaku beresikoa dalam tiga bulan terakhir ' as `soal`, 24 as `nomor`, 'C' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 24 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya berbicara cepat dalam tiga bulan terakhir' as `soal`, 25 as `nomor`, 'C' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 25 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya sulit membuat keputusan dalam tiga bulan terakhir' as `soal`, 26 as `nomor`, 'C' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 26 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya mendengar suara misterius atau suara-suara dalam tiga bulan terakhir' as `soal`, 27 as `nomor`, 'C' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 27 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya mengalami sedih dalam tiga bulan terakhir' as `soal`, 28 as `nomor`, 'D' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 28 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya merasa kehilangan harapan dalam tiga bulan terakhir' as `soal`, 29 as `nomor`, 'D' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 29 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya malas melakukan sesuatu dalam tiga bulan terakhir' as `soal`, 30 as `nomor`, 'D' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 30 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya merasa minder dalam tiga bulan terakhir' as `soal`, 31 as `nomor`, 'D' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 31 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya sulit berkonsentrasu dalam tiga bulan terakhir' as `soal`, 32 as `nomor`, 'D' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 32 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya berpikir untuk bunuh diri dalam tiga bulan terakhir' as `soal`, 33 as `nomor`, 'D' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 33 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya tidak memiliki motivasi' as `soal`, 34 as `nomor`, 'E' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 34 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Emosi saya terhambat' as `soal`, 35 as `nomor`, 'E' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 35 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya sulit berpikir' as `soal`, 36 as `nomor`, 'E' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 36 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya tidak ingin melakukan aktivitas apa pun' as `soal`, 37 as `nomor`, 'E' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 37 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya tidak ingin berbicara dengan orang lain' as `soal`, 38 as `nomor`, 'E' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 38 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Produksi air liur saya berlebih' as `soal`, 39 as `nomor`, 'F' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 39 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Mulut saya terasa pahit' as `soal`, 40 as `nomor`, 'F' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 40 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya kehilangan nafsu makan' as `soal`, 41 as `nomor`, 'F' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 41 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya mengalami mual' as `soal`, 42 as `nomor`, 'F' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 42 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya mengalami muntah' as `soal`, 43 as `nomor`, 'F' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 43 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Perut saya kembung' as `soal`, 44 as `nomor`, 'F' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 44 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya sering sendawa' as `soal`, 45 as `nomor`, 'F' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 45 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya berkeringat tanpa alasan yang jelas' as `soal`, 46 as `nomor`, 'F' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 46 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Area dada saya terasa panas' as `soal`, 47 as `nomor`, 'F' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 47 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Kepala saya pusing' as `soal`, 48 as `nomor`, 'F' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 48 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saat istirahat saya merasa panas' as `soal`, 49 as `nomor`, 'F' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 49 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saat istirahat saya merasa tidak nyaman' as `soal`, 50 as `nomor`, 'F' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 50 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya melihat lampu atau sumber cahaya yang menyala berkedip' as `soal`, 51 as `nomor`, 'G' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 51 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya melihat lampu atau sumber cahaya yang menyala terdapat noda' as `soal`, 52 as `nomor`, 'G' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 52 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya melihat lampu atau sumber cahaya yang menyala terdapat garis' as `soal`, 53 as `nomor`, 'G' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 53 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Tiba-tiba saya merasa tertekan tanpa alasan' as `soal`, 54 as `nomor`, 'G' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 54 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Tiba-tiba saya merasa sangat gembira tanpa alasan' as `soal`, 55 as `nomor`, 'G' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 55 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saat bangun tidur, saya merasa sangat lelah' as `soal`, 56 as `nomor`, 'G' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 56 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya kesulitan untuk dapat terlelap saat tidur' as `soal`, 57 as `nomor`, 'G' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 57 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya mengalami insomnia' as `soal`, 58 as `nomor`, 'G' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 58 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya merasa nyeri di kepala' as `soal`, 59 as `nomor`, 'G' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 59 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Hidung saya tersumbat' as `soal`, 60 as `nomor`, 'G' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 60 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Mata saya berair' as `soal`, 61 as `nomor`, 'G' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 61 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya menginginkan sesuatu seperti saat ngidam (ibu sedang hamil)' as `soal`, 62 as `nomor`, 'G' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 62 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Area di belakang mata saya sakit' as `soal`, 63 as `nomor`, 'G' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 63 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya mengalami nyeri di leher' as `soal`, 64 as `nomor`, 'G' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 64 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya sering buang air kecil' as `soal`, 65 as `nomor`, 'G' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 65 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya terlalu banyak menguap' as `soal`, 66 as `nomor`, 'G' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 66 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya mengalami mati rasa' as `soal`, 67 as `nomor`, 'G' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 67 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya mengalami kesemutan' as `soal`, 68 as `nomor`, 'G' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 68 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya mengalami mual' as `soal`, 69 as `nomor`, 'G' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 69 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya mengalami muntah' as `soal`, 70 as `nomor`, 'G' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 70 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya menghindari atau sensitif terhadap cahaya' as `soal`, 71 as `nomor`, 'G' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 71 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya menghindari atau sensitif terhadap bau' as `soal`, 72 as `nomor`, 'G' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 72 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya menghindari atau sensitif terhadap kebisingan' as `soal`, 73 as `nomor`, 'G' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 73 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya mengalami kesulitan berbicara' as `soal`, 74 as `nomor`, 'G' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 74 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya mengalami kelemahan pada salah satu sisi tubuh' as `soal`, 75 as `nomor`, 'G' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 75 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya kehilangan energi setelah sakit di kepala reda' as `soal`, 76 as `nomor`, 'G' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 76 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya mengalami pusing yang berputar-putar' as `soal`, 77 as `nomor`, 'H' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 77 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya mengalami mual' as `soal`, 78 as `nomor`, 'H' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 78 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya mengalami muntah' as `soal`, 79 as `nomor`, 'H' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 79 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Mata saya gelap' as `soal`, 80 as `nomor`, 'H' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 80 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya mengalami ketidakseimbangan saat bagun tidur' as `soal`, 81 as `nomor`, 'H' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 81 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya pingsan' as `soal`, 82 as `nomor`, 'H' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 82 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya kehilangan kesadaran' as `soal`, 83 as `nomor`, 'H' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 83 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Telinga saya berdenging' as `soal`, 84 as `nomor`, 'H' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 84 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya mengalami penurunan dan atau kehilangan kemampuan pendengaran' as `soal`, 85 as `nomor`, 'H' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 85 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya mengalami sensasi tubuh akan jatuh atau limbung' as `soal`, 86 as `nomor`, 'H' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 86 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Anggota tubuh saya terasa lemah' as `soal`, 87 as `nomor`, 'H' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 87 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Penglihatan saya berbayang' as `soal`, 88 as `nomor`, 'H' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 88 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya mengalami kesulitan berbicara' as `soal`, 89 as `nomor`, 'H' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 89 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Pergerakan mata saya tidak normal' as `soal`, 90 as `nomor`, 'H' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 90 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Respon saya melambat' as `soal`, 91 as `nomor`, 'H' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 91 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya kesulitan berjalan' as `soal`, 92 as `nomor`, 'H' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 92 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya mengalami demam' as `soal`, 93 as `nomor`, 'H' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 93 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya mengalami sakit kepala yang parah' as `soal`, 94 as `nomor`, 'I' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 94 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya merasa pusing' as `soal`, 95 as `nomor`, 'I' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 95 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Penglihatan saya buram' as `soal`, 96 as `nomor`, 'I' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 96 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya merasa mual' as `soal`, 97 as `nomor`, 'I' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 97 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Telinga saya berdenging' as `soal`, 98 as `nomor`, 'I' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 98 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya merasa kebingungan' as `soal`, 99 as `nomor`, 'I' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 99 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Detak jantung saya tidak teratur' as `soal`, 100 as `nomor`, 'I' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 100 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Dada saya terasa nyeri' as `soal`, 101 as `nomor`, 'I' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 101 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya mengalami kesulitan bernapas' as `soal`, 102 as `nomor`, 'I' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 102 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saat buang air kecil, ada darah dalam urin ' as `soal`, 103 as `nomor`, 'I' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 103 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya mengalami sensasi berdetak di dada' as `soal`, 104 as `nomor`, 'I' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 104 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya mengalami sensasi berdetak di leher' as `soal`, 105 as `nomor`, 'I' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 105 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya mengalami sensasi berdetak di telinga' as `soal`, 106 as `nomor`, 'I' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 106 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya merasa pegal' as `soal`, 107 as `nomor`, 'J' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 107 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya merasa kesemutan' as `soal`, 108 as `nomor`, 'J' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 108 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Kepala saya sakit' as `soal`, 109 as `nomor`, 'J' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 109 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya mudah mengantuk' as `soal`, 110 as `nomor`, 'J' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 110 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya sulit berkonsentrasi' as `soal`, 111 as `nomor`, 'J' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 111 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya merasakan nyeri di persendian' as `soal`, 112 as `nomor`, 'J' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 112 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Jantung saya berdebar-debar' as `soal`, 113 as `nomor`, 'J' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 113 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Tengkuk saya terasa kaku' as `soal`, 114 as `nomor`, 'J' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 114 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Kadar kolesterol di atas normal' as `soal`, 115 as `nomor`, 'J' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 115 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya mengalami sesak napas' as `soal`, 116 as `nomor`, 'J' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 116 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya sering buang air kecil' as `soal`, 117 as `nomor`, 'K' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 117 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya mudah merasa haus' as `soal`, 118 as `nomor`, 'K' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 118 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya cepat lapar' as `soal`, 119 as `nomor`, 'K' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 119 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Berat badan saya menurun drastis tanpa alasan yang jelas' as `soal`, 120 as `nomor`, 'K' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 120 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Kulit saya kering' as `soal`, 121 as `nomor`, 'K' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 121 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saat terjadi luka, lama untuk sembuh' as `soal`, 122 as `nomor`, 'K' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 122 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya mengalami gangguan penglihatan' as `soal`, 123 as `nomor`, 'K' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 123 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya mengalami kesemutan' as `soal`, 124 as `nomor`, 'K' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 124 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya merasa lemas' as `soal`, 125 as `nomor`, 'K' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 125 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya mengalami infeksi jamur pada kulit' as `soal`, 126 as `nomor`, 'K' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 126 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya mengalami infeksi bakteri pada kulit' as `soal`, 127 as `nomor`, 'K' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 127 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya mengalami sesak napas' as `soal`, 128 as `nomor`, 'L' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 128 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya mengalami nyeri di dada' as `soal`, 129 as `nomor`, 'L' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 129 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya muntah' as `soal`, 130 as `nomor`, 'L' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 130 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya mengalami diare' as `soal`, 131 as `nomor`, 'L' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 131 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya demam dan menggigil' as `soal`, 132 as `nomor`, 'L' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 132 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya mengalami kelemahan otot' as `soal`, 133 as `nomor`, 'L' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 133 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya mengalami nyeri otot' as `soal`, 134 as `nomor`, 'L' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 134 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya merasa cemas' as `soal`, 135 as `nomor`, 'L' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 135 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya merasa kehilangan harapan' as `soal`, 136 as `nomor`, 'L' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 136 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya mengalami kram perut' as `soal`, 137 as `nomor`, 'M' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 137 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Nafsu makan saya menurun' as `soal`, 138 as `nomor`, 'M' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 138 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Berat badan saya turun' as `soal`, 139 as `nomor`, 'M' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 139 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Muncul mual' as `soal`, 140 as `nomor`, 'M' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 140 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya mengalami muntah' as `soal`, 141 as `nomor`, 'M' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 141 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya mengalami demam' as `soal`, 142 as `nomor`, 'M' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 142 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya mengalami sakit otot' as `soal`, 143 as `nomor`, 'M' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 143 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya mengalami sakit kepala' as `soal`, 144 as `nomor`, 'M' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 144 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Muncul keringat berlebih ' as `soal`, 145 as `nomor`, 'M' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 145 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Kulit saya menjadi lembab' as `soal`, 146 as `nomor`, 'M' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 146 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya mengalami diare berair' as `soal`, 147 as `nomor`, 'M' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 147 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya mengalami diare berdarah' as `soal`, 148 as `nomor`, 'M' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 148 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Ada nanah dan atau darah di tinja' as `soal`, 149 as `nomor`, 'M' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 149 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya merasa haus dari biasanya' as `soal`, 150 as `nomor`, 'M' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 150 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya merasa lemas' as `soal`, 151 as `nomor`, 'M' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 151 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya muntah ketika ada makanan/minuman yang masuk ke mulut' as `soal`, 152 as `nomor`, 'M' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 152 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya mengalami kelelahan' as `soal`, 153 as `nomor`, 'N' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 153 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Detak jantung saya melemah' as `soal`, 154 as `nomor`, 'N' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 154 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya mengalami sembelit' as `soal`, 155 as `nomor`, 'N' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 155 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya sensitif terhadap suhu dingin' as `soal`, 156 as `nomor`, 'N' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 156 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya mengalami peningkatan berat badan' as `soal`, 157 as `nomor`, 'N' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 157 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya mengalami bengkak pada wajah' as `soal`, 158 as `nomor`, 'N' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 158 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya mengalami nyeri otot' as `soal`, 159 as `nomor`, 'N' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 159 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya mengalami nyeri sendi' as `soal`, 160 as `nomor`, 'N' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 160 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Koleterol meningkat' as `soal`, 161 as `nomor`, 'N' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 161 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya merasa nyeri di dada' as `soal`, 162 as `nomor`, 'O' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 162 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya merasa nyeri di tulang' as `soal`, 163 as `nomor`, 'O' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 163 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya nerasa nyeri di sendi' as `soal`, 164 as `nomor`, 'O' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 164 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya merasa nyeri di ulu hati' as `soal`, 165 as `nomor`, 'O' as `trait`, 1 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 165 AND `reversed_score` = 1 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;

-- Cognitive Distortion

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya membutuhkan orang lain untuk menyetujui saya bahwa saya layak mendapat sesuatu' as `soal`, 1 as `nomor`, '4' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 1 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya merasa seperti peramal, dapat meramalkan hal-hal buruk akan terjadi pada saya' as `soal`, 2 as `nomor`, '3' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 2 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya percaya bahwa orang lain berpikir buruk tentang saya' as `soal`, 3 as `nomor`, '1' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 3 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya cenderung mengabaikan hal-hal baik tentang saya' as `soal`, 4 as `nomor`, 'None' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 4 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya diantara menyukai seseorang atau tidak, tidak ada di antara saya' as `soal`, 5 as `nomor`, '6' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 5 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya menganggap remeh situasi, bahkan yang serius' as `soal`, 6 as `nomor`, '8' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 6 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya membandingkan diri saya dengan orang lain setiap waktu' as `soal`, 7 as `nomor`, '2,4' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 7 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya membesar-besarkan hal - hal melebihi batas kepentingan sebenarnya di dalam hidup saya' as `soal`, 8 as `nomor`, 'None' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 8 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya bertindak seolah-olah saya memiliki bola kristal, dapat meramalkan peristiwa negatif dalam hidup saya' as `soal`, 9 as `nomor`, '3' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 9 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Apa yang orang lain pikirkan tentang saya lebih penting daripada apa yang saya pikirkan tentang diri saya sendiri' as `soal`, 10 as `nomor`, '1' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 10 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Penyesalan dalam hidup saya berasal dari hal-hal yang seharusnya saya lakukan, tetapi tidak saya lakukan' as `soal`, 11 as `nomor`, '10' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 11 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya membuat keputusan berdasarkan perasaan saya' as `soal`, 12 as `nomor`, '11' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 12 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya menarik kesimpulan tanpa meninjau detail yang diperlukan dengan cermat' as `soal`, 13 as `nomor`, 'None' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 13 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Jika masalah berkembang dalam hidup saya, Anda bisa bertaruh itu ada hubungannya dengan cara saya' as `soal`, 14 as `nomor`, 'None' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 14 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Agar merasa baik, saya perlu orang lain untuk mengenali saya' as `soal`, 15 as `nomor`, '4' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 15 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya memotivasi diri saya sesuai dengan bagaimana saya seharusnya' as `soal`, 16 as `nomor`, '10' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 16 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya cenderung menyalahkan diri saya terhadap kejadian buruk yang terjadi' as `soal`, 17 as `nomor`, '1' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 17 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Tanpa bertanya, saya pikir orang lain melihat diri saya dengan sudut pandang yang negatif' as `soal`, 18 as `nomor`, '1' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 18 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya melakukan beberapa hal dan juga yang lainnya' as `soal`, 19 as `nomor`, '9' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 19 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya menganggap diri saya bertanggung jawab atas hal-hal yang berada di luar kendali saya' as `soal`, 20 as `nomor`, '1' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 20 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya cenderung mengabaikan sifat-sifat positif yang saya miliki' as `soal`, 21 as `nomor`, '1' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 21 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Tampaknya segala sesutau berjalan semuanya dengan baik atau semuanya salah di dunia saya' as `soal`, 22 as `nomor`, '6' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 22 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya cenderung memilih rincian negatif dalam suatu situasi dan memikirkannya secara mendalam' as `soal`, 23 as `nomor`, '2' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 23 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya memiliki kecenderungan untuk melebih-lebihkan peristiwa kecil dan membuatnya menjadi besar' as `soal`, 24 as `nomor`, 'None' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 24 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya berusaha mencapai kesempurnaan dalam semua bidang kehidupan saya' as `soal`, 25 as `nomor`, '5' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 25 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya memiliki kebiasaan untuk memprediksi bahwa segala sesuatu akan salah dalam situasi apa pun' as `soal`, 26 as `nomor`, '3' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 26 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya memiliki banyak keharusan, kewajiban, dan keharusan dalam hidup saya' as `soal`, 27 as `nomor`, '10' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 27 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya meremehkan pencapaian saya' as `soal`, 28 as `nomor`, '1' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 28 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya memangil diri saya dengan nama negative atau buruk' as `soal`, 29 as `nomor`, 'None' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 29 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya dikenal membuat gunung dari tumpukan tanah seperti tikus tanah' as `soal`, 30 as `nomor`, '2' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 30 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Kebanyakan orang lebih baik dalam hal-hal daripada saya' as `soal`, 31 as `nomor`, '9' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 31 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya memiliki kecenderungan untuk melebih-lebihkan sesuatu bahkan untuk peristiwa kecil' as `soal`, 32 as `nomor`, '2' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 32 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Ketika aturan baru keluar di tempat kerja, sekolah, atau rumah, saya pikir itu pasti dibuat karena sesuatu yang saya lakukan' as `soal`, 33 as `nomor`, '12' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 33 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Ketika dihadapkan dengan beberapa kemungkinan hasil, saya cenderung berpikir yang terburuk akan terjadi' as `soal`, 34 as `nomor`, 'None' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 34 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Dibandingkan dengan orang lain seperti saya, saya merasa kurang' as `soal`, 35 as `nomor`, '1' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 35 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya percaya ramalan negatif saya tentang masa depan saya akan terjadi' as `soal`, 36 as `nomor`, '3' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 36 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Segala sesuatu seharusnya memiliki cara tertentu' as `soal`, 37 as `nomor`, 'None' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 37 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya biasanya membayangkan konsekuensi mengerikan dari kesalahan saya' as `soal`, 38 as `nomor`, 'None' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 38 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Ketika saya memikirkan sesuatu, saya cukup perfeksionis' as `soal`, 39 as `nomor`, '5' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 39 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Jika saya merasakan hal tentang sesuatu, saya biasanya benar' as `soal`, 40 as `nomor`, '7' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 40 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya membutuhkan banyak pujian dari orang lain untuk merasa baik tentang diri saya' as `soal`, 41 as `nomor`, '4' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 41 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Dalam pikiran saya, semuanya hitam atau putih, tidak ada abu-abu atau diantaranya' as `soal`, 42 as `nomor`, '6' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 42 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya biasanya membuat penilaian tanpa memeriksa semua fakta sebelumnya' as `soal`, 43 as `nomor`, '2' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 43 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Orang-orang hanya mengatakan hal-hal baik kepada saya karena mereka menginginkan sesuatu atau karena mereka mencoba untuk menyanjung saya' as `soal`, 44 as `nomor`, 'None' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 44 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya menemukan bahwa saya memiliki kecenderungan untuk meminimalkan konsekuensi dari tindakan saya, terutama jika hasilnya negatif' as `soal`, 45 as `nomor`, '8' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 45 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya menemukan bahwa saya sering membutuhkan umpan balik dari orang lain untuk mendapatkan rasa nyaman tentang diri saya' as `soal`, 46 as `nomor`, '4' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 46 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya langsung mengambil kesimpulan tanpa mempertimbangkan sudut pandang alternatif' as `soal`, 47 as `nomor`, '2' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 47 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Sejauh kehidupanku berjalan, segala sesuatunya entah menjadi  hebat atau sangat buruk' as `soal`, 48 as `nomor`, '6' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 48 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya memberi julukan diri saya dengan kalimat negatif' as `soal`, 49 as `nomor`, 'None' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 49 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya menemukan bahwa saya yang menganggap menyalahkan hal-hal negatif' as `soal`, 50 as `nomor`, '1' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 50 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya menemukan diri saya bertanggung jawab atas segala hal ' as `soal`, 51 as `nomor`, 'None' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 51 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Hal-hal positif dalam hidup saya tidak banyak berarti sama sekali' as `soal`, 52 as `nomor`, '1' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 52 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya harus memiliki hal-hal yang diberikan dalam hidup saya' as `soal`, 53 as `nomor`, 'None' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 53 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya percaya, saya tahu bagaimana seseorang merasakan tentang saya tanpa dia pernah mengatakannya' as `soal`, 54 as `nomor`, 'None' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 54 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Dugaan negatif saya biasanya menjadi kenyataan' as `soal`, 55 as `nomor`, '3' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 55 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Perasaan saya mencerminkan keadaan' as `soal`, 56 as `nomor`, '7' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 56 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Penting berjuang untuk kesempurnaan untuk segala sesuatu yang saya lakukan' as `soal`, 57 as `nomor`, '5' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 57 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya cenderung meremehkan pujian' as `soal`, 58 as `nomor`, '1' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 58 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Ketika sesuatu yang negatif terjadi, itu mengerikan' as `soal`, 59 as `nomor`, '12' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 59 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Perasaan saya adalah cerminan akurat dari apa yang sebenarnya terjadi' as `soal`, 60 as `nomor`, '7' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 60 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Bahkan peristiwa kecil dapat membawa konsekuensi bencana' as `soal`, 61 as `nomor`, 'None' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 61 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Ketika saya membandingkan diri saya dengan orang lain, saya minder' as `soal`, 62 as `nomor`, '1' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 62 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya menjatuhkan diri sendiri' as `soal`, 63 as `nomor`, '1' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 63 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Ada cara yang benar dan cara yang salah untuk melakukan sesuatu' as `soal`, 64 as `nomor`, 'None' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 64 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya cenderung memikirkan hal-hal yang tidak saya sukai tentang diri saya' as `soal`, 65 as `nomor`, 'None' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 65 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya percaya dengan firasat saya ketika memutuskan sesuatu' as `soal`, 66 as `nomor`, '11' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 66 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Jika orang mengabaikan saya, saya pikir mereka memiliki pikiran negatif tentang saya' as `soal`, 67 as `nomor`, 'None' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 67 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya meremehkan situasi yang serius' as `soal`, 68 as `nomor`, '8' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 68 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya melakukan sesuatu di luar proporsi ' as `soal`, 69 as `nomor`, '2' as `trait`, 2 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 69 AND `reversed_score` = 2 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;

-- Gangguan Kepribadian

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya curiga dan memiliki ketidakpercayaan yang kuat terhadap orang lain' as `soal`, 1 as `nomor`, 'A' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 1 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya diliputi keraguan yang tidak beralasan terhadap kesetiaan orang lain' as `soal`, 2 as `nomor`, 'A' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 2 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya memiliki keraguan terhadap orang lain untuk dapat dipercaya' as `soal`, 3 as `nomor`, 'A' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 3 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya merasa diperlakukan salah serta dieksploitasi oleh orang lain' as `soal`, 4 as `nomor`, 'A' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 4 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya selalu waspada terhadap orang lain' as `soal`, 5 as `nomor`, 'A' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 5 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya sering kali kasar dan mudah marah terhadap segala sesuatu yang saya anggap penghinaan terhadap diri saya' as `soal`, 6 as `nomor`, 'A' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 6 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya enggan mempercayai orang lain' as `soal`, 7 as `nomor`, 'A' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 7 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya cenderung menyalahkan orang lain ' as `soal`, 8 as `nomor`, 'A' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 8 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya suka menyimpan dendam, meskipun saya juga bersalah kepada orang lain' as `soal`, 9 as `nomor`, 'A' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 9 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya tidak mampu terlibat secara emosional dan menjaga jarak dengan orang lain' as `soal`, 10 as `nomor`, 'A' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 10 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya sulit bertindak hangat kepada orang lain' as `soal`, 11 as `nomor`, 'A' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 11 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya tidak menginginkan atau menikmati hubungan sosial' as `soal`, 12 as `nomor`, 'B' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 12 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya tidak memiliki teman akrab' as `soal`, 13 as `nomor`, 'B' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 13 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya suka menyendiri dan menyukai kegiatan yang dilakukan sendiri' as `soal`, 14 as `nomor`, 'B' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 14 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya tidak memiliki perasaan yang tulus dan hangat terhadap orang lain' as `soal`, 15 as `nomor`, 'B' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 15 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya jarang memiliki emosi yang kuat' as `soal`, 16 as `nomor`, 'B' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 16 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya tidak tertarik pada hubungan seks' as `soal`, 17 as `nomor`, 'B' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 17 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya bersikap masa bodoh terhadap respon orang lain seperti pujian, kritik, dan perasaan orang lain' as `soal`, 18 as `nomor`, 'B' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 18 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya suka menarik diri dari lingkungan ' as `soal`, 19 as `nomor`, 'B' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 19 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya tidak nyaman bila berinteraksi dengan orang lain' as `soal`, 20 as `nomor`, 'B' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 20 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya merasa sebagai individu yang eksentrik' as `soal`, 21 as `nomor`, 'B' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 21 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya merasa sebagai individu yang terkucil ' as `soal`, 22 as `nomor`, 'B' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 22 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya merasa sebagai individu yang dingin terhadap orang lain' as `soal`, 23 as `nomor`, 'B' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 23 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya merasa berhasil dalam bidang yang tidak melibatkan orang lain' as `soal`, 24 as `nomor`, 'B' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 24 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya memiliki kepercayaan yang aneh atau berbeda dibandingkan orang lain' as `soal`, 25 as `nomor`, 'C' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 25 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya memiliki pemikiran yang ajaib, aneh, atau ide-ide ganjil' as `soal`, 26 as `nomor`, 'C' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 26 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya suka memiliki ilusi yang ditampilkan dalam kehidupan sehari-hari' as `soal`, 27 as `nomor`, 'C' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 27 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya merasa memiliki masalah dalam berpikir dan berkomunikasi' as `soal`, 28 as `nomor`, 'C' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 28 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Ketika berbicara dengan orang lain, saya menggunakan kata-kata dengan cara yang tidak umum atau tidak jelas dimana hanya saya saja yang dapat mengerti' as `soal`, 29 as `nomor`, 'C' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 29 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya berpenampilan dan berperilaku yang eksentrik' as `soal`, 30 as `nomor`, 'C' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 30 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya suka berbicara kepada diri saya sendiri' as `soal`, 31 as `nomor`, 'C' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 31 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya suka memakai pakaian kotor dan kusut' as `soal`, 32 as `nomor`, 'C' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 32 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya memiliki keyakinan bahwa berbagai kejadian memiliki makna khusus dan tidak biasa' as `soal`, 33 as `nomor`, 'C' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 33 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya memiliki kecurigaan terhadap segala sesuatu' as `soal`, 34 as `nomor`, 'C' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 34 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya berpikir paranoid terhadap segala sesuatu' as `soal`, 35 as `nomor`, 'C' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 35 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya memiliki keterampilan yang rendah dalam berinteraksi dengan orang lain' as `soal`, 36 as `nomor`, 'C' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 36 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya kadangkala bertingkah laku aneh dihadapan orang lain' as `soal`, 37 as `nomor`, 'C' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 37 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya sering kali terkucil dan tidak memiliki banyak teman' as `soal`, 38 as `nomor`, 'C' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 38 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya suka bertindak sesuai dengan kata hati atau impulsif' as `soal`, 39 as `nomor`, 'D' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 39 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya sering mengalami ketidakstabilan dalam berhubungan dengan orang lain' as `soal`, 40 as `nomor`, 'D' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 40 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya sering mengalami mood atau suasana hati yang berubah-ubah' as `soal`, 41 as `nomor`, 'D' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 41 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Sikap saya terhadap orang lain dapat berubah dalam kurun waktu yang singkat' as `soal`, 42 as `nomor`, 'D' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 42 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Perasaan saya terhadap orang lain dapat berubah dalam kurun waktu yang singkat' as `soal`, 43 as `nomor`, 'D' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 43 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya memiliki sifat mudah sekali berargumentasi atau beralasan kepada orang lain' as `soal`, 44 as `nomor`, 'D' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 44 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya merasa mudah sekali tersinggung' as `soal`, 45 as `nomor`, 'D' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 45 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya sering berkata kasar atau sarkastik kepada orang lain' as `soal`, 46 as `nomor`, 'D' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 46 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya mudah sekali cepat menyerang orang lain baik dengan perkataan ' as `soal`, 47 as `nomor`, 'D' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 47 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya mudah sekali cepat menyerang orang lain baik dengan perbuatan' as `soal`, 48 as `nomor`, 'D' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 48 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Orang lain merasa sulit untuk hidup bersama dengan saya' as `soal`, 49 as `nomor`, 'D' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 49 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya suka sekali boros dalam hal keuangan' as `soal`, 50 as `nomor`, 'D' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 50 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya sering kali melakukan hal yang tidak diduga atau diprediksi' as `soal`, 51 as `nomor`, 'D' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 51 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya sering melakukan aktivitas seksual yang tanpa pandang bulu' as `soal`, 52 as `nomor`, 'D' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 52 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya merasa kecanduan terhadap rokok, narkoba, obat, atau zat aditif lainnya' as `soal`, 53 as `nomor`, 'D' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 53 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya sering makan secara berlebihan' as `soal`, 54 as `nomor`, 'D' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 54 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya memilki potensi untuk merusak diri saya sendiri' as `soal`, 55 as `nomor`, 'D' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 55 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya merasa tidak tahan dalam kesendirian' as `soal`, 56 as `nomor`, 'D' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 56 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya merasa takut diabaikan oleh orang lain' as `soal`, 57 as `nomor`, 'D' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 57 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya sering menuntut perhatian kepada orang lain' as `soal`, 58 as `nomor`, 'D' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 58 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya mudah sekali mengalami perasaan yang tertekan dan hampa' as `soal`, 59 as `nomor`, 'D' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 59 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya pernah beberapa kali mencoba untuk bunuh diri' as `soal`, 60 as `nomor`, 'D' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 60 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya sering melakukan tindakan dramatis atau mencari perhatian orang lain di sekitar saya' as `soal`, 61 as `nomor`, 'E' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 61 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya sering menggunakan ciri-ciri penampilan fisik yang dapat menarik perhatian orang sekitar saya seperti pakain yang mencolok' as `soal`, 62 as `nomor`, 'E' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 62 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya sering menggunakan ciri-ciri penampilan fisik yang dapat menarik perhatian orang sekitar saya seperti tata rias yang mencolok' as `soal`, 63 as `nomor`, 'E' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 63 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya sering menggunakan ciri-ciri penampilan fisik yang dapat menarik perhatian orang sekitar saya seperti warna rambut yang mencolok, ' as `soal`, 64 as `nomor`, 'E' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 64 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya sering berpusat kepada diri saya, dan bukan kepada orang lain' as `soal`, 65 as `nomor`, 'E' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 65 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya terlalu memperdulikan daya tarik fisik saya dihadapan orang sekitar' as `soal`, 66 as `nomor`, 'E' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 66 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya merasa tidak nyaman jika tidak menjadi pusat perhatian orang lain' as `soal`, 67 as `nomor`, 'E' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 67 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya dapat dengan mudah menjadi terprovokatif dan tidak senonoh secara seksual tanpa memperdulikan kepantasan' as `soal`, 68 as `nomor`, 'E' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 68 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya mudah dipengaruhi oleh orang lain' as `soal`, 69 as `nomor`, 'E' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 69 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya merasa diri saya spesial atau berbeda dibandingkan orang lain ' as `soal`, 70 as `nomor`, 'F' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 70 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya merasa perlu diperlakukan berbeda atau khusus oleh orang lain' as `soal`, 71 as `nomor`, 'F' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 71 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya sulit menerima kritik dari orang lain' as `soal`, 72 as `nomor`, 'F' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 72 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya kurang mampu merasakan pikiran dan perasaan orang lain' as `soal`, 73 as `nomor`, 'F' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 73 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya sering iri dengan orang lain' as `soal`, 74 as `nomor`, 'F' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 74 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya sering merasa sombong ' as `soal`, 75 as `nomor`, 'F' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 75 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya merasa orang lain harus memperlakukan saya secara istimewa tanpa saya harus membalas perlakuan mereka' as `soal`, 76 as `nomor`, 'F' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 76 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya merasa takut akan kegagalan' as `soal`, 77 as `nomor`, 'F' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 77 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya merasa sensitif terhadap kritik yang ditujukan kepada saya' as `soal`, 78 as `nomor`, 'F' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 78 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya merasa kecewa dengan diri saya' as `soal`, 79 as `nomor`, 'F' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 79 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya tidak mengizinkan siapapun untuk benar-benar berhubungan dekat dengan saya' as `soal`, 80 as `nomor`, 'F' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 80 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya sering kali berperilaku tidak bertanggungjawab' as `soal`, 81 as `nomor`, 'G' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 81 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya sering bekerja tidak konsisten' as `soal`, 82 as `nomor`, 'G' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 82 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya sering melalukan tindakan yang melanggar hukum' as `soal`, 83 as `nomor`, 'G' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 83 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya mudah sekali tersinggung' as `soal`, 84 as `nomor`, 'G' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 84 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya suka menyerang secara fisik' as `soal`, 85 as `nomor`, 'G' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 85 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya tidak mau membayar hutang yang saya miliki' as `soal`, 86 as `nomor`, 'G' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 86 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya suka sembrono dan ceroboh' as `soal`, 87 as `nomor`, 'G' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 87 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya suka mengikuti kata hati atau bertindak impulsif' as `soal`, 88 as `nomor`, 'G' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 88 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya tidak mampu membuat rencana ke masa depan' as `soal`, 89 as `nomor`, 'G' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 89 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya merasa sedikit atau bahkan tidak menyesal terhadap tindakan buruk yang telah saya lakukan' as `soal`, 90 as `nomor`, 'G' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 90 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya tidak memiliki rasa malu' as `soal`, 91 as `nomor`, 'G' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 91 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya sering berpura-pura kepada orang lain' as `soal`, 92 as `nomor`, 'G' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 92 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya suka berpenampilan yang menawan dihadapan orang lain' as `soal`, 93 as `nomor`, 'G' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 93 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya suka untuk memanipulasi orang lain untuk kepentingan pribadi saya' as `soal`, 94 as `nomor`, 'G' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 94 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya memiliki kadar kecemasan yang rendah' as `soal`, 95 as `nomor`, 'G' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 95 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya suka berperilaku kejam kepada orang lain' as `soal`, 96 as `nomor`, 'G' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 96 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya sulit belajar dari kesalahan yang saya telah buat' as `soal`, 97 as `nomor`, 'G' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 97 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya memiliki ketakutan yang besar terhadap kritik, penolakan atau ketidaksetujuan dari orang lain' as `soal`, 98 as `nomor`, 'H' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 98 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya enggan menjalin hubungan dengan orang lain, kecuali saya yakin bahwa saya akan diterima' as `soal`, 99 as `nomor`, 'H' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 99 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya menghindari pekerjaan yang membutuhkan banyak kontak personal dengan orang lain' as `soal`, 100 as `nomor`, 'H' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 100 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya sangat mengendalikan diri atau bersifat kaku dalam situasi sosial' as `soal`, 101 as `nomor`, 'H' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 101 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya amat takut mengatakan sesuatu yang bodoh' as `soal`, 102 as `nomor`, 'H' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 102 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya takut dipermalukan di depan orang banyak' as `soal`, 103 as `nomor`, 'H' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 103 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya merasa tidak kompeten dan inferior' as `soal`, 104 as `nomor`, 'H' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 104 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya tidak berani mengambil resiko atau mencoba hal-hal baru' as `soal`, 105 as `nomor`, 'H' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 105 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya takut tampak jelek dihadapan orang lain' as `soal`, 106 as `nomor`, 'H' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 106 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya memandang diri saya lemah dan orang lain lebih kuat' as `soal`, 107 as `nomor`, 'I' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 107 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya memiliki kebutuhan yang kuat untuk diperhatikan oleh orang lain' as `soal`, 108 as `nomor`, 'I' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 108 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya memiliki kebutuhan yang kuat untuk dijaga oleh orang lain' as `soal`, 109 as `nomor`, 'I' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 109 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya sering merasa tidak nyaman ketika berada dalam situasi yang sendiri' as `soal`, 110 as `nomor`, 'I' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 110 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya mengesampingkan kebutuhan sendiri  untuk mewakinkan bahwa saya tidak merusak hubungan yang telah terjalin bersama orang lain' as `soal`, 111 as `nomor`, 'I' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 111 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saat hubungan dengan teman atau pasangan berakhir, saya berusaha menjalin hubungan lain untuk menggantikan hubungan yang telah berakhir tersebut' as `soal`, 112 as `nomor`, 'I' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 112 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya bersifat sangat pasif' as `soal`, 113 as `nomor`, 'I' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 113 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya kesulitan untuk memulai hal yang baru' as `soal`, 114 as `nomor`, 'I' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 114 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya ksulitan mengerjakan sesuatu sendiri' as `soal`, 115 as `nomor`, 'I' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 115 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya tidak mampu menolak permintaan dari orang lain' as `soal`, 116 as `nomor`, 'I' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 116 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya meminta orang lain mengambil keputusan untuk urusan diri saya' as `soal`, 117 as `nomor`, 'I' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 117 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya sangat takut untuk mengurus atau menjaga diri sendiri' as `soal`, 118 as `nomor`, 'I' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 118 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya bersifat perfeksionis, sangat memperhatikan detail, aturan, dan jadwal' as `soal`, 119 as `nomor`, 'J' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 119 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya sering kali tidak dapat menyelesaikan hal yang saya kerjakan' as `soal`, 120 as `nomor`, 'J' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 120 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya lebih berorientasi kepada pekerjaan dari pada bersantai-santai' as `soal`, 121 as `nomor`, 'J' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 121 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya sangat sulit membuat keputusan karena takut membuat kesalahan' as `soal`, 122 as `nomor`, 'J' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 122 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya sulit mengalokasikan waktu karena terlalu memfokuskan pada hal-hal yang tidak seharusnya ' as `soal`, 123 as `nomor`, 'J' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 123 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya merasa berhubungan dengan orang lain secara kurang baik atau buruk' as `soal`, 124 as `nomor`, 'J' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 124 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya keras kepala dan meminta segala sesuatu dilakukan sesuai keinginan saya' as `soal`, 125 as `nomor`, 'J' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 125 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya sering merasa menjadi “control freak”' as `soal`, 126 as `nomor`, 'J' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 126 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya bersifat kaku, serius, formal, dan tidak fleksibel terutama berkaitan dengan isu moral' as `soal`, 127 as `nomor`, 'J' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 127 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya tidak mampu membuang benda yang tidak berguna walaupun sudah tidak bernilai' as `soal`, 128 as `nomor`, 'J' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 128 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya merasa pelit atau kikir' as `soal`, 129 as `nomor`, 'J' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 129 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`) 
                SELECT * FROM (SELECT 'Saya tidak ingin mendelegasikan pekerjaan kecuali orang lain mengacu kepada standar yang sama dengan saya' as `soal`, 130 as `nomor`, 'J' as `trait`, 3 as `reversed_score`, 'psikosomatis' as `quiz_code`) AS tmp
                WHERE NOT EXISTS (
                    SELECT nomor FROM personal_questions WHERE `nomor` = 130 AND `reversed_score` = 3 AND quiz_code = 'psikosomatis'
                ) LIMIT 1;

-- Depression

-- 1
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya tidak merasa sedih' as `soal`, 1 as `nomor`, '0' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 1 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya merasa sedih' as `soal`, 1 as `nomor`, '0' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 1 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya sedih dan murung sepanjang waktu dan tidak bisa menghilangkan perasaan itu' as `soal`, 1 as `nomor`, '1' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 1 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya demikian sedih atau tidak bahagia sehingga saya tidak tahan lagi rasanya' as `soal`, 1 as `nomor`, '0' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 1 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

-- 2
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya tidak terlalu berkecil hati mengenai masa depan' as `soal`, 2 as `nomor`, '0' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 2 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya merasa kecil hati mengenai masa depan' as `soal`, 2 as `nomor`, '0' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 2 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya merasa bahwa tidak ada satupun yang dapat saya harapkan' as `soal`, 2 as `nomor`, '1' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 2 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya merasa bahwa masa depan saya tanpa harapan dan bahwa semuanya  tidak akan dapat membaik' as `soal`, 2 as `nomor`, '0' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 2 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

-- 3
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya tidak menganggap diri saya sebagai orang yang gagal' as `soal`, 3 as `nomor`, '0' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 3 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya merasa bahwa saya telah gagal lebih daripada kebanyakan orang' as `soal`, 3 as `nomor`, '0' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 3 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saat saya mengingat masa lalu, maka yang teringat oleh saya hanyalah kegagalan' as `soal`, 3 as `nomor`, '0' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 3 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya merasa bahwa saya adalah seorang yang gagal total' as `soal`, 3 as `nomor`, '1' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 3 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

-- 4
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya mendapat banyak kepuasan dari hal-hal yang biasa saya lakukan' as `soal`, 4 as `nomor`, '0' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 4 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya tidak dapat lagi mendapat kepuasan dari hal-hal yang biasa saya lakukan' as `soal`, 4 as `nomor`, '0' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 4 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya tidak mendapat kepuasan dari apapun lagi' as `soal`, 4 as `nomor`, '0' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 4 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya rnerasa tidak puas atau bosan dengan segalanya' as `soal`, 4 as `nomor`, '1' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 4 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

-- 5
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya tidak terlalu merasa bersalah' as `soal`, 5 as `nomor`, '0' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 5 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya merasa bersalah di sebagian waktu saya' as `soal`, 5 as `nomor`, '0' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 5 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya agak merasa bersalah di sebagian besar waktu' as `soal`, 5 as `nomor`, '0' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 5 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya merasa bersalah sepanjang waktu' as `soal`, 5 as `nomor`, '1' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 5 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

-- 6
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya tidak merasa seolah saya sedang dihukum' as `soal`, 6 as `nomor`, '0' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 6 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya merasa mungkin saya sedang dihukum' as `soal`, 6 as `nomor`, '0' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 6 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya pikir saya akan dihukum' as `soal`, 6 as `nomor`, '0' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 6 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya merasa bahwa saya sedang dihukum' as `soal`, 6 as `nomor`, '1' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 6 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

-- 7
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya tidak merasa kecewa terhadap diri saya sendiri' as `soal`, 7 as `nomor`, '0' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 7 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya kecewa dengan diri saya sendiri' as `soal`, 7 as `nomor`, '0' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 7 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya muak terhadap diri saya sendiri' as `soal`, 7 as `nomor`, '0' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 7 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'D, Saya membenci diri saya sendiri' as `soal`, 7 as `nomor`, '1' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 7 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

-- 8
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya tidak merasa lebih buruk dari pada orang lain' as `soal`, 8 as `nomor`, '0' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 8 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya mencela diri saya karena kelemahan dan kesalahan saya' as `soal`, 8 as `nomor`, '0' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 8 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya menyalahkan diri saya sepanjang waktu karena kesalahan-kesalahan  saya' as `soal`, 8 as `nomor`, '1' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 8 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya menyalahkan diri saya untuk semua hal buruk yang terjadi' as `soal`, 8 as `nomor`, '0' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 8 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

-- 9
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya tidak punya sedikitpun pikiran untuk bunuh diri' as `soal`, 9 as `nomor`, '0' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 9 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya mempunyai pikiran-pikiran untuk bunuh diri, namun saya tidak akan  melakukannya' as `soal`, 9 as `nomor`, '0' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 9 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya ingin bunuh diri' as `soal`, 9 as `nomor`, '1' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 9 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya akan bunuh diri jika saya punya kesempatan' as `soal`, 9 as `nomor`, '0' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 9 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

-- 10
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya tidak lebih banyak menangis dibandingkan biasanya' as `soal`, 10 as `nomor`, '0' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 10 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Sekarang saya lebih banyak menangis dari pada sebelumnya' as `soal`, 10 as `nomor`, '0' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 10 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Sekarang saya menangis sepanjang waktu' as `soal`, 10 as `nomor`, '1' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 10 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Biasanya saya rnampu menangis, namun kini saya tidak dapat lagi menangis walaupun saya menginginkannya' as `soal`, 10 as `nomor`, '0' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 10 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

-- 11
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya tidak lebih terganggu oleh berbagai hal dibandingkan biasanya' as `soal`, 11 as `nomor`, '0' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 11 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya sedikit lebih pemarah dari pada biasanya akhir-akhir ini' as `soal`, 11 as `nomor`, '0' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 11 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya agak jengkel atau terganggu di sebagian besar waktu saya' as `soal`, 11 as `nomor`, '1' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 11 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya merasa jengkel sepanjang waktu sekarang' as `soal`, 11 as `nomor`, '0' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 11 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

-- 12
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya tidak kehilangan minat saya terhadap orang lain' as `soal`, 12 as `nomor`, '0' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 12 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya agak kurang berminat terhadap orang lain dibanding biasanya' as `soal`, 12 as `nomor`, '0' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 12 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya kehilangan hampir seluruh minat saya pada orang lain' as `soal`, 12 as `nomor`, '1' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 12 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya telah kehilangan seluruh minat saya pada orang lain' as `soal`, 12 as `nomor`, '0' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 12 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

-- 13
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya mengambil keputusan-keputusan hampir sama baiknya dengan yang bisa saya lakukan' as `soal`, 13 as `nomor`, '0' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 13 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya menunda mengambil keputusan-keputusan begiiu sering dari yang bisa saya lakukan' as `soal`, 13 as `nomor`, '0' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 13 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya mengalami kesulitan lebih besar dalam mengambil keputusan-keputusan daripada sebelumnya' as `soal`, 13 as `nomor`, '1' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 13 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya sama sekali tidak dapat mengambil keputusan-keputusan lagi' as `soal`, 13 as `nomor`, '0' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 13 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

-- 14
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya tidak merasa bahwa keadaan saya tampak lebih buruk dari biasanya' as `soal`, 14 as `nomor`, '0' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 14 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya khawatir saya tampak lebih tua atau tidak menarik' as `soal`, 14 as `nomor`, '1' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 14 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya merasa bahwa ada perubahan-perubahan yang menetap dalam  penampilan saya sehingga membuat saya tampak tidak menarik' as `soal`, 14 as `nomor`, '0' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 14 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya yakin bahwa saya terlihat jelek' as `soal`, 14 as `nomor`, '0' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 14 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

-- 15
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya dapat bekerja sama baiknya dengan waktu-waktu sebelumnya' as `soal`, 15 as `nomor`, '0' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 15 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya membutuhkan suatu usaha ekstra untuk mulai melakukan sesuatu' as `soal`, 15 as `nomor`, '1' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 15 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya harus memaksa diri sekuat tenaga untuk mulai melakukan sesuatu' as `soal`, 15 as `nomor`, '0' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 15 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya tidak mampu mengerjakan apa pun lagi' as `soal`, 15 as `nomor`, '0' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 15 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

-- 16
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya dapat tidur seperti biasanya' as `soal`, 16 as `nomor`, '0' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 16 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Tidur saya tidak senyenyak biasanya' as `soal`, 16 as `nomor`, '1' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 16 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya bangun 1-2 jam lebih awal dari biasanya dan merasa sukar sekali untuk    bisa tidur kembali' as `soal`, 16 as `nomor`, '0' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 16 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya bangun beberapa jam lebih awal dari biasanya dan tidak dapat tidur   kembali' as `soal`, 16 as `nomor`, '0' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 16 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

-- 17
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya tidak merasa lebih lelah dari biasanya' as `soal`, 17 as `nomor`, '0' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 17 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya merasa lebih mudah lelah dari biasanya' as `soal`, 17 as `nomor`, '1' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 17 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya merasa lelah setelah melakukan apa saja' as `soal`, 17 as `nomor`, '0' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 17 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya terlalu lelah untuk melakukan apapun' as `soal`, 17 as `nomor`, '0' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 17 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

-- 18
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Nafsu makan saya tidak lebih buruk dari biasanya' as `soal`, 18 as `nomor`, '0' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 18 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Nafsu makan saya tidak sebaik biasanya' as `soal`, 18 as `nomor`, '1' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 18 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Nafsu makan saya kini jauh lebih buruk' as `soal`, 18 as `nomor`, '0' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 18 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya tak memiliki nafsu makan lagi' as `soal`, 18 as `nomor`, '0' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 18 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

-- 19
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Berat badan saya tidak turun banyak atau bahkan tetap akhir-akhir ini' as `soal`, 19 as `nomor`, '1' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 19 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Berat badan saya turun lebih dari 2,5 kg' as `soal`, 19 as `nomor`, '0' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 19 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Berat badan saya turun lebih dari 5 kg' as `soal`, 19 as `nomor`, '0' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 19 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Berat badan saya turun lebih dari 7.5 kg' as `soal`, 19 as `nomor`, '0' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 19 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

-- 20
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya tidak lebih khawatir mengenai kesehatan saya dari pada biasanya' as `soal`, 20 as `nomor`, '1' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 20 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya khawatir mengenai masalah-masalah fisik seperti rasa sakit dan tidak enak badan, atau perut mual atau sembelit' as `soal`, 20 as `nomor`, '0' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 20 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya sangat cemas mengenai masalah-masalah fisik dan sukar untuk  memikirkan banyak hal lainnya' as `soal`, 20 as `nomor`, '0' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 20 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya begitu cemas mengenai masalah-masalah fisik saya sehingga tidak dapat berfikir tentang hal lainnya' as `soal`, 20 as `nomor`, '0' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 20 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

-- 21
INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya tidak melihat adanya perubahan dalam minat saya terhadap seks' as `soal`, 21 as `nomor`, '1' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 21 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya kurang berminat di bidang seks dibandingkan biasanya' as `soal`, 21 as `nomor`, '0' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 21 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Kini saya sangat kurang berminat terhadap seks' as `soal`, 21 as `nomor`, '0' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 21 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

INSERT INTO personal_questions (`soal`, `nomor`, `trait`, `reversed_score`, `quiz_code`)

                SELECT * FROM (SELECT 'Saya telah kehilangan minat terhadap seks sama sekali' as `soal`, 21 as `nomor`, '0' as `trait`, 4 as `reversed_score`, 'psikosomatis' as `quiz_code`) as tmp
                WHERE 4 > (SELECT count(1) FROM personal_questions WHERE `nomor` = 21 AND `reversed_score` = 4 AND `quiz_code` = 'psikosomatis') LIMIT 1;

