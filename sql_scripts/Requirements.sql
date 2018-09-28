Create Table Requirements(
	Requirements_Number	INT	Primary Key,
	Description    	    VARCHAR(250)	Not Null,
	Type		        Char			Not Null
);

Create Table States_Requirements(
	Requirements_Number	INT 	Not Null,
	Request_Number		INT	    Not Null,
	State		        Bool	Not Null Default 0,
	FOREIGN KEY (Requirements_Number) References Requirements(Requirements_Number),
	FOREIGN KEY (Request_Number) References Request(Request_Number),
	PRIMARY KEY (Requirements_Number, Request_Number)
);
