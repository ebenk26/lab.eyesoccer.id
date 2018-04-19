#01/01/2000
UPDATE tbl_player SET birth_date = DATE(IF(SUBSTR(birth_date, 3, 1) = '/', CONCAT(RIGHT(birth_date, 4), '-', SUBSTR(birth_date, 4, 2), '-', LEFT(birth_date, 2)), birth_date))
WHERE DATE(IF(SUBSTR(birth_date, 3, 1) = '/', CONCAT(RIGHT(birth_date, 4), '-', SUBSTR(birth_date, 4, 2), '-', LEFT(birth_date, 2)), birth_date)) IS NOT NULL

#01-01-2000
UPDATE tbl_player SET birth_date = DATE(IF(SUBSTR(birth_date, 3, 1) = '-', CONCAT(RIGHT(birth_date, 4), '-', SUBSTR(birth_date, 4, 2), '-', LEFT(birth_date, 2)), birth_date))
WHERE DATE(IF(SUBSTR(birth_date, 3, 1) = '-', CONCAT(RIGHT(birth_date, 4), '-', SUBSTR(birth_date, 4, 2), '-', LEFT(birth_date, 2)), birth_date)) IS NOT NULL

#januari
UPDATE tbl_player SET birth_date = REPLACE(REPLACE(LOWER(birth_date), ' ', '-'), 'januari', '01')
WHERE LOWER(birth_date) LIKE '%januari%';

SELECT REPLACE(REPLACE(LOWER(birth_date), ' ', '-'), 'januari', '01') FROM tbl_player
WHERE LOWER(birth_date) LIKE '%januari%';

#februari
UPDATE tbl_player SET birth_date = REPLACE(REPLACE(REPLACE(REPLACE(LOWER(birth_date), 'february', 'februari'), 'febuari', 'februari'), ' ', '-'), 'februari', '02')
WHERE REPLACE(REPLACE(LOWER(birth_date), 'february', 'februari'), 'febuari', 'februari') LIKE '%februari%';

SELECT REPLACE(REPLACE(REPLACE(REPLACE(LOWER(birth_date), 'february', 'februari'), 'febuari', 'februari'), ' ', '-'), 'februari', '02') FROM tbl_player
WHERE REPLACE(REPLACE(LOWER(birth_date), 'february', 'februari'), 'febuari', 'februari') LIKE '%februari%';

#maret
UPDATE tbl_player SET birth_date = REPLACE(REPLACE(LOWER(birth_date), ' ', '-'), 'maret', '03')
WHERE LOWER(birth_date) LIKE '%maret%';

SELECT REPLACE(REPLACE(LOWER(birth_date), ' ', '-'), 'maret', '03') FROM tbl_player
WHERE LOWER(birth_date) LIKE '%maret%';

#april
UPDATE tbl_player SET birth_date = REPLACE(REPLACE(LOWER(birth_date), ' ', '-'), 'april', '04')
WHERE LOWER(birth_date) LIKE '%april%';

SELECT REPLACE(REPLACE(LOWER(birth_date), ' ', '-'), 'april', '04') FROM tbl_player
WHERE LOWER(birth_date) LIKE '%april%';

#mei
UPDATE tbl_player SET birth_date = REPLACE(REPLACE(LOWER(birth_date), ' ', '-'), 'mei', '05')
WHERE LOWER(birth_date) LIKE '%mei%';

SELECT REPLACE(REPLACE(LOWER(birth_date), ' ', '-'), 'mei', '05') FROM tbl_player
WHERE LOWER(birth_date) LIKE '%mei%';

#juni
UPDATE tbl_player SET birth_date = REPLACE(REPLACE(LOWER(birth_date), ' ', '-'), 'juni', '06')
WHERE LOWER(birth_date) LIKE '%juni%';

SELECT REPLACE(REPLACE(LOWER(birth_date), ' ', '-'), 'juni', '06') FROM tbl_player
WHERE LOWER(birth_date) LIKE '%juni%';

#juli
UPDATE tbl_player SET birth_date = REPLACE(REPLACE(LOWER(birth_date), ' ', '-'), 'juli', '07')
WHERE LOWER(birth_date) LIKE '%juli%';

SELECT REPLACE(REPLACE(LOWER(birth_date), ' ', '-'), 'juli', '07') FROM tbl_player
WHERE LOWER(birth_date) LIKE '%juli%';

#agustus
UPDATE tbl_player SET birth_date = REPLACE(REPLACE(LOWER(birth_date), ' ', '-'), 'agustus', '08')
WHERE LOWER(birth_date) LIKE '%agustus%';

SELECT REPLACE(REPLACE(LOWER(birth_date), ' ', '-'), 'agustus', '08') FROM tbl_player
WHERE LOWER(birth_date) LIKE '%agustus%';

#september
UPDATE tbl_player SET birth_date = REPLACE(REPLACE(LOWER(birth_date), ' ', '-'), 'september', '09')
WHERE LOWER(birth_date) LIKE '%september%';

SELECT REPLACE(REPLACE(LOWER(birth_date), ' ', '-'), 'september', '09') FROM tbl_player
WHERE LOWER(birth_date) LIKE '%september%';

#oktober
UPDATE tbl_player SET birth_date = REPLACE(REPLACE(LOWER(birth_date), ' ', '-'), 'oktober', '10')
WHERE LOWER(birth_date) LIKE '%oktober%';

SELECT REPLACE(REPLACE(LOWER(birth_date), ' ', '-'), 'oktober', '10') FROM tbl_player
WHERE LOWER(birth_date) LIKE '%oktober%';

#november
UPDATE tbl_player SET birth_date = REPLACE(REPLACE(REPLACE(LOWER(birth_date), 'nopember', 'november'), ' ', '-'), 'november', '11')
WHERE REPLACE(LOWER(birth_date), 'nopember', 'november') LIKE '%november%';

SELECT REPLACE(REPLACE(REPLACE(LOWER(birth_date), 'nopember', 'november'), ' ', '-'), 'november', '11') FROM tbl_player
WHERE REPLACE(LOWER(birth_date), 'nopember', 'november') LIKE '%november%';

#desember
UPDATE tbl_player SET birth_date = REPLACE(REPLACE(LOWER(birth_date), ' ', '-'), 'desember', '12')
WHERE LOWER(birth_date) LIKE '%desember%';

SELECT REPLACE(REPLACE(LOWER(birth_date), ' ', '-'), 'desember', '12') FROM tbl_player
WHERE LOWER(birth_date) LIKE '%desember%';

#01-01-2000
UPDATE tbl_player SET birth_date = DATE(IF(SUBSTR(birth_date, 3, 1) = '-', CONCAT(RIGHT(birth_date, 4), '-', SUBSTR(birth_date, 4, 2), '-', LEFT(birth_date, 2)), birth_date))
WHERE DATE(IF(SUBSTR(birth_date, 3, 1) = '-', CONCAT(RIGHT(birth_date, 4), '-', SUBSTR(birth_date, 4, 2), '-', LEFT(birth_date, 2)), birth_date)) IS NOT NULL

#1-01-2000
UPDATE tbl_player SET birth_date = DATE(IF(SUBSTR(birth_date, 2, 1) = '-', CONCAT(RIGHT(birth_date, 4), '-', SUBSTR(birth_date, 3, 2), '-0', LEFT(birth_date, 1)), birth_date))
WHERE DATE(IF(SUBSTR(birth_date, 2, 1) = '-', CONCAT(RIGHT(birth_date, 4), '-', SUBSTR(birth_date, 3, 2), '-0', LEFT(birth_date, 1)), birth_date)) IS NOT NULL

#01-1-2000
UPDATE tbl_player SET birth_date = DATE(IF(SUBSTR(birth_date, 3, 1) = '-', CONCAT(RIGHT(birth_date, 4), '-0', SUBSTR(birth_date, 4, 1), '-', LEFT(birth_date, 2)), birth_date))
WHERE DATE(IF(SUBSTR(birth_date, 3, 1) = '-', CONCAT(RIGHT(birth_date, 4), '-0', SUBSTR(birth_date, 4, 1), '-', LEFT(birth_date, 2)), birth_date)) IS NOT NULL

#1-1-2000
UPDATE tbl_player SET birth_date = DATE(IF(SUBSTR(birth_date, 2, 1) = '-', CONCAT(RIGHT(birth_date, 4), '-0', SUBSTR(birth_date, 3, 1), '-0', LEFT(birth_date, 1)), birth_date))
WHERE DATE(IF(SUBSTR(birth_date, 2, 1) = '-', CONCAT(RIGHT(birth_date, 4), '-0', SUBSTR(birth_date, 3, 1), '-0', LEFT(birth_date, 1)), birth_date)) IS NOT NULL

#1/01/2000
UPDATE tbl_player SET birth_date = DATE(IF(SUBSTR(birth_date, 2, 1) = '/', CONCAT(RIGHT(birth_date, 4), '-', SUBSTR(birth_date, 3, 2), '-0', LEFT(birth_date, 1)), birth_date))
WHERE DATE(IF(SUBSTR(birth_date, 2, 1) = '/', CONCAT(RIGHT(birth_date, 4), '-', SUBSTR(birth_date, 3, 2), '-0', LEFT(birth_date, 1)), birth_date)) IS NOT NULL

#01/1/2000
UPDATE tbl_player SET birth_date = DATE(IF(SUBSTR(birth_date, 3, 1) = '/', CONCAT(RIGHT(birth_date, 4), '-0', SUBSTR(birth_date, 4, 1), '-', LEFT(birth_date, 2)), birth_date))
WHERE DATE(IF(SUBSTR(birth_date, 3, 1) = '/', CONCAT(RIGHT(birth_date, 4), '-0', SUBSTR(birth_date, 4, 1), '-', LEFT(birth_date, 2)), birth_date)) IS NOT NULL

#1/1/2000
UPDATE tbl_player SET birth_date = DATE(IF(SUBSTR(birth_date, 2, 1) = '/', CONCAT(RIGHT(birth_date, 4), '-0', SUBSTR(birth_date, 3, 1), '-0', LEFT(birth_date, 1)), birth_date))
WHERE DATE(IF(SUBSTR(birth_date, 2, 1) = '/', CONCAT(RIGHT(birth_date, 4), '-0', SUBSTR(birth_date, 3, 1), '-0', LEFT(birth_date, 1)), birth_date)) IS NOT NULL

#01012000
UPDATE tbl_player SET birth_date = DATE(IF(SUBSTR(birth_date, 3, 1) != '' AND SUBSTR(birth_date, 3, 1) >= 0, CONCAT(RIGHT(birth_date, 4), '-', SUBSTR(birth_date, 3, 2), '-', LEFT(birth_date, 2)), birth_date))
WHERE DATE(IF(SUBSTR(birth_date, 3, 1) = '-', CONCAT(RIGHT(birth_date, 4), '-', SUBSTR(birth_date, 4, 2), '-', LEFT(birth_date, 2)), birth_date)) IS NULL

#bugs
SELECT LOWER(birth_date) FROM tbl_player
WHERE DATE(IF(SUBSTR(birth_date, 3, 1) = '-', CONCAT(RIGHT(birth_date, 4), '-', SUBSTR(birth_date, 4, 2), '-', LEFT(birth_date, 2)), birth_date)) IS NULL;