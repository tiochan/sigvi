/**
	This is a MySQL SQL code to create the tables.

	Adapt the SQL to your Database system and create them on your application
	database.
*/

create table repositories (
  id_repository mediumint(9) not null auto_increment,
  name varchar(60) not null,
  id_group mediumint(9) default null,
  description varchar(255) default null,
  dbserver varchar(100) not null,
  dbtype varchar(15) not null,
  dbuser varchar(60) default null,
  dbname varchar(60) not null,
  dbpass varchar(255) default null,
  enabled int(1) default null,
  primary key  (id_repository),
  unique key name (name)
);

create table imported_servers(
 id_imported_servers mediumint(9) not null auto_increment,
 id_repository mediumint(9) not null,
 remote_id_server mediumint(9) not null,
 local_id_server mediumint(9) not null,
 primary key (id_imported_servers),
 unique key imp_uniq (id_repository, remote_id_server, local_id_server)
);

create table imported_services(
 id_imported_services mediumint(9) not null auto_increment,
 id_repository mediumint(9) not null,
 remote_id_service mediumint(9) not null,
 local_id_service mediumint(9) not null,
 revision mediumint(9) not null default 0,
 primary key (id_imported_services),
 unique key imp_uniq (id_repository, remote_id_service, local_id_service)
);

