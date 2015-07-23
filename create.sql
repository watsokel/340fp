CREATE TABLE medical_office_assistants(
mID INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
first_name VARCHAR( 255 ) DEFAULT  'Temporary',
last_name VARCHAR( 255 ) DEFAULT  'Assistant'
) ENGINE = INNODB

CREATE TABLE healthcare_provider(
hID INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
first_name VARCHAR( 255 ) NOT NULL ,
last_name VARCHAR( 255 ) NOT NULL ,
profession VARCHAR( 255 ) NOT NULL ,
license INT( 11 ) UNIQUE
) ENGINE = INNODB;

CREATE TABLE patients(
pID INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
first_name VARCHAR( 255 ) NOT NULL ,
last_name VARCHAR( 255 ) NOT NULL ,
birthdate DATE
) ENGINE = INNODB;

CREATE TABLE appointments(
aID INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
date_time DATETIME NOT NULL ,
reason TEXT,
provider_ID INT( 11 ) NOT NULL ,
patient_ID INT( 11 ) NOT NULL ,
assistant_ID INT( 11 ) NOT NULL ,
FOREIGN KEY ( patient_ID ) REFERENCES patients( pID ) ,
FOREIGN KEY ( provider_id ) REFERENCES healthcare_provider( hID ) ,
FOREIGN KEY ( assistant_id ) REFERENCES medical_office_assistants( mID )
) ENGINE = INNODB;

CREATE TABLE medications(
name varchar(255) PRIMARY KEY,
)ENGINE=InnoDB;

CREATE TABLE medical_conditions(
name varchar(255) PRIMARY KEY
)ENGINE=InnoDB;

CREATE TABLE takes(
patient_ID INT( 11 ) NOT NULL ,
drug_name VARCHAR( 255 ) NOT NULL ,
FOREIGN KEY ( patient_ID ) REFERENCES patients( pID ) ,
FOREIGN KEY ( drug_name ) REFERENCES medications( name ) ,
PRIMARY KEY ( patient_ID, drug_name )
) ENGINE = INNODB

CREATE TABLE diagnosed(
patient_ID INT( 11 ) NOT NULL ,
diagnosis VARCHAR( 255 ) NOT NULL ,
FOREIGN KEY ( patient_ID ) REFERENCES patients( pID ) ,
FOREIGN KEY ( diagnosis ) REFERENCES medical_conditions( name ) ,
PRIMARY KEY ( patient_ID, diagnosis )
) ENGINE = INNODB;


