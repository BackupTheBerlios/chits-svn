-- MySQL dump 9.10
--
-- Host: localhost    Database: game
-- ------------------------------------------------------
-- Server version	4.0.18-Max

--
-- Table structure for table `m_consult_ntp_labs_request`
--

CREATE TABLE m_consult_ntp_labs_request (
  consult_id float NOT NULL default '0',
  patient_id float NOT NULL default '0',
  ntp_id float NOT NULL default '0',
  request_id float NOT NULL default '0',
  user_id float NOT NULL default '0',
  request_timestamp timestamp(14) NOT NULL,
  PRIMARY KEY  (request_id,ntp_id),
  KEY key_consult (consult_id),
  KEY ntp_id (ntp_id),
  KEY request_id (request_id),
  CONSTRAINT `m_consult_ntp_labs_request_ibfk_1` FOREIGN KEY (`consult_id`) REFERENCES `m_consult` (`consult_id`) ON DELETE CASCADE,
  CONSTRAINT `m_consult_ntp_labs_request_ibfk_2` FOREIGN KEY (`request_id`) REFERENCES `m_consult_lab` (`request_id`) ON DELETE CASCADE,
  CONSTRAINT `m_consult_ntp_labs_request_ibfk_3` FOREIGN KEY (`ntp_id`) REFERENCES `m_patient_ntp` (`ntp_id`) ON DELETE CASCADE
) TYPE=InnoDB;

--
-- Dumping data for table `m_consult_ntp_labs_request`
--

INSERT INTO m_consult_ntp_labs_request VALUES (40,3,2,8,1,20040524141523);
INSERT INTO m_consult_ntp_labs_request VALUES (40,3,2,9,1,20040524141523);
INSERT INTO m_consult_ntp_labs_request VALUES (41,6,1,10,1,20040526214617);

