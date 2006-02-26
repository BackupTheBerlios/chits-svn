-- MySQL dump 9.10
--
-- Host: localhost    Database: game
-- ------------------------------------------------------
-- Server version	4.0.18-Max

--
-- Table structure for table `m_lib_drug_formulation`
--

CREATE TABLE m_lib_drug_formulation (
  form_id int(11) NOT NULL auto_increment,
  form_name varchar(100) NOT NULL default '',
  PRIMARY KEY  (form_id)
) TYPE=InnoDB;

--
-- Dumping data for table `m_lib_drug_formulation`
--

INSERT INTO m_lib_drug_formulation VALUES (1,'125mg/5ml x 100ml');
INSERT INTO m_lib_drug_formulation VALUES (2,'250mg/5ml x 100ml');
INSERT INTO m_lib_drug_formulation VALUES (3,'200mg + 40mg / 5ml x 100ml');
INSERT INTO m_lib_drug_formulation VALUES (4,'100mg/ml x 30ml');
INSERT INTO m_lib_drug_formulation VALUES (5,'100mg/ml x 60ml');
INSERT INTO m_lib_drug_formulation VALUES (6,'100mg/ml x 10ml');
INSERT INTO m_lib_drug_formulation VALUES (7,'500mg/tab');
INSERT INTO m_lib_drug_formulation VALUES (8,'500mg/cap');
INSERT INTO m_lib_drug_formulation VALUES (9,'100,000IU/cap');
INSERT INTO m_lib_drug_formulation VALUES (10,'200,000IU/cap');
INSERT INTO m_lib_drug_formulation VALUES (11,'800mg + 160mg / tab');
INSERT INTO m_lib_drug_formulation VALUES (12,'400mg + 80mg / tab');
INSERT INTO m_lib_drug_formulation VALUES (13,'2mg/5ml x 60ml');
INSERT INTO m_lib_drug_formulation VALUES (14,'400mg/tab');
INSERT INTO m_lib_drug_formulation VALUES (15,'60mg/tab');
INSERT INTO m_lib_drug_formulation VALUES (16,'2mg/tab');
INSERT INTO m_lib_drug_formulation VALUES (17,'27.9g/sachet (see sachet for details)');
INSERT INTO m_lib_drug_formulation VALUES (18,'10,000IU/cap');
INSERT INTO m_lib_drug_formulation VALUES (19,'150mg/ml x 1 vial');
INSERT INTO m_lib_drug_formulation VALUES (20,'0.3mg norgestrel + 0.03mg ethinyl estradiol/tab x 21 tabs');
INSERT INTO m_lib_drug_formulation VALUES (21,'Type 1, R450mg x 7 caps + I300mg x 7 tabs + P500mg x 14 tabs / blister pack');
INSERT INTO m_lib_drug_formulation VALUES (22,'Type 2, R450mg x 7 caps + I300mg x 7 tabs / blister pack');
INSERT INTO m_lib_drug_formulation VALUES (23,'1gm/vial');
INSERT INTO m_lib_drug_formulation VALUES (24,'200mg/5ml x 60ml');
INSERT INTO m_lib_drug_formulation VALUES (25,'200mg/5ml x 120ml');
INSERT INTO m_lib_drug_formulation VALUES (26,'250mg/cap');
INSERT INTO m_lib_drug_formulation VALUES (27,'250ucg/ml x 2ml per respule');
INSERT INTO m_lib_drug_formulation VALUES (28,'2.5mg/2.5ml per nebule');
INSERT INTO m_lib_drug_formulation VALUES (29,'4mg/tab');
INSERT INTO m_lib_drug_formulation VALUES (30,'10mg/tab');
INSERT INTO m_lib_drug_formulation VALUES (31,'5mg/cap');
INSERT INTO m_lib_drug_formulation VALUES (32,'12.5mg/5ml x 100ml');
INSERT INTO m_lib_drug_formulation VALUES (33,'25mg/tab');
INSERT INTO m_lib_drug_formulation VALUES (34,'50mg/tab');

