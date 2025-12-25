-- Team MacAtac
-- INFS 3400 - Final Project
-- Hospital Inpatient Information System (HIIS)

DROP DATABASE IF EXISTS HIIS;
CREATE DATABASE HIIS;
USE HIIS;

CREATE TABLE Specialties (
    SID VARCHAR(10) PRIMARY KEY,
    SName VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE Doctors (
    DocID VARCHAR(10) PRIMARY KEY,
    FName VARCHAR(50) NOT NULL,
    LName VARCHAR(50) NOT NULL,
    DeptID VARCHAR(10)
);

CREATE TABLE Departments (
    DeptID VARCHAR(10) PRIMARY KEY,
    DeptName VARCHAR(50) NOT NULL,
    BldgName VARCHAR(50) NOT NULL,
    FloorNum VARCHAR(3) NOT NULL,
    DeptHead VARCHAR(10) NOT NULL,
    FOREIGN KEY (DeptHead) REFERENCES Doctors(DocID)
);

CREATE TABLE Doctor_Specialties (
    DocID VARCHAR(10) NOT NULL,
    SID VARCHAR(10) NOT NULL,
    PRIMARY KEY (DocID, SID),
    FOREIGN KEY (DocID) REFERENCES Doctors(DocID),
    FOREIGN KEY (SID) REFERENCES Specialties(SID)
);

CREATE TABLE Patients (
    PID VARCHAR(10) PRIMARY KEY,
    FName VARCHAR(50) NOT NULL,
    LName VARCHAR(50) NOT NULL,
    DOB DATE NOT NULL,
    Phone VARCHAR(20),
    Email VARCHAR(100)
);

CREATE TABLE Emergency_Contacts (
    ECID VARCHAR(10) PRIMARY KEY,
    FName VARCHAR(50) NOT NULL,
    LName VARCHAR(50) NOT NULL,
    Phone VARCHAR(20) NOT NULL,
    Email VARCHAR(100),
    Relationship VARCHAR(30) NOT NULL
);

CREATE TABLE Admissions (
    AID VARCHAR(10) PRIMARY KEY,
    InDate DATE NOT NULL,
    OutDate DATE,
    PID VARCHAR(10) NOT NULL,
    DocID VARCHAR(10) NOT NULL,
    ECID VARCHAR(10) NOT NULL,
    FOREIGN KEY (PID) REFERENCES Patients(PID),
    FOREIGN KEY (DocID) REFERENCES Doctors(DocID),
    FOREIGN KEY (ECID) REFERENCES Emergency_Contacts(ECID)
);

CREATE TABLE Treatments (
    TID VARCHAR(10) PRIMARY KEY,
    TDate DATE NOT NULL,
    TDescription VARCHAR(255) NOT NULL,
    DocID VARCHAR(10) NOT NULL,
    AID VARCHAR(10) NOT NULL,
    FOREIGN KEY (DocID) REFERENCES Doctors(DocID),
    FOREIGN KEY (AID) REFERENCES Admissions(AID)
);



-- Insert Values into tables


INSERT INTO Doctors (DocID, FName, LName, DeptID) VALUES
('D01','Joshua','Branch',NULL),
('D02','Mariam','Khan',NULL),
('D03','Travis','Anderson',NULL),
('D04','Henrik','Bauer',NULL),
('D05','Ethan','Nordman',NULL);

INSERT INTO Departments VALUES
('DEP1','Cardiology','Main Hospital','3','D01'),
('DEP2','Neurology','Main Hospital','5','D03'),
('DEP3','Emergency Med','West Wing','1','D05'),
('DEP4','Pulmonology','Main Hospital','2','D04'),
('DEP5','Intensive Care Unit','West Wing','4','D02');

UPDATE Doctors SET DeptID = 'DEP1' WHERE DocID = 'D01';
UPDATE Doctors SET DeptID = 'DEP2' WHERE DocID = 'D03';
UPDATE Doctors SET DeptID = 'DEP3' WHERE DocID = 'D05';
UPDATE Doctors SET DeptID = 'DEP4' WHERE DocID = 'D02';
UPDATE Doctors SET DeptID = 'DEP2' WHERE DocID = 'D04';

INSERT INTO Specialties VALUES
('S1','Interventional Cardiology'),
('S2','Stroke Neurology'),
('S3','Pediatric Emergency'),
('S4','Trauma Surgery'),
('S5','Pediatric Cardiac Surgery');

INSERT INTO Doctor_Specialties VALUES
('D01','S1'),('D02','S1'),('D03','S2'),('D04','S3'),('D05','S3');

INSERT INTO Patients VALUES
('P01','Natalie','Hong','1978-05-12','719-555-0101','natalie@email.com'),
('P02','Jack','Lindsay','1965-03-22','719-555-0102',NULL),
('P03','Sebastien','Jean','1992-11-30','719-555-0103','seb@email.com'),
('P04','Ronald','McDonald','2001-08-15','719-555-0104','rmcdonald@email.com'),
('P05','Wick','John','1985-12-10','719-555-0105','jwick@email.com');

INSERT INTO Emergency_Contacts VALUES
('EC1','Timothy','O''Dell','719-555-0201','tim@email.com','Spouse'),
('EC2','Matthew','Neubauer','719-555-0202',NULL,'Brother'),
('EC3','Ilona','Completo','719-555-0203','ilona@email.com','Mother'),
('EC4','Ryan','Shannon','719-555-0204',NULL,'Friend'),
('EC5','Reacher','Jack','719-555-0205','jreach@email.com','Father');

INSERT INTO Admissions VALUES
('A01','2025-01-15','2025-01-20','P01','D01','EC1'),
('A02','2025-02-10','2025-02-18','P01','D02','EC1'),
('A03','2025-03-05',NULL,'P02','D03','EC2'),
('A04','2025-04-12','2025-04-19','P03','D04','EC3'),
('A05','2025-06-01',NULL,'P04','D05','EC4');

INSERT INTO Treatments VALUES
('T01','2025-01-16','Coronary Angiography','D01','A01'),
('T02','2025-01-18','Stent Placement','D02','A01'),
('T03','2025-02-11','Cardiac Rehab','D01','A02'),
('T04','2025-03-06','MRI Brain','D03','A03'),
('T05','2025-04-13','Emergency Surgery','D04','A04'),
('T06','2025-06-02','Appendectomy','D05','A05');

ALTER TABLE Doctors
ADD CONSTRAINT fk_doc_dept FOREIGN KEY (DeptID) REFERENCES Departments(DeptID),
MODIFY DeptID VARCHAR(10) NOT NULL;

-- Required quieres

SELECT p.PID, p.FName, p.LName, a.InDate, a.OutDate, d.DocID, d.FName AS DocFName, d.LName AS DocLName
FROM Patients AS p
JOIN Admissions AS a ON p.PID = a.PID
JOIN Doctors AS d ON a.DocID = d.DocID;

SELECT p.PID, p.FName, p.LName, d.DocID, d.FName, d.LName, COUNT(*) AS TimesInCharge
FROM Patients AS p
JOIN Admissions AS a ON p.PID = a.PID
JOIN Doctors AS d ON a.DocID = d.DocID
GROUP BY p.PID, d.DocID;

SELECT p.PID, p.FName, p.LName, ec.ECID, ec.FName, ec.LName
FROM Patients AS p
JOIN Admissions AS a ON p.PID = a.PID
JOIN Emergency_Contacts AS ec ON a.ECID = ec.ECID;

SELECT p.PID, p.FName, p.LName, t.TDate, t.TDescription, d.DocID, d.FName, d.LName
FROM Treatments AS t
JOIN Admissions AS a ON t.AID = a.AID
JOIN Patients AS p ON a.PID = p.PID
JOIN Doctors AS d ON t.DocID = d.DocID
WHERE t.AID = 'A01';

SELECT d.DocID, d.FName, d.LName, s.SName
FROM Doctors AS d
LEFT JOIN Doctor_Specialties AS ds ON d.DocID = ds.DocID
LEFT JOIN Specialties AS s ON ds.SID = s.SID;

SELECT dep.DeptName, d.DocID, d.FName, d.LName, s.SName
FROM Departments AS dep
JOIN Doctors AS d ON dep.DeptHead = d.DocID
LEFT JOIN Doctor_Specialties AS ds ON d.DocID = ds.DocID
LEFT JOIN Specialties AS s ON ds.SID = s.SID;

SELECT dep.DeptName, d.DocID, d.FName, d.LName, COUNT(ds.SID) AS NumSpecialties
FROM Departments AS dep
JOIN Doctors AS d ON dep.DeptID = d.DeptID
LEFT JOIN Doctor_Specialties AS ds ON d.DocID = ds.DocID
GROUP BY dep.DeptName, d.DocID;