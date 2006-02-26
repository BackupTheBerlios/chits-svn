-- MySQL dump 9.10
--
-- Host: localhost    Database: game
-- ------------------------------------------------------
-- Server version	4.0.18-Max

--
-- Table structure for table `m_lib_drug_source`
--

CREATE TABLE m_lib_drug_source (
  source_id varchar(10) NOT NULL default '',
  source_name varchar(40) NOT NULL default '',
  PRIMARY KEY  (source_id)
) TYPE=InnoDB;

--
-- Dumping data for table `m_lib_drug_source`
--

INSERT INTO m_lib_drug_source VALUES ('CDS','DOH');
INSERT INTO m_lib_drug_source VALUES ('LGU','LGU');

