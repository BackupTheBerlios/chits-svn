<?
// BEGIN SERVER CODE: DO NOT EDIT
// Server generated code
// Generated 2004-10-19 22:58:44
// Module: _module.php
// Author: Herman Tolentino MD
//
if (file_exists('../modules/appointment/class.appointment.php')) {
	include '../modules/appointment/class.appointment.php';
	$appointment = new appointment;
	if (!$module->activated('appointment') && $_GET["initmod"]==1) {
		$appointment->init_sql();
		$appointment->init_menu();
		$appointment->init_deps();
		$appointment->init_lang();
		$appointment->init_help();
	}
}
if (file_exists('../modules/barangay/class.barangay.php')) {
	include '../modules/barangay/class.barangay.php';
	$barangay = new barangay;
	if (!$module->activated('barangay') && $_GET["initmod"]==1) {
		$barangay->init_sql();
		$barangay->init_menu();
		$barangay->init_deps();
		$barangay->init_lang();
		$barangay->init_help();
	}
}
if (file_exists('../modules/birthday/class.birthday.php')) {
	include '../modules/birthday/class.birthday.php';
	$birthday = new birthday;
	if (!$module->activated('birthday') && $_GET["initmod"]==1) {
		$birthday->init_sql();
		$birthday->init_menu();
		$birthday->init_deps();
		$birthday->init_lang();
		$birthday->init_help();
	}
}
if (file_exists('../modules/calendar/class.calendar.php')) {
	include '../modules/calendar/class.calendar.php';
	$calendar = new calendar;
	if (!$module->activated('calendar') && $_GET["initmod"]==1) {
		$calendar->init_sql();
		$calendar->init_menu();
		$calendar->init_deps();
		$calendar->init_lang();
		$calendar->init_help();
	}
}
if (file_exists('../modules/ccdev/class.ccdev.php')) {
	include '../modules/ccdev/class.ccdev.php';
	$ccdev = new ccdev;
	if (!$module->activated('ccdev') && $_GET["initmod"]==1) {
		$ccdev->init_sql();
		$ccdev->init_menu();
		$ccdev->init_deps();
		$ccdev->init_lang();
		$ccdev->init_help();
	}
}
if (file_exists('../modules/ccdev_report/class.ccdev_report.php')) {
	include '../modules/ccdev_report/class.ccdev_report.php';
	$ccdev_report = new ccdev_report;
	if (!$module->activated('ccdev_report') && $_GET["initmod"]==1) {
		$ccdev_report->init_sql();
		$ccdev_report->init_menu();
		$ccdev_report->init_deps();
		$ccdev_report->init_lang();
		$ccdev_report->init_help();
	}
}
if (file_exists('../modules/complaint/class.complaint.php')) {
	include '../modules/complaint/class.complaint.php';
	$complaint = new complaint;
	if (!$module->activated('complaint') && $_GET["initmod"]==1) {
		$complaint->init_sql();
		$complaint->init_menu();
		$complaint->init_deps();
		$complaint->init_lang();
		$complaint->init_help();
	}
}
if (file_exists('../modules/consult_report/class.consult_report.php')) {
	include '../modules/consult_report/class.consult_report.php';
	$consult_report = new consult_report;
	if (!$module->activated('consult_report') && $_GET["initmod"]==1) {
		$consult_report->init_sql();
		$consult_report->init_menu();
		$consult_report->init_deps();
		$consult_report->init_lang();
		$consult_report->init_help();
	}
}
if (file_exists('../modules/database/class.database.php')) {
	include '../modules/database/class.database.php';
	$database = new database;
	if (!$module->activated('database') && $_GET["initmod"]==1) {
		$database->init_sql();
		$database->init_menu();
		$database->init_deps();
		$database->init_lang();
		$database->init_help();
	}
}
if (file_exists('../modules/drug/class.drug.php')) {
	include '../modules/drug/class.drug.php';
	$drug = new drug;
	if (!$module->activated('drug') && $_GET["initmod"]==1) {
		$drug->init_sql();
		$drug->init_menu();
		$drug->init_deps();
		$drug->init_lang();
		$drug->init_help();
	}
}
if (file_exists('../modules/education/class.education.php')) {
	include '../modules/education/class.education.php';
	$education = new education;
	if (!$module->activated('education') && $_GET["initmod"]==1) {
		$education->init_sql();
		$education->init_menu();
		$education->init_deps();
		$education->init_lang();
		$education->init_help();
	}
}
if (file_exists('../modules/epi_report/class.epi_report.php')) {
	include '../modules/epi_report/class.epi_report.php';
	$epi_report = new epi_report;
	if (!$module->activated('epi_report') && $_GET["initmod"]==1) {
		$epi_report->init_sql();
		$epi_report->init_menu();
		$epi_report->init_deps();
		$epi_report->init_lang();
		$epi_report->init_help();
	}
}
if (file_exists('../modules/family/class.family.php')) {
	include '../modules/family/class.family.php';
	$family = new family;
	if (!$module->activated('family') && $_GET["initmod"]==1) {
		$family->init_sql();
		$family->init_menu();
		$family->init_deps();
		$family->init_lang();
		$family->init_help();
	}
}
if (file_exists('../modules/graph/class.graph.php')) {
	include '../modules/graph/class.graph.php';
	$graph = new graph;
	if (!$module->activated('graph') && $_GET["initmod"]==1) {
		$graph->init_sql();
		$graph->init_menu();
		$graph->init_deps();
		$graph->init_lang();
		$graph->init_help();
	}
}
if (file_exists('../modules/healthcenter/class.healthcenter.php')) {
	include '../modules/healthcenter/class.healthcenter.php';
	$healthcenter = new healthcenter;
	if (!$module->activated('healthcenter') && $_GET["initmod"]==1) {
		$healthcenter->init_sql();
		$healthcenter->init_menu();
		$healthcenter->init_deps();
		$healthcenter->init_lang();
		$healthcenter->init_help();
	}
}
if (file_exists('../modules/icd10/class.icd10.php')) {
	include '../modules/icd10/class.icd10.php';
	$icd10 = new icd10;
	if (!$module->activated('icd10') && $_GET["initmod"]==1) {
		$icd10->init_sql();
		$icd10->init_menu();
		$icd10->init_deps();
		$icd10->init_lang();
		$icd10->init_help();
	}
}
if (file_exists('../modules/imci/class.imci.php')) {
	include '../modules/imci/class.imci.php';
	$imci = new imci;
	if (!$module->activated('imci') && $_GET["initmod"]==1) {
		$imci->init_sql();
		$imci->init_menu();
		$imci->init_deps();
		$imci->init_lang();
		$imci->init_help();
	}
}
if (file_exists('../modules/injury/class.injury.php')) {
	include '../modules/injury/class.injury.php';
	$injury = new injury;
	if (!$module->activated('injury') && $_GET["initmod"]==1) {
		$injury->init_sql();
		$injury->init_menu();
		$injury->init_deps();
		$injury->init_lang();
		$injury->init_help();
	}
}
if (file_exists('../modules/injury_report/class.injury_report.php')) {
	include '../modules/injury_report/class.injury_report.php';
	$injury_report = new injury_report;
	if (!$module->activated('injury_report') && $_GET["initmod"]==1) {
		$injury_report->init_sql();
		$injury_report->init_menu();
		$injury_report->init_deps();
		$injury_report->init_lang();
		$injury_report->init_help();
	}
}
if (file_exists('../modules/lab/class.lab.php')) {
	include '../modules/lab/class.lab.php';
	$lab = new lab;
	if (!$module->activated('lab') && $_GET["initmod"]==1) {
		$lab->init_sql();
		$lab->init_menu();
		$lab->init_deps();
		$lab->init_lang();
		$lab->init_help();
	}
}
if (file_exists('../modules/language/class.language.php')) {
	include '../modules/language/class.language.php';
	$language = new language;
	if (!$module->activated('language') && $_GET["initmod"]==1) {
		$language->init_sql();
		$language->init_menu();
		$language->init_deps();
		$language->init_lang();
		$language->init_help();
	}
}
if (file_exists('../modules/mc/class.mc.php')) {
	include '../modules/mc/class.mc.php';
	$mc = new mc;
	if (!$module->activated('mc') && $_GET["initmod"]==1) {
		$mc->init_sql();
		$mc->init_menu();
		$mc->init_deps();
		$mc->init_lang();
		$mc->init_help();
	}
}
if (file_exists('../modules/news/class.news.php')) {
	include '../modules/news/class.news.php';
	$news = new news;
	if (!$module->activated('news') && $_GET["initmod"]==1) {
		$news->init_sql();
		$news->init_menu();
		$news->init_deps();
		$news->init_lang();
		$news->init_help();
	}
}
if (file_exists('../modules/notes/class.notes.php')) {
	include '../modules/notes/class.notes.php';
	$notes = new notes;
	if (!$module->activated('notes') && $_GET["initmod"]==1) {
		$notes->init_sql();
		$notes->init_menu();
		$notes->init_deps();
		$notes->init_lang();
		$notes->init_help();
	}
}
if (file_exists('../modules/notifiable/class.notifiable.php')) {
	include '../modules/notifiable/class.notifiable.php';
	$notifiable = new notifiable;
	if (!$module->activated('notifiable') && $_GET["initmod"]==1) {
		$notifiable->init_sql();
		$notifiable->init_menu();
		$notifiable->init_deps();
		$notifiable->init_lang();
		$notifiable->init_help();
	}
}
if (file_exists('../modules/notifiable_report/class.notifiable_report.php')) {
	include '../modules/notifiable_report/class.notifiable_report.php';
	$notifiable_report = new notifiable_report;
	if (!$module->activated('notifiable_report') && $_GET["initmod"]==1) {
		$notifiable_report->init_sql();
		$notifiable_report->init_menu();
		$notifiable_report->init_deps();
		$notifiable_report->init_lang();
		$notifiable_report->init_help();
	}
}
if (file_exists('../modules/ntp/class.ntp.php')) {
	include '../modules/ntp/class.ntp.php';
	$ntp = new ntp;
	if (!$module->activated('ntp') && $_GET["initmod"]==1) {
		$ntp->init_sql();
		$ntp->init_menu();
		$ntp->init_deps();
		$ntp->init_lang();
		$ntp->init_help();
	}
}
if (file_exists('../modules/ntp_report/class.ntp_report.php')) {
	include '../modules/ntp_report/class.ntp_report.php';
	$ntp_report = new ntp_report;
	if (!$module->activated('ntp_report') && $_GET["initmod"]==1) {
		$ntp_report->init_sql();
		$ntp_report->init_menu();
		$ntp_report->init_deps();
		$ntp_report->init_lang();
		$ntp_report->init_help();
	}
}
if (file_exists('../modules/occupation/class.occupation.php')) {
	include '../modules/occupation/class.occupation.php';
	$occupation = new occupation;
	if (!$module->activated('occupation') && $_GET["initmod"]==1) {
		$occupation->init_sql();
		$occupation->init_menu();
		$occupation->init_deps();
		$occupation->init_lang();
		$occupation->init_help();
	}
}
if (file_exists('../modules/patient/class.patient.php')) {
	include '../modules/patient/class.patient.php';
	$patient = new patient;
	if (!$module->activated('patient') && $_GET["initmod"]==1) {
		$patient->init_sql();
		$patient->init_menu();
		$patient->init_deps();
		$patient->init_lang();
		$patient->init_help();
	}
}
if (file_exists('../modules/philhealth/class.philhealth.php')) {
	include '../modules/philhealth/class.philhealth.php';
	$philhealth = new philhealth;
	if (!$module->activated('philhealth') && $_GET["initmod"]==1) {
		$philhealth->init_sql();
		$philhealth->init_menu();
		$philhealth->init_deps();
		$philhealth->init_lang();
		$philhealth->init_help();
	}
}
if (file_exists('../modules/ptgroup/class.ptgroup.php')) {
	include '../modules/ptgroup/class.ptgroup.php';
	$ptgroup = new ptgroup;
	if (!$module->activated('ptgroup') && $_GET["initmod"]==1) {
		$ptgroup->init_sql();
		$ptgroup->init_menu();
		$ptgroup->init_deps();
		$ptgroup->init_lang();
		$ptgroup->init_help();
	}
}
if (file_exists('../modules/region/class.region.php')) {
	include '../modules/region/class.region.php';
	$region = new region;
	if (!$module->activated('region') && $_GET["initmod"]==1) {
		$region->init_sql();
		$region->init_menu();
		$region->init_deps();
		$region->init_lang();
		$region->init_help();
	}
}
if (file_exists('../modules/reminder/class.reminder.php')) {
	include '../modules/reminder/class.reminder.php';
	$reminder = new reminder;
	if (!$module->activated('reminder') && $_GET["initmod"]==1) {
		$reminder->init_sql();
		$reminder->init_menu();
		$reminder->init_deps();
		$reminder->init_lang();
		$reminder->init_help();
	}
}
if (file_exists('../modules/sputum/class.sputum.php')) {
	include '../modules/sputum/class.sputum.php';
	$sputum = new sputum;
	if (!$module->activated('sputum') && $_GET["initmod"]==1) {
		$sputum->init_sql();
		$sputum->init_menu();
		$sputum->init_deps();
		$sputum->init_lang();
		$sputum->init_help();
	}
}
if (file_exists('../modules/tcl/class.tcl.php')) {
	include '../modules/tcl/class.tcl.php';
	$tcl = new tcl;
	if (!$module->activated('tcl') && $_GET["initmod"]==1) {
		$tcl->init_sql();
		$tcl->init_menu();
		$tcl->init_deps();
		$tcl->init_lang();
		$tcl->init_help();
	}
}
if (file_exists('../modules/template/class.template.php')) {
	include '../modules/template/class.template.php';
	$template = new template;
	if (!$module->activated('template') && $_GET["initmod"]==1) {
		$template->init_sql();
		$template->init_menu();
		$template->init_deps();
		$template->init_lang();
		$template->init_help();
	}
}
if (file_exists('../modules/vaccine/class.vaccine.php')) {
	include '../modules/vaccine/class.vaccine.php';
	$vaccine = new vaccine;
	if (!$module->activated('vaccine') && $_GET["initmod"]==1) {
		$vaccine->init_sql();
		$vaccine->init_menu();
		$vaccine->init_deps();
		$vaccine->init_lang();
		$vaccine->init_help();
	}
}
if (file_exists('../modules/wtforage/class.wtforage.php')) {
	include '../modules/wtforage/class.wtforage.php';
	$wtforage = new wtforage;
	if (!$module->activated('wtforage') && $_GET["initmod"]==1) {
		$wtforage->init_sql();
		$wtforage->init_menu();
		$wtforage->init_deps();
		$wtforage->init_lang();
		$wtforage->init_help();
	}
}

// END SERVER CODE

?>