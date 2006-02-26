-- MySQL dump 9.10
--
-- Host: localhost    Database: game
-- ------------------------------------------------------
-- Server version	4.0.18-Max

--
-- Table structure for table `m_lib_notes_dxclass`
--

CREATE TABLE m_lib_notes_dxclass (
  class_id float NOT NULL auto_increment,
  class_name varchar(50) NOT NULL default '',
  PRIMARY KEY  (class_id)
) TYPE=InnoDB;

--
-- Dumping data for table `m_lib_notes_dxclass`
--

INSERT INTO m_lib_notes_dxclass VALUES (1,'Dehydration, Severe');
INSERT INTO m_lib_notes_dxclass VALUES (2,'Dehydration None');
INSERT INTO m_lib_notes_dxclass VALUES (3,'Diarrhea, Persistent Severe');
INSERT INTO m_lib_notes_dxclass VALUES (4,'Dehydration, Mild');
INSERT INTO m_lib_notes_dxclass VALUES (5,'Dysentery');
INSERT INTO m_lib_notes_dxclass VALUES (6,'Bacterial Infection, Possible Serious');
INSERT INTO m_lib_notes_dxclass VALUES (7,'Bacterial Infection, Local');
INSERT INTO m_lib_notes_dxclass VALUES (8,'Feeding Problem');
INSERT INTO m_lib_notes_dxclass VALUES (9,'Low Weight');
INSERT INTO m_lib_notes_dxclass VALUES (10,'Pneumonia, Severe');
INSERT INTO m_lib_notes_dxclass VALUES (11,'Pneumonia');
INSERT INTO m_lib_notes_dxclass VALUES (12,'Cough/Cold');
INSERT INTO m_lib_notes_dxclass VALUES (13,'Diarrhea, Persistent');
INSERT INTO m_lib_notes_dxclass VALUES (14,'Febrile Disease, Severe/Malaria');
INSERT INTO m_lib_notes_dxclass VALUES (15,'Malaria');
INSERT INTO m_lib_notes_dxclass VALUES (16,'Fever, Not due to Malaria');
INSERT INTO m_lib_notes_dxclass VALUES (17,'Febrile Disease, Severe');
INSERT INTO m_lib_notes_dxclass VALUES (18,'Measles, Severe Complicated');
INSERT INTO m_lib_notes_dxclass VALUES (19,'Measles, with Eye/Mouth Complications');
INSERT INTO m_lib_notes_dxclass VALUES (20,'Measles');
INSERT INTO m_lib_notes_dxclass VALUES (21,'Dengue, Hemorrhagic Fever, Severe');
INSERT INTO m_lib_notes_dxclass VALUES (22,'Mastoiditis');
INSERT INTO m_lib_notes_dxclass VALUES (23,'Ear Infection, Acute');
INSERT INTO m_lib_notes_dxclass VALUES (24,'Ear Infection, Chronic');
INSERT INTO m_lib_notes_dxclass VALUES (25,'Malnutrition, Severe');
INSERT INTO m_lib_notes_dxclass VALUES (26,'Anemia, Severe');
INSERT INTO m_lib_notes_dxclass VALUES (27,'Anemia');
INSERT INTO m_lib_notes_dxclass VALUES (28,'Very Low Weight');

