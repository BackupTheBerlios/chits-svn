-- MySQL dump 9.10
--
-- Host: localhost    Database: game
-- ------------------------------------------------------
-- Server version	4.0.18-Max

--
-- Table structure for table `m_lib_drug_preparation`
--

CREATE TABLE m_lib_drug_preparation (
  prep_id varchar(10) NOT NULL default '',
  prep_name varchar(50) NOT NULL default '',
  PRIMARY KEY  (prep_id)
) TYPE=MyISAM;

--
-- Dumping data for table `m_lib_drug_preparation`
--

INSERT INTO m_lib_drug_preparation VALUES ('SUSP','Suspension');
INSERT INTO m_lib_drug_preparation VALUES ('TAB','Tablet');
INSERT INTO m_lib_drug_preparation VALUES ('CAP','Capsule');
INSERT INTO m_lib_drug_preparation VALUES ('BPACK','Blister pack');
INSERT INTO m_lib_drug_preparation VALUES ('SACH','Sachet');
INSERT INTO m_lib_drug_preparation VALUES ('VIAL','Vial');
INSERT INTO m_lib_drug_preparation VALUES ('NEB','Nebule/Respule');

