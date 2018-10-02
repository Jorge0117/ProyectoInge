Create Table requirements(
	requirements_Number	        INT	Primary Key,
	requirements_Description    VARCHAR(250)	Not Null,
	requirements_Type		    Char			Not Null
);

Create Table states_requirements(
	requirements_Number	INT 	Not Null,
	request_Number		INT	    Not Null,
	request_State		        Bool	Not Null Default 0,
	FOREIGN KEY (requirements_Number) References requirements(requirements_Number),
	FOREIGN KEY (request_Number) References Request(request_Number),
	PRIMARY KEY (requirements_Number, request_Number)
);
