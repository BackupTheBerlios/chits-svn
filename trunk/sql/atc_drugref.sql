-- ATC SQL
-- Adapted from drugref.org
-- November 26, 2004
-- Herman Tolentino MD
-- Validated with MySQL 3.23

CREATE TABLE atc (
    code varchar(7) NOT NULL,
    text text,
    primary key (code)
) type=InnoDB;

LOAD DATA INFILE '/home/hermant/public_html/game/sql/drugref_atc.txt'
    INTO TABLE atc
    FIELDS TERMINATED BY '\t'
    LINES TERMINATED BY '\n';
    
-- Ancestor table to mark tables for auditing
CREATE TABLE audit_drugs (
    audit_id float auto_increment NOT NULL,
    primary key (audit_id)
) type=InnoDB;


-- Source of any reference information in this database
-- source_category: 
--    p=peer reviewed
--    a=official authority 
--    i=independend source
--    m=manufacturer
--    o=other
--    s=self defined
-- description:
--    URL or address or similar informtion allowing to reproduce the source of information
CREATE TABLE info_reference (
    id float auto_increment NOT NULL,
    source_category enum ('p','a','i','m','o','s'),
    description text,
    primary key (id)
) type=InnoDB;

-- Listing of disease coding systems used for drug indication listing
-- iso_countrycode:
--    ISO country code of country where this code system applies. Use "**" for wildcard
-- name:
--    name of the code systme like ICD, ICPC
-- "version":
--    version of the code system, like "10" for ICD-10
-- revision:
--    revision of the version of the coding system/classification
CREATE TABLE code_systems (
    id float auto_increment NOT NULL,
    iso_countrycode char(2) DEFAULT '**',
    name varchar(30),
    version varchar(30),
    revision varchar(30),
    primary key (id)
) type=InnoDB;

-- Holds actual coding systems

CREATE TABLE disease_code (
    id float auto_increment NOT NULL,
    code varchar(20) NOT NULL,
    id_system integer,
    description text,
    primary key (id),
    unique key(code), 
    key (id_system),
    constraint fk_disease_code 
        foreign key (id_system) 
        references code_systems(id) 
        on update no action on delete no action
) type=InnoDB;

LOAD DATA INFILE '/home/hermant/public_html/game/sql/drugref_disease_code.txt'
    INTO TABLE disease_code
    FIELDS TERMINATED BY '\t'
    LINES TERMINATED BY '\n';

-- (SI) units used to quantify/measure drugs
-- description:
--    the formulation of the drug, such as "tablet", "cream", "suspension"
CREATE TABLE drug_units (
    id float auto_increment NOT NULL,
    unit varchar(30),
    primary key (id)
) type=InnoDB;

LOAD DATA INFILE '/home/hermant/public_html/game/sql/drugref_drug_units.txt'
    INTO TABLE drug_units
    FIELDS TERMINATED BY '\t'
    LINES TERMINATED BY '\n';

-- presentations or formulations of drugs like "tablet", "capsule" ...
CREATE TABLE drug_formulations (
    id float auto_increment NOT NULL,
    description varchar(60),
    comment text,
    primary key (id)
) type=InnoDB;

LOAD DATA INFILE '/home/hermant/public_html/game/sql/drugref_drug_formulations.txt'
    INTO TABLE drug_formulations
    FIELDS TERMINATED BY '\t'
    LINES TERMINATED BY '\n';

-- administration routes of drugs
-- description:
--    administration route of a drug like "oral", "sublingual", "intravenous" ...
CREATE TABLE drug_routes (
    id float auto_increment NOT NULL,
    description varchar(60),
    abbreviation varchar(10),
    comment text,
    primary key (id)
) type=InnoDB;

LOAD DATA INFILE '/home/hermant/public_html/game/sql/drugref_drug_routes.txt'
    INTO TABLE drug_routes
    FIELDS TERMINATED BY '\t'
    LINES TERMINATED BY '\n';

-- Collection of all drug elements: classes, compounds, and substances
-- category:
--    t = therapeutic class
--    p = pharmaceutical class
--    s = substance
--    c = compound
--    k= category
CREATE TABLE drug_element (
    id float auto_increment NOT NULL,
    category enum('t','p','s','c','k'),
    description text,
    primary key (id)
) type=InnoDB;

LOAD DATA INFILE '/home/hermant/public_html/game/sql/drugref_drug_element.txt'
    INTO TABLE drug_element
    FIELDS TERMINATED BY '\t'
    LINES TERMINATED BY '\n';

-- Many to many pivot table associating drug elements and ATC codes
CREATE TABLE link_drug_atc (
    id_drug float NOT NULL,
    atccode varchar(7) NOT NULL,
    key (id_drug),
    key (atccode),
    constraint fk_link_drug_atc1
        foreign key (id_drug) 
        references drug_element(id) 
        on update no action on delete no action,
    constraint fk_link_drug_atc2
        foreign key (atccode) 
        references atc(code) 
        on update no action on delete no action
) type=InnoDB;

LOAD DATA INFILE '/home/hermant/public_html/game/sql/drugref_link_drug_atc.txt'
    INTO TABLE link_drug_atc
    FIELDS TERMINATED BY '\t'
    LINES TERMINATED BY '\n';

-- Enumeration of categories of warnings associated with a 
--    specific drug (as in product information)
-- description:
--    the warning category such as "pregnancy", "lactation", "renal" ...
CREATE TABLE drug_warning_categories (
    id float auto_increment NOT NULL,
    description text,
    comment text,
    primary key (id)
) type=InnoDB;

LOAD DATA INFILE '/home/hermant/public_html/game/sql/drugref_drug_warning_categories.txt'
    INTO TABLE drug_warning_categories
    FIELDS TERMINATED BY '\t'
    LINES TERMINATED BY '\n';

-- Any warning associated with a specific drug
-- code:
--    could have been implemented as foreign key 
--    to a table of severity codes, but was considered uneccessary
CREATE TABLE drug_warning (
    id float auto_increment NOT NULL,
    id_warning float,
    id_reference float,
    code char(4),
    details text,
    primary key (id),
    key (id_warning),
    key (id_reference),
    constraint fk_drug_warning1 
        foreign key (id_warning) 
        references drug_warning_categories(id) 
        on update no action on delete no action,
    constraint fk_drug_warning2
        foreign key (id_reference) 
        references info_reference(id) 
        on update no action on delete no action
) type=InnoDB;

-- Topics for drug information, such as pharmaco-kinetics, indications, etc.
-- target:
--    the target of this information: h=health professional, p=patient
CREATE TABLE information_topic (
    id float auto_increment NOT NULL,
    title varchar(60),
    target enum('h','p'),
    unique key (id)
) type=InnoDB;

LOAD DATA INFILE '/home/hermant/public_html/game/sql/drugref_information_topic.txt'
    INTO TABLE information_topic
    FIELDS TERMINATED BY '\t'
    LINES TERMINATED BY '\n';

-- Any product information about a specific drug in HTML format
-- info:
--    the drug product information in HTML format
CREATE TABLE drug_information (
    id float auto_increment NOT NULL,
    id_info_reference integer,
    info text,
    id_topic float,
    comment text,
    primary key (id),
    key (id_info_reference),
    key (id_topic),
    constraint fk_drug_information1
        foreign key (id_info_reference) 
        references info_reference(id) 
        on update no action on delete no action,
    constraint fk_drug_information2
        foreign key (id_topic)
        references information_topic(id)
        on update no action on delete no action
) type=InnoDB;

LOAD DATA INFILE '/home/hermant/public_html/game/sql/drugref_drug_information.txt'
    INTO TABLE drug_information
    FIELDS TERMINATED BY '\t'
    LINES TERMINATED BY '\n';

-- This table allows synonyms / dictionary functionality for generic drug names
-- name:
--    the generic name of this drug, must be unique
CREATE TABLE generic_drug_name (
    id float auto_increment NOT NULL,
    id_drug float,
    name varchar(100),
    comment text,
    primary key (id),
    key (id_drug),
    constraint fk_generic_drug_name1
        foreign key (id_drug)
        references drug_element(id)
        on update no action on delete no action
) type=InnoDB;

LOAD DATA INFILE '/home/hermant/public_html/game/sql/drugref_generic_drug_name.txt'
    INTO TABLE generic_drug_name
    FIELDS TERMINATED BY '\t'
    LINES TERMINATED BY '\n';
    
-- links singular generic drugs to a 
--    compound drug (like Trimethoprim and Sulfamethoxazole to Cotrimoxazole)
CREATE TABLE link_compound_generics (
    id_compound float NOT NULL,
    id_component float NOT NULL,
    key (id_compound),
    key (id_component),
    constraint fk_link_compound_generics1
        foreign key (id_compound)
        references drug_element(id)
        on update no action on delete no action,
    constraint fk_link_compound_generics2
        foreign key (id_component)
        references drug_element(id)
        on update no action on delete no action
) type=InnoDB;

LOAD DATA INFILE '/home/hermant/public_html/game/sql/drugref_link_compound_generics.txt'
    INTO TABLE link_compound_generics
    FIELDS TERMINATED BY '\t'
    LINES TERMINATED BY '\n';

-- indicates in which country a specific 
--    generic drug name is in use. ''**'' marks the international name
CREATE TABLE link_country_drug_name (
    id_drug_name float,
    iso_countrycode char(2),
    key (id_drug_name),
    constraint fk_link_country_drug_name1
        foreign key (id_drug_name)
        references generic_drug_name(id)
        on update no action on delete no action
) type=InnoDB;

-- This is a drug-dose-route tuple. 
--    For dosage recommadations, 
--    and the basis for products and subsidies
-- id_drug_warning_categories:
--    indicates whether this dosage is targeted for 
--    specific patients, like paediatric or renal impairment
-- dosage_hints:
--    free text warnings, tips & hints regarding applying this dosage recommendation
CREATE TABLE drug_dosage (
    id float auto_increment NOT NULL,
    id_drug float,
    id_drug_warning_categories float,
    id_info_reference float,
    id_route float,
    dosage_hints text,
    primary key (id),
    key (id_drug),
    key (id_drug_warning_categories),
    key (id_info_reference),
    key (id_route),
    constraint fk_drug_dosage1
        foreign key (id_drug)
        references drug_element(id)
        on update no action on delete no action,
    constraint fk_drug_dosage2
        foreign key (id_drug_warning_categories)
        references drug_warning_categories(id)
        on update no action on delete no action,
    constraint fk_drug_dosage3
        foreign key (id_info_reference)
        references info_reference(id)
        on update no action on delete no action,
    constraint fk_drug_dosage4
        foreign key (id_route)
        references drug_routes(id)
        on update no action on delete no action
) type=InnoDB;

-- Dosage suggestion for a particular /substance/ (not compound). 
--    This the old dosage.
-- id_component:
--    the component of a compound referred to by this row
-- dosage_type:
--    *=absolute
--    w=weight based (per kg body weight)
--    s=surface based (per m2 body surface)
--    a=age based (in months)
-- dosage_start:
--    lowest value of recommended dosage range
-- dosage_max:
--    maximum value of recommended dosage range, zero if no range
CREATE TABLE substance_dosage (
    id float auto_increment NOT NULL,
    id_dosage float,
    id_unit float,
    id_component float,
    dosage_type enum('*','w','s','a'),
    dosage_start double,
    dosage_max double,
    primary key (id),
    key (id_route),
    key (id_unit),
    key (id_component),
    constraint fk_substance_dosage1
        foreign key (id_dosage)
        references drug_dosage(id)
        on update no action on delete no action,
    constraint fk_substance_dosage2
        foreign key (id_unit)
        references drug_units(id)
        on update no action on delete no action,
    constraint fk_substance_dosage3
        foreign key (id_component)
        references drug_element(id)
        on update no action on delete no action    
) type=InnoDB;

-- A many-to-many pivot table linking classes to drugs
CREATE TABLE link_drug_class (
    id_drug float,
    id_class float,
    key (id_drug),
    key (id_class),
    constraint fk_link_drug_class1
        foreign key (id_drug)
        references drug_element(id)
        on update no action on delete no action,
    constraint fk_link_drug_class2
        foreign key (id_class)
        references drug_element(id)
        on update no action on delete no action    
) type=InnoDB;

LOAD DATA INFILE '/home/hermant/public_html/game/sql/drugref_link_drug_class.txt'
    INTO TABLE link_drug_class
    FIELDS TERMINATED BY '\t'
    LINES TERMINATED BY '\n';

-- A many-to-many pivot table linking warnings to drugs
CREATE TABLE link_drug_warning (
    id_drug float,
    id_warning float,
    id float,
    key (id_drug),
    constraint fk_link_drug_warning1
        foreign key (id_drug)
        references drug_element(id)
        on update no action on delete no action,
    key (id_warning),
    constraint fk_link_drug_warning2
        foreign key (id_warning)
        references drug_warning(id)
        on update no action on delete no action
) type=InnoDB;

-- A many-to-many pivot table linking product information to drugs
CREATE TABLE link_drug_information (
    id_drug float NOT NULL,
    id_info float NOT NULL,
    key (id_drug),
    constraint fk_link_drug_information1
        foreign key (id_drug)
        references drug_element(id)
        on update no action on delete no action,
    key (id_info),
    constraint fk_link_drug_information2
        foreign key (id_info)
        references drug_information(id)
        on update no action on delete no action
) type=InnoDB;

LOAD DATA INFILE '/home/hermant/public_html/game/sql/drugref_link_drug_information.txt'
    INTO TABLE link_drug_information
    FIELDS TERMINATED BY '\t'
    LINES TERMINATED BY '\n';

CREATE TABLE severity_level (
    id float auto_increment NOT NULL,
    description varchar(100),
    comment text,
    primary key (id)
) type=InnoDB;

LOAD DATA INFILE '/home/hermant/public_html/game/sql/drugref_severity_level.txt'
    INTO TABLE severity_level
    FIELDS TERMINATED BY '\t'
    LINES TERMINATED BY '\n';

-- Listing of possible adverse effects to drug
-- severity:
--    the severity of a reaction. The scale has yet to be aggreed upon
-- description:
--    the type of adverse effect like "pruritus", "hypotension", ...
CREATE TABLE adverse_effects (
    id float auto_increment NOT NULL,
    severity float,
    description text,
    primary key (id),
    key (severity),
    constraint fk_adverse_effects
        foreign key (severity)
        references severity_level(id)
        on update no action on delete no action
) type=InnoDB;

LOAD DATA INFILE '/home/hermant/public_html/game/sql/drugref_adverse_effects.txt'
    INTO TABLE adverse_effects
    FIELDS TERMINATED BY '\t'
    LINES TERMINATED BY '\n';

-- Many to many pivot table linking drugs to adverse effects
-- frequency:
--    The likelihood this adverse effect happens: c=common, i=infrequent, r=rare
-- important:
--    modifier for attribute "frequency" allowing to weigh rare 
--    adverse effects too important to miss
CREATE TABLE link_drug_adverse_effects (
    id_drug float,
    id_adverse_effect float,
    frequency enum('c','i','r'),
    important bool,
    comment text,
    id integer auto_increment NOT NULL,
    primary key (id),
    key (id_drug),
    constraint fk_link_drug_adverse_effects1
        foreign key (id_drug)
        references drug_element(id)
        on update no action on delete no action,
    key (id_adverse_effect),
    constraint fk_link_drug_adverse_effects2
        foreign key (id_adverse_effect)
        references adverse_effects(id)
        on update no action on delete no action
) type=InnoDB;

-- Possible interactions between drug
-- description:
--    the type of interaction (like: "increases half life")
CREATE TABLE interactions (
    id float auto_increment NOT NULL,
    description text,
    primary key (id)
) type=InnoDB;

LOAD DATA INFILE '/home/hermant/public_html/game/sql/drugref_interactions.txt'
    INTO TABLE interactions
    FIELDS TERMINATED BY '\t'
    LINES TERMINATED BY '\n';

-- Many to many pivot table linking drugs and their interactions
CREATE TABLE link_drug_interactions (
    id float auto_increment NOT NULL,
    id_drug float,
    id_interacts_with float,
    id_interaction float,
    severity float,
    comment text,
    primary key (id),
    key (id_drug),
    constraint fk_link_drug_interactions1
        foreign key (id_drug)
        references drug_element(id)
        on update no action on delete no action,
    key (id_interacts_with),
    constraint fk_link_drug_interactions2
        foreign key (id_interacts_with)
        references drug_element(id)
        on update no action on delete no action,
    key (id_interaction),
    constraint fk_link_drug_interactions3
        foreign key (id_interaction)
        references interactions(id)
        on update no action on delete no action,
    key (severity),
    constraint fk_link_drug_interactions4
        foreign key (severity)
        references severity_level(id)
        on update no action on delete no action
) type=InnoDB;

-- Many to many pivot table linking interactions between drugs and diseases
CREATE TABLE link_drug_disease_interactions (
    id float auto_increment NOT NULL,
    id_drug float,
    id_disease_code float,
    id_interaction float,
    comment text,
    primary key (id),
    key (id_drug),
    constraint fk_link_drug_disease_interactions1
        foreign key (id_drug)
        references drug_element(id)
        on update no action on delete no action,
    key (id_disease_code),
    constraint fk_link_drug_disease_interactions2
        foreign key (id_disease_code)
        references disease_code(id)
        on update no action on delete no action,
    key (id_interaction),
    constraint fk_link_drug_disease_interactions3
        foreign key (id_interaction)
        references interactions(id)
        on update no action on delete no action
) type=InnoDB;

-- Dispensable form of a generic drug including strength, package size etc
-- id_packing_unit:
--    unit of drug "entities" as packed: for tablets and 
--    similar discrete formulations it should be the id of "each", 
--    for fixed-course kits it should be the id of "day"
-- amount:
--    for fluid drugs, the amount in each ampoule, syringe, etc. distinct of the
--    package size. For solid drugs (tablet, capsule), this is usually "1"
CREATE TABLE product (
    id float auto_increment NOT NULL,
    id_drug float,
    id_formulation float,
    id_packing_unit float,
    id_route float,
    amount double DEFAULT 1.0,
    comment text,
    primary key (id),
    key (id_drug),
    constraint fk_product1
        foreign key (id_drug)
        references drug_element(id)
        on update no action on delete no action,
    key (id_formulation),
    constraint fk_product2
        foreign key (id_formulation)
        references drug_formulations(id)
        on update no action on delete no action,
    key (id_packing_unit),
    constraint fk_product3
        foreign key (id_packing_unit)
        references drug_units(id)
        on update no action on delete no action,
    key (id_route),
    constraint fk_product4
        foreign key (id_route)
        references drug_routes(id)
        on update no action on delete no action
) type=InnoDB;

LOAD DATA INFILE '/home/hermant/public_html/game/sql/drugref_product.txt'
    INTO TABLE product
    FIELDS TERMINATED BY '\t'
    LINES TERMINATED BY '\n';

-- The various packing sizes available for this product
CREATE TABLE package_size (
    id_product float,
    size double,
    key (id_product),
    constraint fk_package_size1
        foreign key (id_product)
        references product(id)
        on update no action on delete no action
) type=InnoDB;

LOAD DATA INFILE '/home/hermant/public_html/game/sql/drugref_package_size.txt'
    INTO TABLE package_size
    FIELDS TERMINATED BY '\t'
    LINES TERMINATED BY '\n';

-- Many-to-many pivot table linking products with their components
CREATE TABLE link_product_component (
    id_product float,
    id_component float,
    strength double,
    id_unit float,
    key (id_product),
    constraint fk_link_product_component1
        foreign key (id_product)
        references product(id)
        on update no action on delete no action,
    key (id_component),
    constraint fk_link_product_component2
        foreign key (id_component)
        references drug_element(id)
        on update no action on delete no action,
    key (id_unit),
    constraint fk_link_product_component3
        foreign key (id_unit)
        references drug_units(id)
        on update no action on delete no action
) type=InnoDB;

LOAD DATA INFILE '/home/hermant/public_html/game/sql/drugref_link_product_component.txt'
    INTO TABLE link_product_component
    FIELDS TERMINATED BY '\t'
    LINES TERMINATED BY '\n';

-- Flags for adjuvants such as ''gluten-free'', ''paediatric formulation'', etc.
CREATE TABLE drug_flags (
    id float auto_increment NOT NULL,
    description varchar(100),
    primary key (id)
) type=InnoDB;

LOAD DATA INFILE '/home/hermant/public_html/game/sql/drugref_drug_flags.txt'
    INTO TABLE drug_flags
    FIELDS TERMINATED BY '\t'
    LINES TERMINATED BY '\n';

-- Many-to-many pivot table linking products to flags
CREATE TABLE link_flag_product (
    id_product float,
    id_flag float,
    key (id_product),
    constraint fk_link_flag_product1
        foreign key (id_product)
        references product(id)
        on update no action on delete no action,
    key (id_flag),
    constraint fk_link_flag_product2
        foreign key (id_flag)
        references drug_flags(id)
        on update no action on delete no action
) type=InnoDB;

-- Availability of products in specific countries - this 
--    allows multinational drug databases without redundancy
-- iso_countrycode:
--    ISO country code of the country where this drug product is available
-- available_from:
--    date from which on the product is available in this country (if known)
-- banned:
--    date from which on this product is/was banned in the specified country, if applicable
CREATE TABLE available (
    id_product float,
    iso_countrycode char(2),
    available_from date,
    banned date,
    comment text,
    key (id_product),
    constraint fk_available1
        foreign key (id_product)
        references product(id)
        on update no action on delete no action
) type=InnoDB;

LOAD DATA INFILE '/home/hermant/public_html/game/sql/drugref_available.txt'
    INTO TABLE available
    FIELDS TERMINATED BY '\t'
    LINES TERMINATED BY '\n';

-- List of pharmaceutical manufacturers
-- iso_countrycode:
--    ISO country code of the location of this company
-- address:
--    complete printable address with embeded newline characters
-- phone:
--    phone number of company
-- fax:
--    fax number of company
-- code:
--    two-letter symbol of manufacturer
CREATE TABLE manufacturer (
    id float auto_increment NOT NULL,
    iso_countrycode char(2),
    address text,
    phone text,
    fax text,
    comment text,
    code char(2),
    name varchar(100),
    primary key (id)
) type=InnoDB;

LOAD DATA INFILE '/home/hermant/public_html/game/sql/drugref_manufacturer.txt'
    INTO TABLE manufacturer
    FIELDS TERMINATED BY '\t'
    LINES TERMINATED BY '\n';

-- Many to many pivot table linking drug products and manufacturers
CREATE TABLE link_product_manufacturer (
    id_product float,
    id_manufacturer float,
    brandname varchar(60) DEFAULT 'GENERIC',
    key (id_product),
    constraint fk_link_product_manufacturer1
        foreign key (id_product)
        references product(id)
        on update no action on delete no action,
    key (id_manufacturer),
    constraint fk_link_product_manufacturer2
        foreign key (id_manufacturer)
        references manufacturer(id)
        on update no action on delete no action
) type=InnoDB;

LOAD DATA INFILE '/home/hermant/public_html/game/sql/drugref_link_product_manufacturer.txt'
    INTO TABLE link_product_manufacturer
    FIELDS TERMINATED BY '\t'
    LINES TERMINATED BY '\n';

-- Listing of possible subsidies for drug products
-- iso_countrycode:
--    ISO country code of the country where this subsidy applies
-- name:
--    description of the subsidy (like PBS or RPBS in Australia)
CREATE TABLE subsidies (
    id float auto_increment NOT NULL,
    iso_countrycode char(2),
    name varchar(30),
    comment text,
    primary key (id)
) type=InnoDB;

LOAD DATA INFILE '/home/hermant/public_html/game/sql/drugref_subsidies.txt'
    INTO TABLE subsidies
    FIELDS TERMINATED BY '\t'
    LINES TERMINATED BY '\n';

-- Normalised prescribing requirements for a drug or drugs
-- title:
--    short summary for selection in the database.
-- id_drug:
--    the drug or class to which this
--    condition *universially* applies.
-- authority:
--    true if prescriber must contact the third-party before approval
CREATE TABLE conditions (
    id float auto_increment NOT NULL,
    comment text,
    title varchar(60),
    id_subsidy float,
    id_drug float,
    authority boolean,
    primary key (id),
    key (id_subsidy),
    constraint fk_conditions1
        foreign key (id_subsidy)
        references subsidies(id)
        on update no action on delete no action,
    key (id_drug),
    constraint fk_conditions2
        foreign key (id_drug)
        references drug_element(id)
        on update no action on delete no action
) type=InnoDB;

-- Listing of drug products that may attract a subsidy. 
-- quantity:
--    quantity of packaged units dispensed under subsidy for any one prescription
--    AU: this the maximum quantity in the Yellow Book. 
--    DE: is the package size (N1, N2, N3), etc. 
--    Drugs are explicitly permitted to have several entries in this table for 
--    these different sizes. (DE only)
-- max_rpt:
--    maximum number of repeat (refill) authorizations allowed on any 
--    one subsidised prescription (series)
-- copayment:
--    patient co-payment under subsidy regulation; if this is absolute or 
--    percentage is regulation dependend and not specified here
-- restriction:
--    restriction applied only to this subsidy, not to the drug in general
CREATE TABLE subsidized_products (
    id float auto_increment NOT NULL,
    id_product float,
    id_subsidy float,
    quantity integer DEFAULT 1,
    max_rpt integer DEFAULT 0,
    copayment double DEFAULT 0.0,
    comment text,
    restriction text,
    primary key (id),
    key (id_product),
    constraint fk_subsidized_products1
        foreign key (id_product)
        references product(id)
        on update no action on delete no action,
    key (id_subsidy),
    constraint fk_subsidized_products2
        foreign key (id_subsidy)
        references subsidies(id)
        on update no action on delete no action
) type=InnoDB;

LOAD DATA INFILE '/home/hermant/public_html/game/sql/drugref_subsidized_products.txt'
    INTO TABLE subsidized_products
    FIELDS TERMINATED BY '\t'
    LINES TERMINATED BY '\n';

-- Many to many pivot table linking drug dosages and indications
-- id_disease_code:
--    link to the disease code
-- line:
--    the line (first-line, second-line) of this drug for this indication
CREATE TABLE link_dosage_indication (
    id float auto_increment NOT NULL,
    id_drug_dosage float,
    id_disease_code float,
    comment text,
    line float,
    primary key (id),
    key (id_drug_dosage),
    constraint fk_link_dosage_indication1
        foreign key (id_drug_dosage)
        references drug_dosage(id)
        on update no action on delete no action,
    key (id_disease_code),
    constraint fk_link_dosage_indication2
        foreign key (id_disease_code)
        references disease_code(id)
        on update no action on delete no action
) type=InnoDB;

-- Many to many pivot table linking whole drugs and indications
-- id_disease_code:
--    link to the disease code
-- line:
--    the line (first-line, second-line) of this drug for this indication
CREATE TABLE link_drug_indication (
    id float auto_increment NOT NULL,
    id_drug_dosage float NOT NULL,
    id_drug float,
    id_disease_code float,
    comment text,
    line float,
    primary key (id),
    key (id_drug),
    constraint fk_link_drug_indication1
        foreign key (id_drug)
        references drug_element(id)
        on update no action on delete no action,
    key (id_disease_code),
    constraint fk_link_drug_indication2
        foreign key (id_disease_code)
        references disease_code(id)
        on update no action on delete no action
) type=InnoDB;

-- Table for comments made o records of other tables
-- table_name:
--    name of the table contain ing the record.
-- table_row:
--    the value of the field ''id'' in this table (must exist)
-- who:
--    the database user making this comment
-- source:
--    the source the user used for their comment, if any
-- signature:
--    the GPG digital signature of the user
CREATE TABLE comments (
    id float auto_increment NOT NULL,
    table_name varchar(50),
    table_row integer,
    stamp timestamp ,
    who varchar(20),
    comment text,
    source integer,
    signature text,
    primary key (id)
) type=InnoDB;
