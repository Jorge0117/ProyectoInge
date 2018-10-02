CREATE TABLE roles (
    role_id VARCHAR(24) NOT NULL,
    PRIMARY KEY (role_id)
);

CREATE TABLE permissions (
    permission_id VARCHAR(30) NOT NULL,
    description VARCHAR(100),
    PRIMARY KEY (permission_id)
);

CREATE TABLE permissions_roles (
    permission_id VARCHAR(30) NOT NULL,
    role_id VARCHAR(24) NOT NULL,
    FOREIGN KEY (role_id)
        REFERENCES roles (role_id),
    FOREIGN KEY (permission_id)
        REFERENCES permissions (permission_id),
    PRIMARY KEY (role_id , permission_id)
);