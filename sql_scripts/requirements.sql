Create Table requirements(
	requirements_number	        INT	Primary Key,
	requirements_description    VARCHAR(250)	Not Null,
	requirements_type		    Char			Not Null
);

Create Table states_requirements(
	requirements_number	INT 	Not Null,
	request_number		INT	    Not Null,
	request_state		        Bool	Not Null Default 0,
	FOREIGN KEY (requirements_number) References requirements(requirements_number),
	FOREIGN KEY (request_number) References Request(request_number),
	PRIMARY KEY (requirements_number, request_number)
);
