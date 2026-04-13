-- 1. Add new column for duration
ALTER TABLE available_exams
ADD exam_duration TIME;

-- 2. Rename 'subject' to 'exam_name'
ALTER TABLE available_exams
CHANGE subject exam_name VARCHAR(255);
