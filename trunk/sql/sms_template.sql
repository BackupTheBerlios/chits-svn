-- MySQL dump 9.10
--
-- Host: localhost    Database: game
-- ------------------------------------------------------
-- Server version	4.0.18-Max

--
-- Table structure for table `m_lib_reminder_sms_template`
--

CREATE TABLE m_lib_reminder_sms_template (
  template_id varchar(20) NOT NULL default '',
  appointment_id varchar(10) NOT NULL default '',
  template_text varchar(120) NOT NULL default '',
  PRIMARY KEY  (template_id),
  KEY key_appointment (appointment_id),
  CONSTRAINT `m_lib_reminder_sms_template_ibfk_1` FOREIGN KEY (`appointment_id`) REFERENCES `m_lib_appointment` (`appointment_id`) ON DELETE CASCADE ON UPDATE CASCADE
) TYPE=InnoDB;

--
-- Dumping data for table `m_lib_reminder_sms_template`
--

INSERT INTO m_lib_reminder_sms_template VALUES ('NTP_FFUP','NTPM','_SENDER_: Para kay _RECEIVER_ huwag kalimutang bumalik sa _APPT_DATE_ para sa gamutan natin. Salamat.');
INSERT INTO m_lib_reminder_sms_template VALUES ('PRENATAL','PRENATAL','_SENDER_: Dear _RECEIVER_, huwag kalimutang bumalik sa _APPT_DATE_ para sa iyong susunod na prenatal checkup. Salamat.');
INSERT INTO m_lib_reminder_sms_template VALUES ('VACC_FFUP	','VACC','_SENDER_: Para kay _RECEIVER_ huwag kalimutang bumalik sa _APPT_DATE_ para sa bakuna ng inyong anak.');

