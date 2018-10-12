CREATE TABLE rounds (
    round_number    tinyint NOT NULL,
    semester        tinyint NOT NULL,
    year            year(4) NOT NULL,
    start_date      DATETIME NOT NULL,
    end_date        DATETIME NOT NULL,
    approve_limit_date DATETIME NOT NULL,
    PRIMARY KEY (round_number,semester, year)
 );
