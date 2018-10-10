Create Table requirements(
	requirement_number	INT	         Primary Key,
	description         VARCHAR(250) Not Null,
	type		        ENUM('Obligatorio', 'Opcional')	 Not Null
);

Create Table fulfills_requirement (
	requirement_id	    INT 	Not Null,
	application_id		INT	    Not Null,
	is_fulfilled		Bool	Not Null Default false,
	FOREIGN KEY (requirement_id) References requirements(requirement_number),
	FOREIGN KEY (application_id) References applications(application_number),
	PRIMARY KEY (requirement_id, application_id)
);
