CREATE TABLE tx_smartmaps_domain_model_address (
	title varchar(255) NOT NULL DEFAULT '',
	street varchar(255) NOT NULL DEFAULT '',
	city varchar(255) NOT NULL DEFAULT '',
	zip varchar(255) NOT NULL DEFAULT '',
	country varchar(255) NOT NULL DEFAULT '',
	latitude double(11,6) NOT NULL DEFAULT '0',
	longitude double(11,6) NOT NULL DEFAULT '0',
	marker varchar(255) NOT NULL DEFAULT '',
	configuration_map varchar(255) NOT NULL DEFAULT '',
	image_size int(11) NOT NULL DEFAULT '0',
	image_width int(11) NOT NULL DEFAULT '0',
	image_height int(11) NOT NULL DEFAULT '0',
	info_window_content text NOT NULL DEFAULT '',
	info_window_image int(11) unsigned NOT NULL DEFAULT '0',
	categories int(11) NOT NULL DEFAULT '0'
);

CREATE TABLE tx_smartmaps_domain_model_map (
	title varchar(255) NOT NULL DEFAULT '',
	width varchar(255) NOT NULL DEFAULT '',
	height varchar(255) NOT NULL DEFAULT '',
	zoom int(11) NOT NULL DEFAULT '0',
	zoom_min int(11) NOT NULL DEFAULT '0',
	zoom_max int(11) NOT NULL DEFAULT '0',
	default_type int(11) NOT NULL DEFAULT '0',
	longitude double(11,6) NOT NULL DEFAULT '0',
	latitude double(11,6) NOT NULL DEFAULT '0',
	marker_cluster tinyint(1) NOT NULL DEFAULT '0',
	marker_cluster_zoom int(11) NOT NULL DEFAULT '0',
	marker_cluster_size int(11) NOT NULL DEFAULT '0',
	defaultmarker int(11) NOT NULL DEFAULT '0',
	address text NOT NULL
);

CREATE TABLE tx_smartmap_domain_model_address_mm(
    uid_local       int(11) unsigned DEFAULT '0' NOT NULL,
    uid_foreign     int(11) unsigned DEFAULT '0' NOT NULL,
    sorting         int(11) unsigned DEFAULT '0' NOT NULL,
    sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,

    KEY uid_local (uid_local),
    KEY uid_foreign (uid_foreign)
);


CREATE TABLE sys_category (
	map_marker       int(11) unsigned    DEFAULT '0' NOT NULL,
	map_image_size   tinyint(1) unsigned DEFAULT '0' NOT NULL,
	map_image_width  int(11)             DEFAULT '0' NOT NULL,
	map_image_height int(11)             DEFAULT '0' NOT NULL,
);