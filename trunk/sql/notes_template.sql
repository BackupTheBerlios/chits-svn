-- MySQL dump 9.10
--
-- Host: localhost    Database: game
-- ------------------------------------------------------
-- Server version	4.0.18-Max

--
-- Table structure for table `m_lib_notes_template`
--

CREATE TABLE m_lib_notes_template (
  template_id float NOT NULL auto_increment,
  template_cat varchar(10) NOT NULL default '',
  template_name varchar(40) NOT NULL default '',
  template_text text NOT NULL,
  PRIMARY KEY  (template_id)
) TYPE=InnoDB;

--
-- Dumping data for table `m_lib_notes_template`
--

INSERT INTO m_lib_notes_template VALUES (1,'HX','Pedia History Present Illness','___ days PTC- ');
INSERT INTO m_lib_notes_template VALUES (2,'PE','Neurologic Exam','General Survey- awake, coherent\r\nCN 1- can smell\r\nCN 2,3- 2-3 mm EBRTL, (+) ROR, CM,DDB, AV 2:3, (-) hge \r\n(-) exudate\r\nCN 3,4,6- Full EOMs\r\nCN 5- good masseter tone\r\nCN 7- (-) facial asymmetry \r\nCN 8- (-) hearing loss\r\nCN 9,10 - can swallow \r\nCN 11- can shrug shoulders\r\nCN 12- midline tongue\r\n\r\nMotor: 5/5 all extremities\r\nSensory: 100% intact\r\nDTR\\\'s: +2 all extremities\r\nMeninges: supple neck\r\nCerebellar: Can do FTNT\r\nBabinski: absent\r\nClonus: absent');
INSERT INTO m_lib_notes_template VALUES (3,'HX','Adult ROS','REVIEW OF SYSTEMS\r\n(+)Fever\r\n(+)Weight loss/anorexia\r\n(+)Weakness\r\n(+)Headache\r\n(+)Jaundice\r\n(+)Dizziness\r\n(+)Loss of consciousness\r\n(+)Blurring of vision\r\n(+)Nape pain\r\n(+)Ear pain\r\n(+)Tinnitus\r\n(+)Hearing loss\r\n(+)Colds\r\n(+)Cough\r\n(+)Dysphagia\r\n(+)Odynophagia\r\n(+)Nausea\r\n(+)Vomiting\r\n(+)DOB\r\n(+)Paroxysmal nocturnal dyspnea\r\n(+)Orthopnea\r\n(+)Chest pain\r\n(+)Palpitations\r\n(+)Abdominal pain\r\n(+)Constipation\r\n(+)LBM\r\n(+)Hematochezia\r\n(+)Hematemesis\r\n(+)Dysuria\r\n(+)Hematuria\r\n(+)Nocturia\r\n(+)Frequency\r\n(+)Dribbling\r\n(+)Polyuria\r\n(+)Polydipsia\r\n(+)Polyphagia\r\n(+)Numbness\r\n(+)Joint pain\r\n(+)Edema');
INSERT INTO m_lib_notes_template VALUES (7,'HX','Adult Past Hx','PAST HISTORY-\r\nDM-\r\nThyroid-\r\nIHD-\r\nKidney -\r\nUTI -\r\nCVD-\r\nCancer-\r\nHPN-\r\nAsthma-\r\nPTB-\r\nPneumonia\r\nCOPD-\r\nAllergies-');
INSERT INTO m_lib_notes_template VALUES (8,'HX','Adult P/S Hx','PERSONAL/SOCIAL HISTORY\r\nOccupation-\r\nSmoking -\r\nAlcohol intake- \r\nDrug abuse-\r\nLiving condition-');
INSERT INTO m_lib_notes_template VALUES (9,'HX','Adult Family Hx','FAMILY HISTORY\r\nDM-\r\nThyroid-\r\nIHD-\r\nKidney -\r\nUTI -\r\nCVD-\r\nCancer-\r\nHPN-\r\nAsthma-\r\nPTB-\r\nPneumonia\r\nCOPD-\r\nAllergies-\r\n\r\n');
INSERT INTO m_lib_notes_template VALUES (10,'HX','Adult Present Illness Hx','___ days PTC');
INSERT INTO m_lib_notes_template VALUES (11,'PE','Ophtha Exam','Eyebrow- (-) dermatitis\r\nEyelash- (-) matting\r\nEyelid- (-) ptosis, (-) swelling\r\nConjunctiva- pink\r\nSclera- anicteric, \r\nCornea- clear\r\nAnterior chamber- deep\r\nIris- brown\r\nPupils- 2 mm EBRTL\r\nLens- clear\r\nEOM- full\r\nTonometry- firm\r\nFundoscopy: (+) ROR,CM, DDB, CDR 0.3, AV 2:3, (-) Hge, (-) Exudate\r\nVA: 6/6\r\n                  ');
INSERT INTO m_lib_notes_template VALUES (12,'PE','ENT exam','Ear- (-) auricular pain, intact tympanic membrane\r\nNose and Sinuses- (-) swollen turbinates, (-) discharge, (-) tenderness\r\nMouth/Pharynx- (-)sores, (-) TPC, (-)dental caries, (-) cyanosis\r\nNeck- (-) anterior neck mass, (-) tenderness, (-) CLAD, midline trachea ');
INSERT INTO m_lib_notes_template VALUES (13,'PE','Psychiatric Exam','MSE: oriented to all 3 spheres\r\nGA: young looking, well groomed, cooperative, good eye contact\r\nMOOD & AFFECT: euthymic mood, appropriate affect\r\nSPEECH: audible, spontaneous, (-) stutter\r\nPERCEPT. DIST.: (-) hallucination, (-) illusion, (-) flight of ideas\r\nTHOUGHT PROCESS: (-) circumstantiality,(-) tangentiality\r\nTHOUGHT CONTENT: (-) delusion, (-) suicidal ideation\r\nMEMORY: intact remote,recent, recent past and immediate\r\nCONCENTRATION: good\r\nATTENTION SPAN: good\r\nIMPULSE CONTROL: good\r\nINSIGHT: aware of his condition');
INSERT INTO m_lib_notes_template VALUES (14,'PE','Adult General Exam','GA: awake, ambulatory, NICRD\r\nVS: BP: 110/70     HR: 80       RR: 20           T: 37.4\r\nENT: anicteric sclera, pink conj.,(-) TPC, (-) CLAD, (-) NVE\r\nC/L: ECE,CBS, (-) rales, wheezes\r\nCVS: DHS, NRRR, (-) Murmurs, PMI 5th ICS LMCL     \r\nABD: Flabby, NABS, nontender, (-) hepatosplenomegaly\r\nExt: pink nailbeds, (-) edema, (-) cyanosis');
INSERT INTO m_lib_notes_template VALUES (15,'PE','Gyne Exam','Abdomen: flabby, nontender\r\n\r\nInternal Exam:\r\nExt Genitalia: normal gross looking\r\nVagina: multiparous\r\nCervix: closed, uneffaced\r\nUterus: nontender, not enlarged\r\nAdnexa: (-) mass, (-) tenderness\r\n\r\nSpeculum Exam: (-) discharge,(-)mass');
INSERT INTO m_lib_notes_template VALUES (17,'HX','Pedia Birth/ Feeding /Immunization Hx','Prenatal- (-) maternal illness, (+) regular consult, (-) alcohol intake,(-) drug use, (-)vaginal bleed\r\nNatal- born Full term via NSVD, Birth weight:    kg, Apgar:  \r\nNeonatal- (-) cyanosis, (-) jaundice, (-) infections\r\nFeeding History\r\nBreastfeeding- on demand up to __ months\r\nArtificial feeding- started on solid foods at __ months\r\nEating Habits- more on meat and vegetables\r\nImmunization History;\r\n(+) DPT\r\n(+)BCG\r\n(+)OPV\r\n(+)HepaB\r\n(+)MMR\r\nOthers:\r\n');
INSERT INTO m_lib_notes_template VALUES (18,'HX','Pedia Devtal Hx','Regard: 1 month\r\nTurn head:\r\nSit\r\nCrawl\r\nWalk\r\nRun\r\n');
INSERT INTO m_lib_notes_template VALUES (19,'TX','Diagnostics','CBC platelet count\r\nBlood Typing\r\nArterial Blood Gas\r\nUrinalysis\r\nFecalysis\r\nOccult Blood\r\nUrine Ketones\r\nUrine hemoglobin\r\nBUN\r\nCreatinine\r\nTC\r\nLDL\r\nVLDL\r\nHDL\r\nAST\r\nALT\r\nTB,DB,IB\r\nPT,PTT\r\nAlk PO4\r\nUric Acid\r\nNa\r\nK\r\nCl\r\nCa\r\nMg\r\nP\r\nFBS\r\n50gm OGTT\r\n2 hr Post Prandial glucose\r\nHBAIc\r\nT4,T3,TSH\r\nAmylase\r\n12 lead ECG\r\n2D Echo with Doppler\r\nTET\r\nPulmonary Function Test\r\nCT Scan of:\r\nUtlrasound of:\r\nChest xray PAL\r\nApico lordotic view\r\nChest Bucky\r\nThoracolumbar APL\r\nLumbosacral APL\r\nFoot APOL\r\nHand APOL\r\nSkull APL\r\nKnee APL\r\nPelvic AP\r\nPlain Abdomen\r\nPlain KUB\r\nKUB IVP\r\nWater\\\'s view\r\nMastoid series\r\nBarium enema\r\nBarium swallow\r\nEndoscopy of:\r\n\r\n');
INSERT INTO m_lib_notes_template VALUES (20,'TX','Pharmacologic  Tx','Give Amoxicillin____ TID X 1 week\r\nGive Cotrimoxazole_____ BID X 1 week\r\nGive Albendazole______ BID X 3 days\r\nGive FeSO4 _____ TID\r\nGive Multivitamins_____ OD\r\nGive Paracetamol______ q4 for Temp of >37.8\r\nGive Mefenamic acid_____ TID');
INSERT INTO m_lib_notes_template VALUES (21,'TX','Non Pharma Tx','Increase OFi\r\nBed rest\r\nTepid sponge bath\r\nSaline gargle\r\nLow salt diet\r\nLow fat diet\r\nLimit TFI to 1.5L\r\nDaily BP monitoring\r\nExercise regularly\r\nStop smoking\r\nCutdown alcohol intake\r\nPulmophysiotherapy\r\nAvoid skipping meals\r\nSmall frequent feeding\r\nAvoid triggers\r\nWarm compress');
INSERT INTO m_lib_notes_template VALUES (22,'TX','Follow up','Follow up after ____ days c/o ');

