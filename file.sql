CREATE DATABASE mzoori;
use mzoori;

CREATE TABLE orders (
  id int(8) NOT NULL AUTO_INCREMENT,
  status int(1) NOT NULL,
  transaction_id varchar(64) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1; 

