-- MySQL dump 9.10
--
-- Host: localhost    Database: game
-- ------------------------------------------------------
-- Server version	4.0.18-Max

--
-- Table structure for table `m_lib_drug_category`
--

CREATE TABLE m_lib_drug_category (
  cat_id varchar(10) NOT NULL default '',
  cat_name varchar(50) NOT NULL default '',
  PRIMARY KEY  (cat_id)
) TYPE=InnoDB;

--
-- Dumping data for table `m_lib_drug_category`
--

INSERT INTO m_lib_drug_category VALUES ('ABIO','Antibiotics');
INSERT INTO m_lib_drug_category VALUES ('AHELM','Anti-helminthic');
INSERT INTO m_lib_drug_category VALUES ('AHIST','Antihistamines');
INSERT INTO m_lib_drug_category VALUES ('AHPN','Anti-hypertensives');
INSERT INTO m_lib_drug_category VALUES ('ANALG','Analgesic/Anti-inflammatory');
INSERT INTO m_lib_drug_category VALUES ('ANTITB','Antituberculous Agents');
INSERT INTO m_lib_drug_category VALUES ('APYR','Antipyretic');
INSERT INTO m_lib_drug_category VALUES ('ASPASM','Antispasmodic Agents');
INSERT INTO m_lib_drug_category VALUES ('ASTHMA','Anti-asthmatics');
INSERT INTO m_lib_drug_category VALUES ('CONTR','Contraceptive Agents');
INSERT INTO m_lib_drug_category VALUES ('EYE','Opthalmic Solutions/Drops');
INSERT INTO m_lib_drug_category VALUES ('HYDR','Rehydration Solutions');
INSERT INTO m_lib_drug_category VALUES ('VIT','Vitamins');

