Create Table requirements(
	id        INT	Primary Key,
	requirements_description    VARCHAR(250)	Not Null,
	requirements_type		    Char			Not Null
);

Create Table states_requirements(
	requirements_id	INT 	Not Null,
	request_id		INT	    Not Null,
	request_state		        Bool	Not Null Default 0,
	FOREIGN KEY (requirements_id) References requirements(requirements_id),
	FOREIGN KEY (request_id) References Request(request_id),
	PRIMARY KEY (requirements_id, request_id)
);
