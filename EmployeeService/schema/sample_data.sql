INSERT INTO departments ("DepartmentName", "Description", "created_at", "updated_at")
VALUES
('General Internal Medicine', 'Diagnosis and treatment of general internal diseases', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
('Pediatrics', 'Examination and treatment for children', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
('Surgery', 'Surgical operations and treatment of surgical diseases', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
('Obstetrics & Gynecology', 'Prenatal care, childbirth, and reproductive health services', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
('Otolaryngology (ENT)', 'Diagnosis and treatment of ear, nose, and throat diseases', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
('Dentistry', 'Dental and oral health care', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
('Dermatology', 'Diagnosis and treatment of skin diseases', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
('Cardiology', 'Diagnosis and treatment of cardiovascular diseases', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
('Emergency & Intensive Care', 'Emergency services and intensive care treatment', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
('Laboratory', 'Biochemistry, hematology, and microbiology testing', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);

INSERT INTO weekdays ("WeekdayName", created_at, updated_at)
VALUES
('Monday', NOW(), NOW()),
('Tuesday', NOW(), NOW()),
('Wednesday', NOW(), NOW()),
('Thursday', NOW(), NOW()),
('Friday', NOW(), NOW()),
('Saturday', NOW(), NOW()),
('Sunday', NOW(), NOW());

INSERT INTO rooms ("RoomName", "Floor", created_at, updated_at)
VALUES
('Room 101', 1, NOW(), NOW()),
('Room 102', 1, NOW(), NOW()),
('Room 201', 2, NOW(), NOW()),
('Room 202', 2, NOW(), NOW()),
('Room 301', 3, NOW(), NOW()),
('Room 302', 3, NOW(), NOW()),
('Room 401', 4, NOW(), NOW()),
('Room 402', 4, NOW(), NOW()),
('Room 501', 5, NOW(), NOW()),
('Room 502', 5, NOW(), NOW());

INSERT INTO shifts ("ShiftName", "StartTime", "EndTime", created_at, updated_at)
VALUES
('Shift 1',  '09:00', '09:30', NOW(), NOW()),
('Shift 2',  '09:30', '10:00', NOW(), NOW()),
('Shift 3',  '10:00', '10:30', NOW(), NOW()),
('Shift 4',  '10:30', '11:00', NOW(), NOW()),
('Shift 5',  '11:00', '11:30', NOW(), NOW()),
-- nghỉ trưa từ 11:30 -> 13:00
('Shift 6',  '13:00', '13:30', NOW(), NOW()),
('Shift 7',  '13:30', '14:00', NOW(), NOW()),
('Shift 8',  '14:00', '14:30', NOW(), NOW()),
('Shift 9',  '14:30', '15:00', NOW(), NOW()),
('Shift 10', '15:00', '15:30', NOW(), NOW()),
('Shift 11', '15:30', '16:00', NOW(), NOW()),
('Shift 12', '16:00', '16:30', NOW(), NOW()),
('Shift 13', '16:30', '17:00', NOW(), NOW()),
('Shift 14', '17:00', '17:30', NOW(), NOW()),
('Shift 15', '17:30', '18:00', NOW(), NOW());

INSERT INTO employees ("FullName", "Gender", "DOB", "PhoneNumber", "Email", "DepartmentID", "AvatarURL", "Role", "Status", created_at, updated_at)
VALUES
('Nguyen Van A', 'Male', '1980-05-10', '0901111111', 'vana@example.com', 1, NULL, 'Doctor', 'Active', NOW(), NOW()),
('Tran Thi B', 'Female', '1985-09-12', '0902222222', 'thib@example.com', 1, NULL, 'Doctor', 'Active', NOW(), NOW()),
('Le Van C', 'Male', '1990-07-01', '0903333333', 'vanc@example.com', 2, NULL, 'Doctor', 'Active', NOW(), NOW()),
('Pham Thi D', 'Female', '1992-03-18', '0904444444', 'thid@example.com', 2, NULL, 'Doctor', 'Active', NOW(), NOW()),
('Hoang Van E', 'Male', '1988-12-25', '0905555555', 'vane@example.com', 3, NULL, 'Doctor', 'Active', NOW(), NOW());

INSERT INTO doctors ("EmployeeID", "SpecialityID", "LicenseNumber", "RoomID", created_at, updated_at)
VALUES
(1, 1, 'LIC-001', 1, NOW(), NOW()),  -- Nguyen Van A, Cardiology
(2, 2, 'LIC-002', 2, NOW(), NOW()),  -- Tran Thi B, Neurology
(3, 3, 'LIC-003', 3, NOW(), NOW()),  -- Le Van C, Pediatrics
(4, 4, 'LIC-004', 4, NOW(), NOW()),  -- Pham Thi D, Dermatology
(5, 5, 'LIC-005', 5, NOW(), NOW());  -- Hoang Van E, Orthopedics

INSERT INTO specialities ("SpecialityName", "Description", "DepartmentID", created_at, updated_at)
VALUES
('Cardiology', 'Heart and blood vessel treatment', 1, NOW(), NOW()),
('Neurology', 'Brain and nervous system treatment', 1, NOW(), NOW()),
('Pediatrics', 'Healthcare for children', 2, NOW(), NOW()),
('Dermatology', 'Skin-related treatment', 2, NOW(), NOW()),
('Orthopedics', 'Bone and muscle treatment', 3, NOW(), NOW());

-- Thứ 2
INSERT INTO doctor_schedules ("DoctorID", "WeekdayID", "ShiftID", created_at, updated_at)
SELECT 1, 1, "ShiftID", NOW(), NOW() FROM shifts;

-- Thứ 4
INSERT INTO doctor_schedules ("DoctorID", "WeekdayID", "ShiftID", created_at, updated_at)
SELECT 1, 3, "ShiftID", NOW(), NOW() FROM shifts;

-- Thứ 6
INSERT INTO doctor_schedules ("DoctorID", "WeekdayID", "ShiftID", created_at, updated_at)
SELECT 1, 5, "ShiftID", NOW(), NOW() FROM shifts;

-- Thứ 3
INSERT INTO doctor_schedules ("DoctorID", "WeekdayID", "ShiftID", created_at, updated_at)
SELECT 2, 2, "ShiftID", NOW(), NOW() FROM shifts;

-- Thứ 5
INSERT INTO doctor_schedules ("DoctorID", "WeekdayID", "ShiftID", created_at, updated_at)
SELECT 2, 4, "ShiftID", NOW(), NOW() FROM shifts;

INSERT INTO doctor_schedules ("DoctorID", "WeekdayID", "ShiftID", created_at, updated_at)
SELECT 3, w."WeekdayID", s."ShiftID", NOW(), NOW()
FROM weekdays w
JOIN shifts s ON s."ShiftID" <= 5
WHERE w."WeekdayName" IN ('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
