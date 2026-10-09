-- =========================================
-- PatientService (MySQL) – DB + Tables + Seed (NO explicit insert into AUTO_INCREMENT IDs)
-- =========================================
DROP DATABASE IF EXISTS patient_service_db;
CREATE DATABASE patient_service_db
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_0900_ai_ci;
USE patient_service_db;

-- ============== TABLES ==============

-- Patient
CREATE TABLE Patient (
  PatientID     INT AUTO_INCREMENT PRIMARY KEY,
  full_name     VARCHAR(120) NOT NULL,
  phone_number  VARCHAR(20)  NOT NULL UNIQUE,  -- match AuthService.login_key (PATIENT)
  email         VARCHAR(150) UNIQUE,
  citizen_id    VARCHAR(30)  UNIQUE,
  date_of_birth DATE,
  gender        ENUM('Male','Female','Other') NOT NULL,
  address       VARCHAR(255),
  nationality   VARCHAR(80),
  ethnicity     VARCHAR(80),
  occupation    VARCHAR(80),
  allergy       TEXT,
  CreatedAt     TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  UpdatedAt     TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- MedicalVisit
CREATE TABLE MedicalVisit (
  MedicalVisitID INT AUTO_INCREMENT PRIMARY KEY,
  PatientID      INT NOT NULL,
  DoctorID       INT NOT NULL,   -- EmployeeService.EmployeeID (doctors: 1..10)
  DepartmentID   INT NOT NULL,   -- EmployeeService.Departments.DepartmentID (1..10)
  visit_date     DATETIME NOT NULL,
  diagnosis      TEXT,
  symptoms       TEXT,
  notes          TEXT,
  CreatedAt      TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  UpdatedAt      TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_visit_patient
    FOREIGN KEY (PatientID) REFERENCES Patient(PatientID) ON DELETE CASCADE
) ENGINE=InnoDB;
CREATE INDEX idx_visit_patient     ON MedicalVisit(PatientID);
CREATE INDEX idx_visit_doctor      ON MedicalVisit(DoctorID);
CREATE INDEX idx_visit_department  ON MedicalVisit(DepartmentID);
CREATE INDEX idx_visit_date        ON MedicalVisit(visit_date);

-- Prescription
CREATE TABLE Prescription (
  PrescriptionID INT AUTO_INCREMENT PRIMARY KEY,
  MedicalVisitID INT NOT NULL,
  notes          TEXT,
  status         ENUM('NEW','IN_PROGRESS','COMPLETED','CANCELLED') DEFAULT 'NEW',
  date           DATETIME NOT NULL,
  CreatedAt      TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  UpdatedAt      TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_rx_visit
    FOREIGN KEY (MedicalVisitID) REFERENCES MedicalVisit(MedicalVisitID) ON DELETE CASCADE
) ENGINE=InnoDB;
CREATE INDEX idx_rx_visit ON Prescription(MedicalVisitID);

-- PrescriptionDetails
CREATE TABLE PrescriptionDetails (
  PrescriptionDetailID INT AUTO_INCREMENT PRIMARY KEY,
  PrescriptionID       INT NOT NULL,
  medicine_id          INT NOT NULL,  -- INT (sẽ FK sang Catalog sau)
  dosage               VARCHAR(100) NOT NULL,
  duration             VARCHAR(100),
  CreatedAt            TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  UpdatedAt            TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_rxd_rx
    FOREIGN KEY (PrescriptionID) REFERENCES Prescription(PrescriptionID) ON DELETE CASCADE
) ENGINE=InnoDB;
CREATE INDEX idx_rxd_rx ON PrescriptionDetails(PrescriptionID);

-- FollowUp
CREATE TABLE FollowUp (
  FollowUpID     INT AUTO_INCREMENT PRIMARY KEY,
  MedicalVisitID INT NOT NULL,
  date           DATETIME NOT NULL,
  notes          TEXT,
  CreatedAt      TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  UpdatedAt      TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_fu_visit
    FOREIGN KEY (MedicalVisitID) REFERENCES MedicalVisit(MedicalVisitID) ON DELETE CASCADE
) ENGINE=InnoDB;
CREATE INDEX idx_fu_visit ON FollowUp(MedicalVisitID);

-- Order
CREATE TABLE `Order` (
  OrderID        INT AUTO_INCREMENT PRIMARY KEY,
  MedicalVisitID INT NOT NULL,
  TestID         VARCHAR(30) NOT NULL,  -- (sẽ đổi sang INT khi Catalog.Test dùng INT)
  EmployeeID     INT NOT NULL,          -- EmployeeService.EmployeeID (staff: 11..20)
  OrderDate      DATETIME NOT NULL,
  Status         ENUM('PENDING','IN_PROGRESS','COMPLETED','CANCELLED') DEFAULT 'PENDING',
  Result         TEXT,
  DetailsURL     VARCHAR(255),
  CreatedAt      TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  UpdatedAt      TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_order_visit
    FOREIGN KEY (MedicalVisitID) REFERENCES MedicalVisit(MedicalVisitID) ON DELETE CASCADE
) ENGINE=InnoDB;
CREATE INDEX idx_order_visit    ON `Order`(MedicalVisitID);
CREATE INDEX idx_order_employee ON `Order`(EmployeeID);

-- ============== SEED ==============
-- Mapping tạm thời cho medicine_id (INT):
-- 1=Losartan 50, 2=Sumatriptan 50, 3=Hydrocortisone 1% cream,
-- 4=Cetirizine 10, 5=H. pylori Triple Therapy pack, 6=Levothyroxine 50 mcg

-- Patients (KHÔNG chèn PatientID)
INSERT INTO Patient (full_name, phone_number, email, citizen_id, date_of_birth, gender, address, nationality, ethnicity, occupation, allergy) VALUES
('Oliver Stone',     '+84903000001','patient01@gmail.com','CZN-00001','1990-01-15','Male',   '12 Nguyen Trai, District 5, HCMC','Vietnamese','Kinh','Engineer','Penicillin'),
('Amelia Johnson',   '+84903000002','patient02@gmail.com','CZN-00002','1992-03-22','Female', '45 Le Loi, District 1, HCMC','Vietnamese','Kinh','Teacher',NULL),
('Noah Williams',    '+84903000003','patient03@gmail.com','CZN-00003','1988-07-09','Male',   '7 Tran Hung Dao, District 1','Vietnamese','Kinh','Accountant','Seafood'),
('Sophia Brown',     '+84903000004','patient04@gmail.com','CZN-00004','1995-10-30','Female', '89 Hai Ba Trung, HCMC','Vietnamese','Kinh','Designer',NULL),
('Liam Davis',       '+84903000005','patient05@gmail.com','CZN-00005','1986-05-05','Male',   '21 Phan Xich Long, Phu Nhuan','Vietnamese','Kinh','Sales',NULL),
('Emma Wilson',      '+84903000006','patient06@gmail.com','CZN-00006','1993-11-18','Female', '55 Nguyen Thi Minh Khai, HCMC','Vietnamese','Kinh','Nurse','Latex'),
('James Taylor',     '+84903000007','patient07@gmail.com','CZN-00007','1984-02-08','Male',   '3 Vo Thi Sau, District 3','Vietnamese','Kinh','Driver',NULL),
('Mia Anderson',     '+84903000008','patient08@gmail.com','CZN-00008','1997-06-14','Female', '100 Cach Mang Thang 8, HCMC','Vietnamese','Kinh','Student',NULL),
('William Martinez', '+84903000009','patient09@gmail.com','CZN-00009','1982-09-27','Male',   '4 Nguyen Hue, District 1','Vietnamese','Kinh','Chef','Peanut'),
('Charlotte Thomas', '+84903000010','patient10@gmail.com','CZN-00010','1991-12-12','Female', '77 Pasteur, District 3','Vietnamese','Kinh','Office Clerk',NULL);

-- Medical visits (KHÔNG chèn MedicalVisitID; tham chiếu PatientID qua phone_number)
INSERT INTO MedicalVisit (PatientID, DoctorID, DepartmentID, visit_date, diagnosis, symptoms, notes) VALUES
((SELECT PatientID FROM Patient WHERE phone_number='+84903000001'), 1,  6,'2025-01-10 09:05:00','Hypertension, Stage 1','Headache, dizziness','Start lifestyle modification, monitor BP.'),
((SELECT PatientID FROM Patient WHERE phone_number='+84903000002'), 2,  7,'2025-01-11 10:20:00','Migraine without aura','Pulsating headache, photophobia','Keep headache diary; avoid triggers.'),
((SELECT PatientID FROM Patient WHERE phone_number='+84903000003'), 3,  4,'2025-01-12 08:40:00','Acute pharyngitis','Sore throat, low-grade fever','Supportive care; rapid strep negative.'),
((SELECT PatientID FROM Patient WHERE phone_number='+84903000004'), 4,  8,'2025-01-13 14:10:00','Right ankle sprain','Swelling, pain after twisting','RICE, ankle brace, physiotherapy.'),
((SELECT PatientID FROM Patient WHERE phone_number='+84903000005'), 7,  9,'2025-01-14 15:00:00','Atopic dermatitis flare','Itchy eczematous patches','Topical steroid short course; moisturizers.'),
((SELECT PatientID FROM Patient WHERE phone_number='+84903000006'), 5,  5,'2025-01-15 09:30:00','Antenatal check, 20 weeks','Nausea improving','Ultrasound scheduled; prenatal vitamins.'),
((SELECT PatientID FROM Patient WHERE phone_number='+84903000007'), 8,  3,'2025-01-16 11:00:00','Allergic rhinitis','Sneezing, nasal congestion','Nasal saline; consider antihistamine.'),
((SELECT PatientID FROM Patient WHERE phone_number='+84903000008'), 6, 10,'2025-01-17 13:45:00','Imaging consult','Back pain','Lumbar MRI suggested if symptoms persist.'),
((SELECT PatientID FROM Patient WHERE phone_number='+84903000009'), 9,  2,'2025-01-18 16:20:00','Dyspepsia, r/o H. pylori','Epigastric pain','Order H. pylori test; diet advice.'),
((SELECT PatientID FROM Patient WHERE phone_number='+84903000010'),10, 2,'2025-01-19 09:10:00','Hypothyroidism, suspected','Fatigue, weight gain','Order TSH, FT4; start levothyroxine if confirmed.');

-- Prescriptions (KHÔNG chèn PrescriptionID; tham chiếu MedicalVisit bằng subquery)
INSERT INTO Prescription (MedicalVisitID, notes, status, date) VALUES
((SELECT MedicalVisitID FROM MedicalVisit WHERE PatientID=(SELECT PatientID FROM Patient WHERE phone_number='+84903000001') AND visit_date='2025-01-10 09:05:00'),'BP monitor at home; follow-up in 4 weeks.','IN_PROGRESS','2025-01-10 09:15:00'),
((SELECT MedicalVisitID FROM MedicalVisit WHERE PatientID=(SELECT PatientID FROM Patient WHERE phone_number='+84903000002') AND visit_date='2025-01-11 10:20:00'),'Abortive therapy for migraine; hydration.','NEW','2025-01-11 10:35:00'),
((SELECT MedicalVisitID FROM MedicalVisit WHERE PatientID=(SELECT PatientID FROM Patient WHERE phone_number='+84903000005') AND visit_date='2025-01-14 15:00:00'),'Topicals for eczema.','NEW','2025-01-14 15:10:00'),
((SELECT MedicalVisitID FROM MedicalVisit WHERE PatientID=(SELECT PatientID FROM Patient WHERE phone_number='+84903000007') AND visit_date='2025-01-16 11:00:00'),'Symptomatic relief for rhinitis.','NEW','2025-01-16 11:15:00'),
((SELECT MedicalVisitID FROM MedicalVisit WHERE PatientID=(SELECT PatientID FROM Patient WHERE phone_number='+84903000009') AND visit_date='2025-01-18 16:20:00'),'Eradication therapy if H. pylori positive.','NEW','2025-01-18 16:35:00'),
((SELECT MedicalVisitID FROM MedicalVisit WHERE PatientID=(SELECT PatientID FROM Patient WHERE phone_number='+84903000010') AND visit_date='2025-01-19 09:10:00'),'Thyroid work-up; medication if needed.','NEW','2025-01-19 09:20:00');

-- Prescription details (KHÔNG chèn PrescriptionDetailID; link Prescription bằng (MedicalVisitID, date))
-- RX for patient '+84903000001' (Hypertension) @ 2025-01-10 09:15:00
INSERT INTO PrescriptionDetails (PrescriptionID, medicine_id, dosage, duration) VALUES
((SELECT PrescriptionID FROM Prescription WHERE MedicalVisitID=(SELECT MedicalVisitID FROM MedicalVisit WHERE PatientID=(SELECT PatientID FROM Patient WHERE phone_number='+84903000001') AND visit_date='2025-01-10 09:05:00') AND date='2025-01-10 09:15:00'), 1, '1 tablet orally once daily','30 days'),
((SELECT PrescriptionID FROM Prescription WHERE MedicalVisitID=(SELECT MedicalVisitID FROM MedicalVisit WHERE PatientID=(SELECT PatientID FROM Patient WHERE phone_number='+84903000001') AND visit_date='2025-01-10 09:05:00') AND date='2025-01-10 09:15:00'), 4, '1 tablet at night as needed for allergy','14 days');

-- RX for '+84903000002' (Migraine) @ 2025-01-11 10:35:00
INSERT INTO PrescriptionDetails (PrescriptionID, medicine_id, dosage, duration) VALUES
((SELECT PrescriptionID FROM Prescription WHERE MedicalVisitID=(SELECT MedicalVisitID FROM MedicalVisit WHERE PatientID=(SELECT PatientID FROM Patient WHERE phone_number='+84903000002') AND visit_date='2025-01-11 10:20:00') AND date='2025-01-11 10:35:00'), 2, '1 tablet at onset; may repeat after 2h','Max 200 mg/day'),
((SELECT PrescriptionID FROM Prescription WHERE MedicalVisitID=(SELECT MedicalVisitID FROM MedicalVisit WHERE PatientID=(SELECT PatientID FROM Patient WHERE phone_number='+84903000002') AND visit_date='2025-01-11 10:20:00') AND date='2025-01-11 10:35:00'), 4, '1 tablet at night if allergic triggers present','10 days');

-- RX for '+84903000005' (Eczema) @ 2025-01-14 15:10:00
INSERT INTO PrescriptionDetails (PrescriptionID, medicine_id, dosage, duration) VALUES
((SELECT PrescriptionID FROM Prescription WHERE MedicalVisitID=(SELECT MedicalVisitID FROM MedicalVisit WHERE PatientID=(SELECT PatientID FROM Patient WHERE phone_number='+84903000005') AND visit_date='2025-01-14 15:00:00') AND date='2025-01-14 15:10:00'), 3, 'Apply thin layer to lesions twice daily','7 days'),
((SELECT PrescriptionID FROM Prescription WHERE MedicalVisitID=(SELECT MedicalVisitID FROM MedicalVisit WHERE PatientID=(SELECT PatientID FROM Patient WHERE phone_number='+84903000005') AND visit_date='2025-01-14 15:00:00') AND date='2025-01-14 15:10:00'), 4, '1 tablet nightly to reduce itch','7 days');

-- RX for '+84903000007' (Allergic rhinitis) @ 2025-01-16 11:15:00
INSERT INTO PrescriptionDetails (PrescriptionID, medicine_id, dosage, duration) VALUES
((SELECT PrescriptionID FROM Prescription WHERE MedicalVisitID=(SELECT MedicalVisitID FROM MedicalVisit WHERE PatientID=(SELECT PatientID FROM Patient WHERE phone_number='+84903000007') AND visit_date='2025-01-16 11:00:00') AND date='2025-01-16 11:15:00'), 4, '1 tablet at night','14 days'),
((SELECT PrescriptionID FROM Prescription WHERE MedicalVisitID=(SELECT MedicalVisitID FROM MedicalVisit WHERE PatientID=(SELECT PatientID FROM Patient WHERE phone_number='+84903000007') AND visit_date='2025-01-16 11:00:00') AND date='2025-01-16 11:15:00'), 3, 'Apply thin layer to irritated perinasal skin','5 days');

-- RX for '+84903000009' (H. pylori) @ 2025-01-18 16:35:00
INSERT INTO PrescriptionDetails (PrescriptionID, medicine_id, dosage, duration) VALUES
((SELECT PrescriptionID FROM Prescription WHERE MedicalVisitID=(SELECT MedicalVisitID FROM MedicalVisit WHERE PatientID=(SELECT PatientID FROM Patient WHERE phone_number='+84903000009') AND visit_date='2025-01-18 16:20:00') AND date='2025-01-18 16:35:00'), 5, 'Use as per pack instructions','14 days');

-- RX for '+84903000010' (Hypothyroidism) @ 2025-01-19 09:20:00
INSERT INTO PrescriptionDetails (PrescriptionID, medicine_id, dosage, duration) VALUES
((SELECT PrescriptionID FROM Prescription WHERE MedicalVisitID=(SELECT MedicalVisitID FROM MedicalVisit WHERE PatientID=(SELECT PatientID FROM Patient WHERE phone_number='+84903000010') AND visit_date='2025-01-19 09:10:00') AND date='2025-01-19 09:20:00'), 6, '1 tablet every morning before breakfast','30 days');

-- Follow-ups (KHÔNG chèn FollowUpID)
INSERT INTO FollowUp (MedicalVisitID, date, notes) VALUES
((SELECT MedicalVisitID FROM MedicalVisit WHERE PatientID=(SELECT PatientID FROM Patient WHERE phone_number='+84903000001') AND visit_date='2025-01-10 09:05:00'), '2025-02-07 09:00:00','Review home BP log; adjust medication if needed.'),
((SELECT MedicalVisitID FROM MedicalVisit WHERE PatientID=(SELECT PatientID FROM Patient WHERE phone_number='+84903000002') AND visit_date='2025-01-11 10:20:00'), '2025-01-25 10:00:00','Assess frequency/severity; check for side effects.'),
((SELECT MedicalVisitID FROM MedicalVisit WHERE PatientID=(SELECT PatientID FROM Patient WHERE phone_number='+84903000006') AND visit_date='2025-01-15 09:30:00'), '2025-02-12 09:30:00','Routine antenatal follow-up.'),
((SELECT MedicalVisitID FROM MedicalVisit WHERE PatientID=(SELECT PatientID FROM Patient WHERE phone_number='+84903000009') AND visit_date='2025-01-18 16:20:00'), '2025-02-01 16:00:00','Discuss H. pylori test result and next steps.'),
((SELECT MedicalVisitID FROM MedicalVisit WHERE PatientID=(SELECT PatientID FROM Patient WHERE phone_number='+84903000010') AND visit_date='2025-01-19 09:10:00'), '2025-02-02 09:00:00','Review thyroid labs and titrate dose.');

-- Orders (KHÔNG chèn OrderID)
INSERT INTO `Order` (MedicalVisitID, TestID, EmployeeID, OrderDate, Status, Result, DetailsURL) VALUES
((SELECT MedicalVisitID FROM MedicalVisit WHERE PatientID=(SELECT PatientID FROM Patient WHERE phone_number='+84903000008') AND visit_date='2025-01-17 13:45:00'), 'MRI-LUMBAR',    12,'2025-01-17 14:00:00','PENDING',    NULL,      'https://example-hospital.test/orders/1'),
((SELECT MedicalVisitID FROM MedicalVisit WHERE PatientID=(SELECT PatientID FROM Patient WHERE phone_number='+84903000009') AND visit_date='2025-01-18 16:20:00'), 'HP-UREA-BREATH',15,'2025-01-18 16:40:00','COMPLETED',  'Negative','https://example-hospital.test/orders/2'),
((SELECT MedicalVisitID FROM MedicalVisit WHERE PatientID=(SELECT PatientID FROM Patient WHERE phone_number='+84903000010') AND visit_date='2025-01-19 09:10:00'), 'LAB-TSH-FT4',   19,'2025-01-19 09:25:00','IN_PROGRESS',NULL,      'https://example-hospital.test/orders/3');
