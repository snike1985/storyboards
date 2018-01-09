<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

global $wpdb;


//affiliates_signups
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX .
	"administrators_stats'" ) != PVS_DB_PREFIX . 'administrators_stats' )
{

	$sql = 'CREATE TABLE `' . PVS_DB_PREFIX . 'administrators_stats` (
	  `id` int(11) NOT NULL auto_increment,
	  `property` varchar(100) default NULL,
	  `property_value` int(11) default NULL,
	  `administrator_id` int(11) default NULL,
	  PRIMARY KEY  (`id`),
	  KEY `administrator_id` (`administrator_id`),
	  KEY `property` (`property`)
	)';
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'administrators_stats` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}


//affiliates_signups
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX .
	"affiliates_signups'" ) != PVS_DB_PREFIX . 'affiliates_signups' )
{

	$sql = 'CREATE TABLE `' . PVS_DB_PREFIX . 'affiliates_signups` (
	  `id` int(11) NOT NULL auto_increment,
	  `userid` int(11) default NULL,
	  `types` varchar(50) default NULL,
	  `types_id` int(11) default NULL,
	  `rates` float default NULL,
	  `total` float default NULL,
	  `data` int(11) default NULL,
	  `aff_referal` int(11) default NULL,
	  `status` tinyint(4) default NULL,
	  `description` text,
	  `gateway` varchar(50) default NULL,
	  PRIMARY KEY  (`id`),
	  KEY `userid` (`userid`),
	  KEY `types` (`types`),
	  KEY `types_id` (`types_id`),
	  KEY `total` (`total`),
	  KEY `data` (`data`),
	  KEY `aff_referal` (`aff_referal`),
	  KEY `status` (`status`)
	)';
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'affiliates_signups` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//affiliates_stats
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "affiliates_stats'" ) !=
	PVS_DB_PREFIX . 'affiliates_stats' )
{

	$sql = 'CREATE TABLE `' . PVS_DB_PREFIX . 'affiliates_stats` (
	  `id` int(11) NOT NULL auto_increment,
	  `userid` int(11) default NULL,
	  `seller` int(11) default NULL,
	  `buyer` int(11) default NULL,
	  `data` int(11) default NULL,
	  `ip` varchar(100) default NULL,
	  `aff_referal` int(11) default NULL,
	  PRIMARY KEY  (`id`),
	  KEY `userid` (`userid`),
	  KEY `seller` (`seller`),
	  KEY `buyer` (`buyer`),
	  KEY `data` (`data`),
	  KEY `aff_referal` (`aff_referal`)
	)';
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'affiliates_stats` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//audio_fields
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "audio_fields'" ) !=
	PVS_DB_PREFIX . 'audio_fields' )
{

	$sql = 'CREATE TABLE `' . PVS_DB_PREFIX . 'audio_fields` (
	  `id` int(11) NOT NULL auto_increment,
	  `name` varchar(250) default NULL,
	  `priority` int(11) default NULL,
	  `activ` int(11) default NULL,
	  `required` int(11) default NULL,
	  `always` int(11) default NULL,
	  `fname` varchar(20) default NULL,
	  PRIMARY KEY  (`id`)
	)';
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"audio_fields` VALUES(1, 'category', 1, 1, 1, 1, 'folder')";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"audio_fields` VALUES(2, 'title', 2, 1, 1, 1, 'title')";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"audio_fields` VALUES(3, 'description', 3, 1, 1, 0, 'description')";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"audio_fields` VALUES(4, 'keywords', 4, 1, 1, 0, 'keywords')";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"audio_fields` VALUES(5, 'file for sale', 5, 1, 1, 1, 'sale')";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"audio_fields` VALUES(6, 'preview audio', 6, 1, 1, 1, 'previewaudio')";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"audio_fields` VALUES(7, 'preview picture', 7, 1, 1, 1, 'previewpicture')";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"audio_fields` VALUES(9, 'duration', 9, 1, 1, 0, 'duration')";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"audio_fields` VALUES(10, 'track source', 10, 1, 1, 0, 'source')";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"audio_fields` VALUES(11, 'track format', 11, 1, 1, 0, 'format')";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"audio_fields` VALUES(12, 'copyright holder', 12, 1, 1, 0, 'holder')";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"audio_fields` VALUES(13, 'terms and conditions', 13, 1, 1, 0, 'terms')";
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'audio_fields` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//audio_format
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "audio_format'" ) !=
	PVS_DB_PREFIX . 'audio_format' )
{

	$sql = 'CREATE TABLE `' . PVS_DB_PREFIX . 'audio_format` (
	  `id` int(11) NOT NULL auto_increment,
	  `name` varchar(250) default NULL,
	  PRIMARY KEY  (`id`)
	)';
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "audio_format` VALUES(1, 'Mono');";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "audio_format` VALUES(2, 'Stereo');";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "audio_format` VALUES(3, '5.1');";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "audio_format` VALUES(4, '7.1');";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "audio_format` VALUES(5, 'Other');";
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'audio_format` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//audio_source
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "audio_source'" ) !=
	PVS_DB_PREFIX . 'audio_source' )
{

	$sql = 'CREATE TABLE `' . PVS_DB_PREFIX . 'audio_source` (
	  `id` int(11) NOT NULL auto_increment,
	  `name` varchar(250) default NULL,
	  PRIMARY KEY  (`id`)
	)';
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "audio_source` VALUES(1, 'Wav')";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "audio_source` VALUES(2, 'MP3')";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "audio_source` VALUES(4, 'Other')";
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'audio_source` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//audio_types
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "audio_types'" ) !=
	PVS_DB_PREFIX . 'audio_types' )
{

	$sql = 'CREATE TABLE `' . PVS_DB_PREFIX . 'audio_types` (
	  `id_parent` int(11) NOT NULL auto_increment,
	  `title` varchar(200) default NULL,
	  `types` varchar(200) default NULL,
	  `price` float default NULL,
	  `priority` int(11) default NULL,
	  `shipped` int(11) default NULL,
	  `license` int(10) NOT NULL,
	  `thesame` int(11) default NULL,
	  KEY `id_parent` (`id_parent`),
	  KEY `priority` (`priority`),
	  KEY `license` (`license`),
	  KEY `thesame` (`thesame`)
	)';
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"audio_types` VALUES(4801, 'MP3', 'mp3', 1, 1, 0, 4583, 1)";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"audio_types` VALUES(4802, 'WAV', 'wav', 2, 2, 0, 4583, 2)";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"audio_types` VALUES(5893, 'Shipped CD', 'shipped', 10, 5, 1, 4583, 0)";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"audio_types` VALUES(6783, 'MP3', 'mp3', 10, 1, 0, 4584, 1)";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"audio_types` VALUES(6784, 'Shipped CD', 'shipped', 100, 3, 1, 4584, 0)";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"audio_types` VALUES(6785, 'WAV', 'wav', 20, 2, 0, 4584, 2)";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"audio_types` VALUES(6788, 'ZIP', 'zip', 3, 3, 0, 4583, 0)";
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'audio_types` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}



//carts
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "carts'" ) !=
	PVS_DB_PREFIX . 'carts' )
{

	$sql = 'CREATE TABLE `' . PVS_DB_PREFIX . 'carts` (
	  `id` int(11) NOT NULL auto_increment,
	  `session_id` varchar(200) default NULL,
	  `data` int(11) default NULL,
	  `user_id` int(11) default NULL,
	  `order_id` int(11) default NULL,
	  `ip` varchar(50) default NULL,
	  `checked` tinyint(4) default NULL,
	  PRIMARY KEY  (`id`),
	  KEY `session_id` (`session_id`),
	  KEY `data` (`data`),
	  KEY `user_id` (`user_id`),
	  KEY `order_id` (`order_id`),
	  KEY `checked` (`checked`)
	)';
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'carts` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//carts_content
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "carts_content'" ) !=
	PVS_DB_PREFIX . 'carts_content' )
{

	$sql = 'CREATE TABLE `' . PVS_DB_PREFIX . 'carts_content` (
	  `id` int(11) NOT NULL auto_increment,
	  `id_parent` int(11) default NULL,
	  `item_id` int(11) default NULL,
	  `prints_id` int(11) default NULL,
	  `publication_id` int(11) default NULL,
	  `quantity` int(11) default NULL,
	  `option1_id` int(11) default NULL,
	  `option1_value` varchar(250) default NULL,
	  `option2_id` int(11) default NULL,
	  `option2_value` varchar(250) default NULL,
	  `option3_id` int(11) default NULL,
	  `option3_value` varchar(250) default NULL,
	  `rights_managed` varchar(250) default NULL,
	  `printslab` tinyint(4) default NULL,
	  `option4_id` int(11) default NULL,
	  `option5_id` int(11) default NULL,
	  `option6_id` int(11) default NULL,
	  `option7_id` int(11) default NULL,
	  `option8_id` int(11) default NULL,
	  `option9_id` int(11) default NULL,
	  `option10_id` int(11) default NULL,
	  `option4_value` varchar(250) default NULL,
	  `option5_value` varchar(250) default NULL,
	  `option6_value` varchar(250) default NULL,
	  `option7_value` varchar(250) default NULL,
	  `option8_value` varchar(250) default NULL,
	  `option9_value` varchar(250) default NULL,
	  `option10_value` varchar(250) default NULL,
	  `stock` tinyint(4) default NULL,
	  `stock_type` varchar(50) default NULL,
	  `stock_id` int(11) default NULL,
	  `stock_url` text,
	  `stock_preview` text,
	  `stock_site_url` text,
	  `x1` int(11) default NULL,
	  `y1` int(11) default NULL,
	  `x2` int(11) default NULL,
	  `y2` int(11) default NULL,
	  `print_width` int(11) default NULL,
	  `print_height` int(11) default NULL,
	  collection tinyint,
	  PRIMARY KEY  (`id`),
	  KEY `id_parent` (`id_parent`),
	  KEY `item_id` (`item_id`),
	  KEY `prints_id` (`prints_id`),
	  KEY `publication_id` (`publication_id`)
	)';
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'carts_content` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//category
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "category'" ) !=
	PVS_DB_PREFIX . 'category' )
{

	$sql = 'CREATE TABLE `' . PVS_DB_PREFIX . 'category` (
	  `id` int(11) NOT NULL auto_increment,
	  `id_parent` int(11) default NULL,
	  `title` varchar(200) default NULL,
	  `priority` int(11) default NULL,
	  `password` varchar(200) default NULL,
	  `description` text,
	  `photo` varchar(200) default NULL,
	  `upload` tinyint(1) default NULL,
	  `userid` int(11) default NULL,
	  `published` tinyint(1) default NULL,
	  `url` varchar(250) default NULL,
	  `keywords` text,
	  `featured` tinyint(4) default NULL,
	  creation_date int, activation_date int, 
	  expiration_date int,
	  location varchar(255),
	  google_x double,
	  google_y double,
	  PRIMARY KEY  (`id`),
	  KEY `id_parent` (`id_parent`),
	  KEY `priority` (`priority`),
	  KEY `title` (`title`),
	  KEY `creation_date` (`creation_date`),
	  KEY `expiration_date` (`expiration_date`),
	  KEY `location` (`location`),
	  KEY `google_x` (`google_x`),
	  KEY `google_y` (`google_y`)
	)';
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'category` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//category_stock
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "category_stock'" ) !=
	PVS_DB_PREFIX . 'category_stock' )
{

	$sql = 'CREATE TABLE `' . PVS_DB_PREFIX . 'category_stock` (
	  `id` int(11) default NULL,
	  `title` varchar(100) default NULL,
	  `stock` varchar(20) default NULL,
	  KEY `id` (`id`),
	  KEY `stock` (`stock`)
	)';
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'category_stock` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//category_items
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "category_items'" ) !=
	PVS_DB_PREFIX . 'category_items' )
{

	$sql = 'CREATE TABLE `' . PVS_DB_PREFIX . 'category_items` (
  `id` int(11) NOT NULL auto_increment,
  `category_id` int(11) default NULL,
  `publication_id` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `category_id` (`category_id`),
  KEY `publication_id` (`publication_id`),
  KEY `category_publication` (`category_id`,`publication_id`)
)';
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'category_items` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//colors
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "colors'" ) !=
	PVS_DB_PREFIX . 'colors' )
{

	$sql = 'CREATE TABLE `' . PVS_DB_PREFIX . 'colors` (
	  `id` int(11) NOT NULL auto_increment,
	  `publication_id` int(11) default NULL,
	  color varchar(6),
	  red int(3),
	  green int(3),
	  blue int(3),
	  priority int(2),
	  PRIMARY KEY  (`id`),
	  KEY `publication_id` (`publication_id`),
	  KEY `color` (`color`),
	  KEY `priority` (`priority`),
	  KEY reg_green_blue (red,green,blue)
	)';
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'colors` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//collections
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "collections'" ) !=
	PVS_DB_PREFIX . 'collections' )
{

	$sql = 'CREATE TABLE `' . PVS_DB_PREFIX . 'collections` (
	  `id` int(11) NOT NULL auto_increment,
	  title varchar(250),
	  description text,
	  price float,
	  active tinyint,
	  types tinyint,
	  PRIMARY KEY  (`id`),
	  KEY `active` (`active`),
	  KEY `types` (`types`)
	)';
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'collections` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//collections_items
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "collections_items'" ) !=
	PVS_DB_PREFIX . 'collections_items' )
{

	$sql = 'CREATE TABLE `' . PVS_DB_PREFIX . 'collections_items` (
	  `id` int(11) NOT NULL auto_increment,
	  collection_id int,
	  publication_id int,
	  category_id int,
	  PRIMARY KEY  (`id`),
	  KEY `active` (`publication_id`),
	  KEY `types` (`category_id`),
	  KEY `collection_publication` (`collection_id`,`publication_id`),
	  KEY `collection_category` (`collection_id`,`category_id`)
	)';
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'collections_items` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//commission
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "commission'" ) !=
	PVS_DB_PREFIX . 'commission' )
{

	$sql = 'CREATE TABLE `' . PVS_DB_PREFIX . 'commission` (
	  `id` int(11) NOT NULL auto_increment,
	  `total` float default NULL,
	  `user` int(11) default NULL,
	  `orderid` int(11) default NULL,
	  `item` int(11) default NULL,
	  `publication` int(11) default NULL,
	  `types` varchar(20) default NULL,
	  `data` int(11) default NULL,
	  `gateway` varchar(100) default NULL,
	  `description` varchar(250) default NULL,
	  `status` tinyint(4) default NULL,
	  PRIMARY KEY  (`id`),
	  KEY `user` (`user`),
	  KEY `orderid` (`orderid`),
	  KEY `item` (`item`),
	  KEY `total` (`total`),
	  KEY `status` (`status`)
	)';
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'commission` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//components
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "components'" ) !=
	PVS_DB_PREFIX . 'components' )
{

	$sql = 'CREATE TABLE `' . PVS_DB_PREFIX . 'components` (
	  `id` int(11) NOT NULL auto_increment,
	  `title` varchar(250) default NULL,
	  `content` varchar(50) default NULL,
	  `quantity` int(11) default NULL,
	  `types` varchar(50) default NULL,
	  `category` int(11) default NULL,
	  `user` varchar(50) default NULL,
	  `template` int(11) default NULL,
	  PRIMARY KEY  (`id`)
	)';
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "components` VALUES(2, 'New photos', 'photo2', 12, 'new', 0, '', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "components` VALUES(4, 'Featured photos', 'photo2', 12, 'featured', 0, '', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "components` VALUES(5, 'Most Downloaded photos', 'photo2', 12, 'downloaded', 0, '', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "components` VALUES(6, 'Popular photos', 'photo2', 12, 'popular', 0, '', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "components` VALUES(7, 'Free photos', 'photo2', 12, 'free', 0, '', 1)";
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'components` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//content_filter
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "content_filter'" ) !=
	PVS_DB_PREFIX . 'content_filter' )
{

	$sql = 'CREATE TABLE `' . PVS_DB_PREFIX . 'content_filter` (
	  `words` text
	)';
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "content_filter` VALUES('bad,words')";
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'content_filter` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//content_type
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "content_type'" ) !=
	PVS_DB_PREFIX . 'content_type' )
{

	$sql = 'CREATE TABLE `' . PVS_DB_PREFIX . 'content_type` (
	  `id_parent` int(11) NOT NULL auto_increment,
	  `priority` int(11) default NULL,
	  `name` varchar(200) default NULL,
	  KEY `id_parent` (`id_parent`),
	  KEY `name` (`name`),
	  KEY `priority` (`priority`)
	)';
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "content_type` VALUES(1, 1, 'Common')";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "content_type` VALUES(2, 2, 'Premium')";
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'content_type` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//countries
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "countries'" ) !=
	PVS_DB_PREFIX . 'countries' )
{

	$sql = 'CREATE TABLE `' . PVS_DB_PREFIX . 'countries` (
	  `id` int(11) NOT NULL auto_increment,
	  `name` varchar(50) default NULL,
	  `activ` tinyint(4) default NULL,
	  `priority` int(11) default NULL,
	  PRIMARY KEY  (`id`),
	  KEY `activ` (`activ`),
	  KEY `priority` (`priority`)
	)';
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(1, 'Afghanistan', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(2, 'Albania', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(3, 'Algeria', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(4, 'Andorra', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "countries` VALUES(5, 'Angola', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(6, 'Anguilla', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(7, 'Antarctica', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(8, 'Antigua', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(9, 'Argentina', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(10, 'Armenia', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "countries` VALUES(11, 'Aruba', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(12, 'Australia', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(13, 'Austria', 1, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(14, 'Azerbaijan', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(15, 'Bahamas', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(16, 'Bahrain', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(17, 'Bangladesh', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(18, 'Barbados', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(19, 'Belarus', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(20, 'Belgium', 1, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(21, 'Belize', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "countries` VALUES(22, 'Benin', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(23, 'Bermuda', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(24, 'Bhutan', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(25, 'Bolivia', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(26, 'Bosnia/Hercegovina', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(27, 'Botswana', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(28, 'Brazil', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(29, 'Brunei', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(30, 'Bulgaria', 1, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(31, 'Burkina Faso', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "countries` VALUES(32, 'Burma', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(33, 'Burundi', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(34, 'Cambodia Dem.', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(35, 'Cameroon', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(36, 'Canada', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(37, 'Cape Verde', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(38, 'Cayman Islands', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(39, 'Central African Republic', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "countries` VALUES(40, 'Chad', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "countries` VALUES(41, 'Chile', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "countries` VALUES(42, 'China', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(43, 'Cocos Islands', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(44, 'Colombia', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(45, 'Comoros', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "countries` VALUES(46, 'Congo', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(47, 'Cook Islands', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(48, 'Costa Rica', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(49, 'Cote D Ivoire', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(50, 'Croatia', 1, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "countries` VALUES(51, 'Cuba', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(52, 'Cyprus', 1, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(53, 'Czech Republic', 1, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(54, 'Denmark', 1, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(55, 'Djibouti', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(56, 'Dominica', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(57, 'Dominican Republic', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(58, 'Ecuador', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "countries` VALUES(59, 'Egypt', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(60, 'El Salvador', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(61, 'Equatorial Guinea', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(62, 'Estonia', 1, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(63, 'Ethiopia', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(64, 'Falkland Islands', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(65, 'Faroe Islands', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "countries` VALUES(66, 'Fiji', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(67, 'Finland', 1, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(68, 'France', 1, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(69, 'French Guiana', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(70, 'French Polynesia', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "countries` VALUES(71, 'Gabon', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(72, 'Gambia', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(73, 'Georgia', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(74, 'Germany', 1, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "countries` VALUES(75, 'Ghana', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(76, 'Gibraltar', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(77, 'Greece', 1, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(78, 'Greenland', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(79, 'Grenada', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(80, 'Guadeloupe', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "countries` VALUES(81, 'Guam', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(82, 'Guatemala', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(83, 'Guinea', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(84, 'Guinea-Bissau', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(85, 'Guyana', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "countries` VALUES(86, 'Haiti', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(87, 'Honduras', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(88, 'Hong Kong', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(89, 'Hungary', 1, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(90, 'Iceland', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "countries` VALUES(91, 'India', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(92, 'Indonesia', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "countries` VALUES(93, 'Iran', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "countries` VALUES(94, 'Iraq', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(95, 'Ireland', 1, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(96, 'Israel', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "countries` VALUES(97, 'Italy', 1, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(98, 'Jamaica', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "countries` VALUES(99, 'Japan', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(100, 'Jordan', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(101, 'Kazakhstan', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(102, 'Kenya', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(103, 'Kiribati', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(104, 'Korea, Democratic Peoples Repbulic', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(105, 'Korea, Rep. Of', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(106, 'Kuwait', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(107, 'Laos Peoples Democratic Republic', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(108, 'Latvia', 1, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(109, 'Lebanon', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(110, 'Lesotho', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(111, 'Liberia', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(112, 'Libyan Arab Jamahiriya', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(113, 'Liechtenstein', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(114, 'Lithuania', 1, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(115, 'Luxembourg', 1, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(116, 'Macau', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(117, 'Madagascar', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(118, 'Malawi', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(119, 'Malaysia', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(120, 'Maldives', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "countries` VALUES(121, 'Mali', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(122, 'Malta', 1, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(123, 'Marshall Islands', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(124, 'Martinique', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(125, 'Mauritania', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(126, 'Mauritius', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(127, 'Mayotte', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(128, 'Mexico', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(129, 'Micronesia', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(130, 'Moldova', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(131, 'Monaco', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(132, 'Mongolia', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(133, 'Montserrat', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(134, 'Morocco', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(135, 'Mozambique', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(136, 'Myanmar', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(137, 'Namibia', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(138, 'Nauru', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(139, 'Nepal', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(140, 'Neth. Antilles Nevis', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(141, 'Netherlands', 1, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(142, 'New Caledonia', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(143, 'New Zealand', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(144, 'Nicaragua', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(145, 'Niger', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(146, 'Nigeria', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "countries` VALUES(147, 'Niue', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(148, 'Norfolk Island', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(149, 'Northern Mariana', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(150, 'Norway', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "countries` VALUES(151, 'Oman', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(152, 'Pakistan', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(153, 'Palau', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(154, 'Panama', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(155, 'Papua New Guinea', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(156, 'Paraguay', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "countries` VALUES(157, 'Peru', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(158, 'Philippines', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(159, 'Poland', 1, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(160, 'Portugal', 1, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(161, 'Puerto Rico', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(162, 'Qatar', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(163, 'Romania', 1, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(164, 'Russia', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(165, 'Rwanda', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(166, 'Samoa (American)', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(167, 'Samoa (Western)', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(168, 'San Marino', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(169, 'Sao Tome & Principe', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(170, 'Saudi Arabia', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(171, 'Senegal', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(172, 'Serbia', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(173, 'Seychelles', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(174, 'Sierra Leone', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(175, 'Singapore', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(176, 'Slovakia', 1, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(177, 'Slovenia', 1, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(178, 'Solomon Islands', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(179, 'Somalia', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(180, 'South Africa', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(181, 'Spain', 1, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(182, 'Sri Lanka', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(183, 'St. Kitts & Nevis', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(184, 'St. Lucia', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(185, 'St. Pierre & Miquelon', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(186, 'St. Vincent & Grenadines', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(187, 'Sudan', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(188, 'Suriname', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(189, 'Swaziland', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(190, 'Sweden', 1, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(191, 'Switzerland', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(192, 'Syrian Arab Republic', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(193, 'Taiwan', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(194, 'Tajikistan', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(195, 'Tanzania', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(196, 'Thailand', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "countries` VALUES(197, 'Togo', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(198, 'Tonga', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(199, 'Trinidad & Tobago', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(200, 'Tunisia', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(201, 'Turkey', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(202, 'Turkmenistan', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(203, 'Turks & Caicos', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(204, 'Tuvalu', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(205, 'Uganda', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(206, 'Ukraine', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(207, 'United Arab Emirates', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(208, 'United Kingdom', 1, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(209, 'United States', 1, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(210, 'Uruguay', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(211, 'Uzbekistan', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(212, 'Vanuatu', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(213, 'Vatican City', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(214, 'Venezuela', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(215, 'Vietnam', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(216, 'Virgin Islands (Br.)', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(217, 'Virgin Islands (U.S.)', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(218, 'Wallis & Futuna', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(219, 'Yemen Republic', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(220, 'Zaire', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(221, 'Zambia', 0, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"countries` VALUES(222, 'Zimbabwe', 0, 10)";
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'countries` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//coupons
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "coupons'" ) !=
	PVS_DB_PREFIX . 'coupons' )
{

	$sql = 'CREATE TABLE `' . PVS_DB_PREFIX . 'coupons` (
	  `id_parent` int(11) NOT NULL auto_increment,
	  `title` varchar(200) default NULL,
	  `user` varchar(200) default NULL,
	  `data2` int(11) default NULL,
	  `total` float default NULL,
	  `percentage` float default NULL,
	  `url` varchar(200) default NULL,
	  `used` int(11) default NULL,
	  `orderid` int(11) default NULL,
	  `data` int(11) default NULL,
	  `ulimit` int(11) default NULL,
	  `tlimit` int(11) default NULL,
	  `coupon_id` int(11) default NULL,
	  `coupon_code` varchar(250) default NULL,
	  KEY `id_parent` (`id_parent`),
	  KEY `coupon_id` (`coupon_id`),
	  KEY `user` (`user`),
	  KEY `data2` (`data2`),
	  KEY `used` (`used`),
	  KEY `tlimit` (`tlimit`),
	  KEY `ulimit` (`ulimit`),
	  KEY `data` (`data`),
	  KEY `coupon_code` (`coupon_code`)
	)';
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'coupons` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//coupons_types
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "coupons_types'" ) !=
	PVS_DB_PREFIX . 'coupons_types' )
{

	$sql = 'CREATE TABLE `' . PVS_DB_PREFIX . 'coupons_types` (
	  `id_parent` int(11) NOT NULL auto_increment,
	  `title` varchar(200) default NULL,
	  `days` int(11) default NULL,
	  `total` float default NULL,
	  `percentage` float default NULL,
	  `url` varchar(200) default NULL,
	  `events` varchar(200) default NULL,
	  `ulimit` int(11) default NULL,
	  `bonus` float default NULL,
	  KEY `id_parent` (`id_parent`)
	)';
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"coupons_types` VALUES(1, 'Order discount', 30, 0, 10, '', 'New Order', 1, 0)";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"coupons_types` VALUES(2, 'Signup Bonus', 30, 0, 0, '', 'New Signup', 1, 1)";
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'coupons_types` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//credits
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "credits'" ) !=
	PVS_DB_PREFIX . 'credits' )
{

	$sql = 'CREATE TABLE `' . PVS_DB_PREFIX . 'credits` (
	  `id_parent` int(11) NOT NULL auto_increment,
	  `title` varchar(200) default NULL,
	  `quantity` int(11) default NULL,
	  `price` float default NULL,
	  `priority` int(11) default NULL,
	  `days` int(11) default NULL,
	  KEY `id_parent` (`id_parent`)
	)';
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"credits` VALUES(1, '1 Credits', 1, 1, 1, 0)";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"credits` VALUES(2, '10 Credits', 10, 9, 2, 0)";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"credits` VALUES(3, '20 Credits', 20, 17, 3, 0)";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"credits` VALUES(4, '50 Credits', 50, 43, 4, 0)";
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'credits` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//credits_list
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "credits_list'" ) !=
	PVS_DB_PREFIX . 'credits_list' )
{

	$sql = 'CREATE TABLE `' . PVS_DB_PREFIX . 'credits_list` (
	  `id_parent` int(11) NOT NULL auto_increment,
	  `title` varchar(200) default NULL,
	  `quantity` float default NULL,
	  `user` varchar(200) default NULL,
	  `data` int(11) default NULL,
	  `approved` int(11) default NULL,
	  `payment` int(11) default NULL,
	  `credits` int(11) default NULL,
	  `expiration_date` int(11) default NULL,
	  `subtotal` float default NULL,
	  `discount` float default NULL,
	  `taxes` float default NULL,
	  `total` float default NULL,
	  `billing_firstname` varchar(250) default NULL,
	  `billing_lastname` varchar(250) default NULL,
	  `billing_address` varchar(250) default NULL,
	  `billing_city` varchar(250) default NULL,
	  `billing_zip` varchar(250) default NULL,
	  `billing_country` varchar(250) default NULL,
	  `billing_state` varchar(250) default NULL,
	  `taxes_id` int(11) default NULL,
	  `billing_company` varchar(100) default NULL,
	  `billing_vat` varchar(40) default NULL,
	  `billing_business` tinyint(4) default NULL,
	  KEY `id_parent` (`id_parent`),
	  KEY `data` (`data`),
	  KEY `user` (`user`),
	  KEY `payment` (`payment`),
	  KEY `approved` (`approved`),
	  KEY `expiration_date` (`expiration_date`)
	)';
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'credits_list` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//currency
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "currency'" ) !=
	PVS_DB_PREFIX . 'currency' )
{

	$sql = 'CREATE TABLE `' . PVS_DB_PREFIX . 'currency` (
	  `id` int(11) NOT NULL auto_increment,
	  `name` varchar(250) default NULL,
	  `code1` varchar(10) default NULL,
	  `code2` varchar(10) default NULL,
	  `activ` int(11) default NULL,
	  PRIMARY KEY  (`id`)
	)';
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"currency` VALUES(1, 'Australian Dollars', 'AUD', 'A $', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"currency` VALUES(2, 'Canadian Dollars', 'CAD', 'C $', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"currency` VALUES(3, 'Euros', 'EUR', '&euro;', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"currency` VALUES(4, 'Pounds Sterling', 'GBP', '&pound;', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"currency` VALUES(5, 'Yen', 'JPY', '&yen;', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"currency` VALUES(6, 'U.S. Dollars', 'USD', '$', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"currency` VALUES(7, 'New Zealand Dollar', 'NZD', '$', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"currency` VALUES(8, 'Swiss Franc', 'CHF', NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"currency` VALUES(9, 'Hong Kong Dollar', 'HKD', '$', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"currency` VALUES(10, 'Singapore Dollar', 'SGD', '$', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"currency` VALUES(11, 'Swedish Krona', 'SEK', NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"currency` VALUES(12, 'Danish Krone', 'DKK', NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"currency` VALUES(13, 'Polish Zloty', 'PLN', NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"currency` VALUES(14, 'Norwegian Krone', 'NOK', NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"currency` VALUES(15, 'Hungarian Forint', 'HUF', NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"currency` VALUES(16, 'Czech Koruna', 'CZK', NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"currency` VALUES(17, 'UAE Dirham', 'AED', NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"currency` VALUES(18, 'Jordanian dinar', 'JOD', NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"currency` VALUES(19, 'Egyptian Pound', 'EGP', NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"currency` VALUES(20, 'Saudi Riyal', 'SAR', NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"currency` VALUES(21, 'Russian Ruble', 'RUB', NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"currency` VALUES(22, 'Ukraine Hryvnia', 'UAH', NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"currency` VALUES(23, 'Belarus Ruble', 'BYR', NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"currency` VALUES(24, 'Uzbekistan Sum', 'UZS', NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"currency` VALUES(25, 'Thai Baht', 'THB', NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"currency` VALUES(26, 'Israeli Shekel', 'ILS', NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"currency` VALUES(27, 'Mexican Peso', 'MXN', NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"currency` VALUES(29, 'Indian rupee', 'INR', NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"currency` VALUES(30, 'Bulgarian Lev', 'BGN', NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"currency` VALUES(32, 'Rial', 'IRR', NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"currency` VALUES(33, 'Leu', 'RON', NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"currency` VALUES(34, 'Manat', 'AZN', NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"currency` VALUES(35, 'Brazilian Real', 'BRL', NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"currency` VALUES(36, 'Korean Won', 'KRW', '&#8361;', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"currency` VALUES(38, 'Kazakhstan Tenge', 'KZT', '', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"currency` VALUES(40, 'Moldavian ley', 'MDL', '', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"currency` VALUES(41, 'Nigerian Naira', 'NGN', '', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"currency` VALUES(42, 'Sheqel', 'ILS', '', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"currency` VALUES(43, 'Turkish Lira', 'TRY', '', 0)";
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'currency` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//documents
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "documents'" ) !=
	PVS_DB_PREFIX . 'documents' )
{

	$sql = 'CREATE TABLE `' . PVS_DB_PREFIX . 'documents` (
	  `id` int(11) NOT NULL auto_increment,
	  `id_parent` int(11) default NULL,
	  `title` varchar(100) default NULL,
	  `filename` varchar(100) default NULL,
	  `status` int(11) default NULL,
	  `user_id` int(11) default NULL,
	  `data` int(11) default NULL,
	  `comment` varchar(250) default NULL,
	  PRIMARY KEY  (`id`),
	  KEY `id_parent` (`id_parent`),
	  KEY `status` (`status`),
	  KEY `data` (`data`),
	  KEY `user_id` (`user_id`)
	)';
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'documents` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//documents_types
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "documents_types'" ) !=
	PVS_DB_PREFIX . 'documents_types' )
{

	$sql = 'CREATE TABLE `' . PVS_DB_PREFIX . 'documents_types` (
	  `id` int(11) NOT NULL auto_increment,
	  `title` varchar(100) default NULL,
	  `description` varchar(250) default NULL,
	  `enabled` int(11) default NULL,
	  `buyer` tinyint(4) default NULL,
	  `seller` tinyint(4) default NULL,
	  `affiliate` tinyint(4) default NULL,
	  `filesize` int(11) default NULL,
	  `priority` int(11) default NULL,
	  PRIMARY KEY  (`id`),
	  KEY `enabled` (`enabled`),
	  KEY `buyer` (`buyer`),
	  KEY `seller` (`seller`),
	  KEY `affiliate` (`affiliate`),
	  KEY `priority` (`priority`)
	)';
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"documents_types` VALUES(1, 'Passport or Driving license', 'You should identify your person.', 1, 1, 1, 1, 5, 1)";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"documents_types` VALUES(2, 'Electric billing', 'You have to confirm your country (for EU only).', 1, 1, 1, 1, 5, 2)";
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'documents_types` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//downloads
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "downloads'" ) !=
	PVS_DB_PREFIX . 'downloads' )
{

	$sql = 'CREATE TABLE `' . PVS_DB_PREFIX . 'downloads` (
	  `id` int(11) NOT NULL auto_increment,
	  `id_parent` int(11) default NULL,
	  `link` varchar(250) default NULL,
	  `data` int(11) default NULL,
	  `tlimit` int(11) default NULL,
	  `ulimit` int(11) default NULL,
	  `order_id` int(11) default NULL,
	  `user_id` int(11) default NULL,
	  `subscription_id` int(11) default NULL,
	  `publication_id` int(11) default NULL,
	  collection_id int,
	  PRIMARY KEY  (`id`),
	  KEY `id_parent` (`id_parent`),
	  KEY `link` (`link`),
	  KEY `data` (`data`),
	  KEY `tlimit` (`tlimit`),
	  KEY `ulimit` (`ulimit`),
	  KEY `order_id` (`order_id`),
	  KEY `user_id` (`user_id`),
	  KEY `subscription_id` (`subscription_id`),
	  KEY `publication_id` (`publication_id`),
	  KEY `collection_id` (`collection_id`)
	)';
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'downloads` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//examinations
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "examinations'" ) !=
	PVS_DB_PREFIX . 'examinations' )
{

	$sql = 'CREATE TABLE `' . PVS_DB_PREFIX . 'examinations` (
	  `id` int(11) NOT NULL auto_increment,
	  `user` int(11) default NULL,
	  `data` int(11) default NULL,
	  `status` int(11) default NULL,
	  `comments` text,
	  PRIMARY KEY  (`id`),
	  KEY `id_parent` (`data`),
	  KEY `user` (`user`),
	  KEY `data` (`data`)
	)';
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'examinations` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//ffmpeg_cron
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "ffmpeg_cron'" ) !=
	PVS_DB_PREFIX . 'ffmpeg_cron' )
{

	$sql = 'CREATE TABLE `' . PVS_DB_PREFIX . 'ffmpeg_cron` (
	  `id` int(11) default NULL,
	  `data1` int(11) default NULL,
	  `data2` int(11) default NULL,
	  `generation` int(11) default NULL,
	  KEY `id` (`id`),
	  KEY `data1` (`data1`),
	  KEY `data2` (`data2`)
	)';
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'ffmpeg_cron` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//filestorage
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "filestorage'" ) !=
	PVS_DB_PREFIX . 'filestorage' )
{

	$sql = 'CREATE TABLE `' . PVS_DB_PREFIX . 'filestorage` (
	  `id` int(11) NOT NULL auto_increment,
	  `url` varchar(250) default NULL,
	  `activ` int(11) default NULL,
	  `types` int(11) default NULL,
	  `name` varchar(100) default NULL,
	  PRIMARY KEY  (`id`),
	  KEY `activ` (`activ`),
	  KEY `types` (`types`)
	)';
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"filestorage` VALUES(1, '/content', 0, 0, 'Local server')";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"filestorage` VALUES(2, '/content2', 1, 0, 'Local server')";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"filestorage` VALUES(4, NULL, 0, 1, 'Rackspace cloud')";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"filestorage` VALUES(5, NULL, 0, 2, 'Amazon S3')";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"filestorage` VALUES(6, NULL, 0, 2, 'Backblaze')";
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'filestorage` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//filestorage_files
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "filestorage_files'" ) !=
	PVS_DB_PREFIX . 'filestorage_files' )
{

	$sql = 'CREATE TABLE `' . PVS_DB_PREFIX . 'filestorage_files` (
	  `id_parent` int(11) default NULL,
	  `item_id` int(11) default NULL,
	  `url` varchar(250) default NULL,
	  `filename1` varchar(100) default NULL,
	  `filename2` varchar(100) default NULL,
	  `filesize` int(11) default NULL,
	  `server1` int(11) default NULL,
	  `pdelete` int(11) default NULL,
	  `width` int(11) default NULL,
	  `height` int(11) default NULL,
	  file_id varchar(200),
	  KEY `id_parent` (`id_parent`),
	  KEY `item_id` (`item_id`),
	  KEY `pdelete` (`pdelete`),
	  KEY `filename1` (`filename1`)
	)';
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'filestorage_files` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//filestorage_logs
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "filestorage_logs'" ) !=
	PVS_DB_PREFIX . 'filestorage_logs' )
{

	$sql = 'CREATE TABLE `' . PVS_DB_PREFIX . 'filestorage_logs` (
	  `publication_id` int(11) default NULL,
	  `logs` text,
	  `data` int(11) default NULL,
	  KEY `publication_id` (`publication_id`),
	  KEY `data` (`data`)
	)';
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'filestorage_logs` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//filestorage_logs
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "friends'" ) !=
	PVS_DB_PREFIX . 'friends' )
{

	$sql = 'CREATE TABLE `' . PVS_DB_PREFIX . 'friends` (
	  `id_parent` int(11) default NULL,
	  `friend1` varchar(200) default NULL,
	  `friend2` varchar(200) default NULL,
	  KEY `id_parent` (`id_parent`),
	  KEY `friend1` (`friend1`),
	  KEY `friend2` (`friend2`)
	)';
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'friends` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//galleries
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "galleries'" ) !=
	PVS_DB_PREFIX . 'galleries' )
{

	$sql = 'CREATE TABLE `' . PVS_DB_PREFIX . 'galleries` (
	  `id` int(11) NOT NULL auto_increment,
	  `user_id` int(11) default NULL,
	  `title` varchar(250) default NULL,
	  `data` int(11) default NULL,
	  PRIMARY KEY  (`id`),
	  KEY `user_id` (`user_id`),
	  KEY `data` (`data`)
	)';
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'galleries` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//galleries_photos
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "galleries_photos'" ) !=
	PVS_DB_PREFIX . 'galleries_photos' )
{

	$sql = 'CREATE TABLE `' . PVS_DB_PREFIX . 'galleries_photos` (
	  `id` int(11) NOT NULL auto_increment,
	  `id_parent` int(11) default NULL,
	  `title` varchar(250) default NULL,
	  `photo` varchar(250) default NULL,
	  `data` int(11) default NULL,
	  PRIMARY KEY  (`id`),
	  KEY `id_parent` (`id_parent`),
	  KEY `data` (`data`)
	)';
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'galleries_photos` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}


//gateway_clickbank
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "gateway_clickbank'" ) !=
	PVS_DB_PREFIX . 'gateway_clickbank' )
{

	$sql = 'CREATE TABLE `' . PVS_DB_PREFIX . 'gateway_clickbank` (
  `product_id` varchar(50) default NULL,
  `subscription` int(11) default NULL,
  `credits` int(11) default NULL
	)';
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'gateway_clickbank` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//gateway_epoch
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "gateway_epoch'" ) !=
	PVS_DB_PREFIX . 'gateway_epoch' )
{

	$sql = 'CREATE TABLE `' . PVS_DB_PREFIX . 'gateway_epoch` (
  `product_id` varchar(50) default NULL,
  `subscription` int(11) default NULL,
  `credits` int(11) default NULL
	)';
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'gateway_epoch` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//gateway_jvzoo
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "gateway_jvzoo'" ) !=
	PVS_DB_PREFIX . 'gateway_jvzoo' )
{

	$sql = 'CREATE TABLE `' . PVS_DB_PREFIX . 'gateway_jvzoo` (
  `product_id` varchar(50) default NULL,
  `subscription` int(11) default NULL,
  `credits` int(11) default NULL
	)';
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'gateway_jvzoo` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//gateway_segpay
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "gateway_segpay'" ) !=
	PVS_DB_PREFIX . 'gateway_segpay' )
{

	$sql = 'CREATE TABLE `' . PVS_DB_PREFIX . 'gateway_segpay` (
	`package_id` varchar(50) default NULL,
  `product_id` varchar(50) default NULL,
  `subscription` int(11) default NULL,
  `credits` int(11) default NULL
	)';
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'gateway_segpay` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}





//invoices
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "invoices'" ) !=
	PVS_DB_PREFIX . 'invoices' )
{

	$sql = 'CREATE TABLE `' . PVS_DB_PREFIX . 'invoices` (
	  `id` int(11) NOT NULL auto_increment,
	  `invoice_number` int(11) default NULL,
	  `order_id` int(11) default NULL,
	  `order_type` varchar(12) default NULL,
	  `status` tinyint(4) default NULL,
	  `comments` varchar(250) default NULL,
	  `refund` tinyint(4) default NULL,
	  PRIMARY KEY  (`id`),
	  KEY `invoice_number` (`invoice_number`),
	  KEY `order_id` (`order_id`),
	  KEY `order_type` (`order_type`)
	)';
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'invoices` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//items
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "items'" ) !=
	PVS_DB_PREFIX . 'items' )
{

	$sql = 'CREATE TABLE `' . PVS_DB_PREFIX . 'items` (
	  `id` int(11) NOT NULL auto_increment,
	  `id_parent` int(11) default NULL,
	  `name` varchar(100) NOT NULL,
	  `url` varchar(200) NOT NULL,
	  `price` float default NULL,
	  `priority` int(11) default NULL,
	  `shipped` tinyint(1) default NULL,
	  `price_id` int(10) unsigned NOT NULL,
	  `watermark` tinyint(1) default NULL,
	  PRIMARY KEY  (`id`),
	  KEY `id_parent` (`id_parent`),
	  KEY `priority` (`priority`),
	  KEY `price_id` (`price_id`)
	)';
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'items` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//languages
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "languages'" ) !=
	PVS_DB_PREFIX . 'languages' )
{

	$sql = 'CREATE TABLE `' . PVS_DB_PREFIX . 'languages` (
	  `name` varchar(250) default NULL,
	  `display` int(11) default NULL,
	  `activ` int(11) default NULL,
	  `metatags` varchar(100) default NULL
	)';
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"languages` VALUES('English', 1, 1, 'utf-8')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"languages` VALUES('French', 1, 0, 'utf-8')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"languages` VALUES('German', 1, 0, 'utf-8')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"languages` VALUES('Italian', 1, 0, 'utf-8')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"languages` VALUES('Portuguese', 1, 0, 'utf-8')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"languages` VALUES('Spanish', 1, 0, 'utf-8')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"languages` VALUES('Russian', 1, 0, 'utf-8')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"languages` VALUES('Swedish', 1, 0, 'utf-8')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"languages` VALUES('Chinese simplified', 1, 0, 'utf-8')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"languages` VALUES('Catalan', 1, 0, 'utf-8')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"languages` VALUES('Arabic', 1, 0, 'utf-8')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"languages` VALUES('Malaysian', 1, 0, 'utf-8')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"languages` VALUES('Bulgarian', 1, 0, 'utf-8')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"languages` VALUES('Polish', 1, 0, 'utf-8')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"languages` VALUES('Japanese', 1, 0, 'utf-8')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"languages` VALUES('Greek', 1, 0, 'utf-8')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"languages` VALUES('Dutch', 1, 0, 'utf-8')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"languages` VALUES('Norwegian', 1, 0, 'utf-8')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"languages` VALUES('Finnish', 1, 0, 'utf-8')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"languages` VALUES('Czech', 1, 0, 'utf-8')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"languages` VALUES('Estonian', 1, 0, 'utf-8')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"languages` VALUES('Serbian', 1, 0, 'utf-8')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"languages` VALUES('Hungarian', 1, 0, 'utf-8')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"languages` VALUES('Danish', 1, 0, 'utf-8')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"languages` VALUES('Romanian', 1, 0, 'utf-8')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"languages` VALUES('Hebrew', 1, 0, 'utf-8')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"languages` VALUES('Indonesian', 1, 0, 'utf-8')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"languages` VALUES('Chinese traditional', 1, 0, 'utf-8')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"languages` VALUES('Afrikaans formal', 1, 0, 'utf-8')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"languages` VALUES('Afrikaans informal', 1, 0, 'utf-8')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"languages` VALUES('Slovakian', 1, 0, 'utf-8')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"languages` VALUES('Persian', 1, 0, 'utf-8')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"languages` VALUES('Latvian', 1, 0, 'utf-8')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"languages` VALUES('Slovenian', 1, 0, 'utf-8')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"languages` VALUES('Lithuanian', 1, 0, 'utf-8')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"languages` VALUES('Turkish', 1, 0, 'utf-8')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"languages` VALUES('Thai', 1, 0, 'utf-8')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"languages` VALUES('Brazilian', 1, 0, 'utf-8')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"languages` VALUES('Ukrainian', 1, 0, 'utf-8')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"languages` VALUES('Georgian', 1, 0, 'utf-8')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"languages` VALUES('Croatian', 1, 0, 'utf-8')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"languages` VALUES('Icelandic', 1, 0, 'utf-8')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"languages` VALUES('Vietnamese', 1, 0, 'utf-8')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"languages` VALUES('Azerbaijan', 1, 0, 'utf-8')";
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'languages` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//licenses
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "licenses'" ) !=
	PVS_DB_PREFIX . 'licenses' )
{

	$sql = 'CREATE TABLE `' . PVS_DB_PREFIX . 'licenses` (
	  `id_parent` int(11) NOT NULL auto_increment,
	  `name` varchar(200) default NULL,
	  `description` text,
	  `priority` int(11) default NULL,
	  KEY `id_parent` (`id_parent`),
	  KEY `priority` (`priority`)
	)';
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"licenses` VALUES(4583, 'Standard', 'Description of Royalty Free license.', 1);";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"licenses` VALUES(4584, 'Extended', 'Description of Extended license.', 2);";
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'licenses` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//lightboxes
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "lightboxes'" ) !=
	PVS_DB_PREFIX . 'lightboxes' )
{

	$sql = 'CREATE TABLE `' . PVS_DB_PREFIX . 'lightboxes` (
	  `id` int(11) NOT NULL auto_increment,
	  `title` varchar(250) default NULL,
	  `description` text,
	  `catalog` tinyint(4) default NULL,
	  PRIMARY KEY  (`id`),
	  KEY `title` (`title`),
	  KEY `catalog` (`catalog`)
	)';
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'lightboxes` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//lightboxes_admin
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "lightboxes_admin'" ) !=
	PVS_DB_PREFIX . 'lightboxes_admin' )
{

	$sql = 'CREATE TABLE `' . PVS_DB_PREFIX . 'lightboxes_admin` (
	  `id_parent` int(11) default NULL,
	  `user` int(11) default NULL,
	  `user_owner` tinyint(4) default NULL,
	  KEY `id_parent` (`id_parent`),
	  KEY `user` (`user`),
	  KEY `user_owner` (`user_owner`)
	)';
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'lightboxes_admin` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//lightboxes_files
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "lightboxes_files'" ) !=
	PVS_DB_PREFIX . 'lightboxes_files' )
{

	$sql = 'CREATE TABLE `' . PVS_DB_PREFIX . 'lightboxes_files` (
	  `id_parent` int(11) default NULL,
	  `item` int(11) default NULL,
	  KEY `id_parent` (`id_parent`),
	  KEY `item` (`item`)
	)';
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'lightboxes_files` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}


//media
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "media'" ) !=
	PVS_DB_PREFIX . 'media' )
{

	  $sql = "CREATE TABLE `" . PVS_DB_PREFIX . "media` (
	  `id` int(11) NOT NULL auto_increment,
	  `media_id` int(1) unsigned NOT NULL,
	  `title` varchar(255) NOT NULL,
	  `data` int(11) unsigned NOT NULL,
	  `published` tinyint(1) NOT NULL,
	  `description` text NOT NULL,
	  `featured` tinyint(1) NOT NULL,
	  `keywords` text NOT NULL,
	  `author` varchar(50) NOT NULL,
	  `viewed` int(11) unsigned NOT NULL,
	  `userid` int(11) unsigned NOT NULL,
	  `watermark` tinyint(1) NOT NULL,
	  `content_type` varchar(50) NOT NULL,
	  `free` tinyint(1) NOT NULL,
	  `orientation` tinyint(1) NOT NULL,
	  `downloaded` int(11) unsigned NOT NULL,
	  `rating` float NOT NULL,
	  `server1` int(3) unsigned NOT NULL,
	  `server2` int(3) unsigned NOT NULL,
	  `server3` int(1) unsigned NOT NULL,
	  `examination` tinyint(1) NOT NULL,
	  `google_x` double NOT NULL,
	  `google_y` double NOT NULL,
	  `refuse_reason` varchar(250) NOT NULL,
	   `url` varchar(150) NOT NULL,
	  `editorial` tinyint(1) NOT NULL,
	  `adult` tinyint(4) NOT NULL,
	  `rights_managed` smallint(5) unsigned default NULL,
	  `vote_like` int(11) default NULL,
	  `vote_dislike` int(11) default NULL,
	  `contacts` tinyint(4) default NULL,
	  `exclusive` tinyint(4) default NULL,
	  `url_jpg` varchar(100) default NULL,
	  `url_png` varchar(100) default NULL,
	  `url_gif` varchar(100) default NULL,
	  `url_raw` varchar(100) default NULL,
	  `url_tiff` varchar(100) default NULL,
	  `url_eps` varchar(100) default NULL,
	  `holder` varchar(30) default NULL,
	  `source` varchar(20) default NULL,
	  `format` varchar(20) default NULL,
	  `duration` int(10) default NULL,
	  `ratio` varchar(20) default NULL,
	  `rendering` varchar(20) default NULL,
	  `frames` varchar(20) default NULL,
	  `usa` varchar(250) default NULL,
	  PRIMARY KEY  (`id`),
	  KEY `data` (`data`),
	  KEY `published` (`published`),
	  KEY `viewed` (`viewed`),
	  KEY `featured` (`featured`),
	  KEY `downloaded` (`downloaded`),
	  KEY `free` (`free`),
	  KEY `orientation` (`orientation`),
	  KEY `userid` (`userid`),
	  KEY `author` (`author`),
	  KEY `rating` (`rating`),
	  KEY `examination` (`examination`),
	  KEY `editorial` (`editorial`),
	  KEY `adult` (`adult`),
	  KEY `published_data` (`published`,`data`),
	  KEY `published_viewed` (`published`,`viewed`),
	  KEY `published_downloaded` (`published`,`downloaded`),
	  KEY `published_rating` (`published`,`rating`),
	  KEY `published_author` (`published`,`author`),
	  KEY `published_free` (`published`,`free`),
	  KEY `published_featured` (`published`,`featured`),
	  KEY `rights_managed` (`rights_managed`),
	  KEY `vote_like` (`vote_like`),
	  KEY `vote_dislike` (`vote_dislike`),
	  KEY `contacts` (`contacts`),
	  KEY `exclusive` (`exclusive`),
	  KEY `duration` (`duration`)
	)";
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'media` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//messages
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "messages'" ) !=
	PVS_DB_PREFIX . 'messages' )
{

	$sql = 'CREATE TABLE `' . PVS_DB_PREFIX . 'messages` (
	  `id_parent` int(11) NOT NULL auto_increment,
	  `touser` varchar(200) default NULL,
	  `fromuser` varchar(200) default NULL,
	  `subject` varchar(200) default NULL,
	  `content` text,
	  `data` int(11) default NULL,
	  `viewed` int(11) default NULL,
	  `trash` int(11) default NULL,
	  `del` int(11) default NULL,
	  KEY `id_parent` (`id_parent`),
	  KEY `touser` (`touser`),
	  KEY `fromuser` (`fromuser`),
	  KEY `data` (`data`)
	)';
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'messages` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//models
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "models'" ) !=
	PVS_DB_PREFIX . 'models' )
{

	$sql = 'CREATE TABLE `' . PVS_DB_PREFIX . 'models` (
	  `id_parent` int(11) NOT NULL auto_increment,
	  `name` varchar(200) default NULL,
	  `description` text,
	  `user` varchar(200) default NULL,
	  `model` varchar(200) default NULL,
	  `modelphoto` varchar(200) default NULL,
	  KEY `id_parent` (`id_parent`),
	  KEY `user` (`user`),
	  KEY `name` (`name`)
	)';
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'models` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//models_files
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "models_files'" ) !=
	PVS_DB_PREFIX . 'models_files' )
{

	$sql = 'CREATE TABLE `' . PVS_DB_PREFIX . 'models_files` (
	  `publication_id` int(11) default NULL,
	  `model_id` int(11) default NULL,
	  `models` tinyint(4) default NULL,
	  KEY `publication_id` (`publication_id`),
	  KEY `model_id` (`model_id`),
	  KEY `models` (`models`)
	)';
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'models_files` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//newsletter
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "newsletter'" ) !=
	PVS_DB_PREFIX . 'newsletter' )
{

	$sql = 'CREATE TABLE `' . PVS_DB_PREFIX . 'newsletter` (
	  `id` int(11) NOT NULL auto_increment,
	  `data` int(11) default NULL,
	  `touser` varchar(100) default NULL,
	  `types` varchar(50) default NULL,
	  `subject` varchar(250) default NULL,
	  `content` text,
	  `html` tinyint(4) default NULL,
	  PRIMARY KEY  (`id`)
	)';
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'newsletter` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//newsletter_emails
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "newsletter_emails'" ) !=
	PVS_DB_PREFIX . 'newsletter_emails' )
{

	$sql = 'CREATE TABLE `' . PVS_DB_PREFIX . 'newsletter_emails` (
	  `content` text
	)';
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"newsletter_emails` VALUES('test@test.com')";
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'newsletter_emails` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//notifications
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "notifications'" ) !=
	PVS_DB_PREFIX . 'notifications' )
{

	$sql = 'CREATE TABLE `' . PVS_DB_PREFIX . 'notifications` (
	  `events` varchar(30) default NULL,
	  `title` varchar(250) default NULL,
	  `message` text,
	  `enabled` int(11) default NULL,
	  `priority` int(11) default NULL,
	  `subject` varchar(250) default NULL,
	  `html` tinyint(4) default NULL,
	  message_html text,
	  KEY `priority` (`priority`),
	  KEY `events` (`events`)
	)';
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"notifications` VALUES('contacts_to_admin', 'Contact email to admin', '{lang.Name}: {NAME}\r\n{lang.E-mail}: {EMAIL}\r\n{lang.Telephone}: {TELEPHONE}\r\n{lang.Method}: {METHOD}\r\n{lang.Question}: {QUESTION}\r\n{lang.Date}: {DATE}', 1, 10, 'Contact Us on {SITE_NAME}', 1, '<p><strong>{lang.Name}:</strong> {NAME}<br /><strong>{lang.E-mail}:</strong> {EMAIL}<br /><strong>{lang.Telephone}:</strong> {TELEPHONE}<br /><strong>{lang.Method}:</strong> {METHOD}<br /><strong>{lang.Question}:</strong> {QUESTION}<br /><strong>{lang.Date}:</strong> {DATE}</p>')";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"notifications` VALUES('contacts_to_user', 'Contacts response to user', 'Thank you, {NAME}. Your message has been received. We will response stortly.\r\n\r\nBest regards,\r\n{SITE_NAME}', 1, 20, 'Re: Contact Us on {SITE_NAME}', 1, '<p>Thank you, {NAME}. Your message has been received. We will response stortly.<br /><br />Best regards,<br />{SITE_NAME}</p>')";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"notifications` VALUES('neworder_to_user', 'New order email to user', 'Hello {NAME},\r\n\r\nThanks for buying on {SITE_NAME}! We will _char_ge and ship your order soon. \r\n\r\n{lang.Order} #{ORDER}\r\n{lang.Date}: {DATE}\r\n\r\n{ITEM_LIST}\r\n\r\n{lang.Subtotal}: {SUBTOTAL}\r\n{lang.Discount}: {DISCOUNT}\r\n{lang.Shipping}: {SHIPPING}\r\n{lang.Taxes}: {TAXES}\r\n{lang.Total}: {TOTAL}\r\n\r\n\r\n{lang.Billing address}\r\n{BILLING_FIRSTNAME} {BILLING_LASTNAME}\r\n{BILLING_ADDRESS}\r\n{BILLING_CITY} {BILLING_ZIP}, {BILLING_COUNTRY}\r\n\r\n\r\n{lang.Shipping address}\r\n{SHIPPING_FIRSTNAME} {SHIPPING_LASTNAME}\r\n{SHIPPING_ADDRESS}\r\n{SHIPPING_CITY} {SHIPPING_ZIP}, {SHIPPING_COUNTRY}\r\n\r\nThank you,\r\n{SITE_NAME}', 1, 40, 'Order #{ORDER_ID} on {SITE_NAME}', 1, '<p>Hello {NAME},<br /><br />Thanks for buying on {SITE_NAME}! <br /><br /><strong>{lang.Order}</strong> # {ORDER}<br /><strong>{lang.Date}</strong>: {DATE}<br><strong>{lang.Subtotal}</strong>: {SUBTOTAL}<br /><strong>{lang.Discount}</strong>: {DISCOUNT}<br /><strong>{lang.Shipping}</strong>: {SHIPPING}<br /><strong>{lang.Taxes}</strong>: {TAXES}<br /><strong>{lang.Total}</strong>: {TOTAL}<br /><br />{ITEM_LIST}<br /><br /><strong>{lang.Billing address}</strong><br />{BILLING_FIRSTNAME} {BILLING_LASTNAME}<br />{BILLING_ADDRESS}<br />{BILLING_CITY} {BILLING_ZIP}, {BILLING_COUNTRY}<br /><br /><strong>{lang.Shipping address}</strong><br />{SHIPPING_FIRSTNAME} {SHIPPING_LASTNAME}<br />{SHIPPING_ADDRESS}<br />{SHIPPING_CITY} {SHIPPING_ZIP}, {SHIPPING_COUNTRY}<br /><br />Thank you,<br />{SITE_NAME}</p>')";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"notifications` VALUES('neworder_to_admin', 'New order email to admin', '{lang.Order} #{ORDER}\r\n{lang.date}: {DATE}\r\n\r\n{ITEM_LIST}\r\n\r\n{lang.Subtotal}: {SUBTOTAL}\r\n{lang.Discount}: {DISCOUNT}\r\n{lang.Shipping}: {SHIPPING}\r\n{lang.Taxes}: {TAXES}\r\n{lang.Total}: {TOTAL}\r\n\r\n{lang.Customer ID}: {CUSTOMERID}\r\n{lang.Login}: {LOGIN}\r\n{lang.Name}: {NAME}\r\n{lang.E-mail}: {EMAIL}\r\n{lang.Telephone}: {TELEPHONE}\r\n\r\n\r\n{lang.Billing address}\r\n{BILLING_FIRSTNAME} {BILLING_LASTNAME}\r\n{BILLING_ADDRESS}\r\n{BILLING_CITY} {BILLING_ZIP}, {BILLING_COUNTRY}\r\n\r\n\r\n{lang.Shiping address}\r\n{SHIPPING_FIRSTNAME} {SHIPPING_LASTNAME}\r\n{SHIPPING_ADDRESS}\r\n{SHIPPING_CITY} {SHIPPING_ZIP}, {SHIPPING_COUNTRY}', 1, 50, 'Order #{ORDER_ID} on {SITE_NAME}', 1, '<p><strong>{lang.Order}</strong> # {ORDER}<br /><strong>{lang.date}</strong>: {DATE}<br /><br />{ITEM_LIST}<br /><br /><strong>{lang.Subtotal}</strong>: {SUBTOTAL}<br /><strong>{lang.Discount}</strong>: {DISCOUNT}<br /><strong>{lang.Shipping}</strong>: {SHIPPING}<br /><strong>{lang.Taxes}</strong>: {TAXES}<br /><strong>{lang.Total}</strong>: {TOTAL}<br /><br /><strong>{lang.Customer ID}</strong>: {CUSTOMERID}<br /><strong>{lang.Login}</strong>: {LOGIN}<br /><strong>{lang.Name}</strong>: {NAME}<br /><strong>{lang.E-mail}</strong>: {EMAIL}<br /><strong>{lang.Telephone}</strong>: {TELEPHONE}<br /><br /><strong>{lang.Billing address}</strong><br />{BILLING_FIRSTNAME} {BILLING_LASTNAME}<br />{BILLING_ADDRESS}<br />{BILLING_CITY} {BILLING_ZIP}, {BILLING_COUNTRY}<br /><br /><strong>{lang.Shiping address}</strong><br />{SHIPPING_FIRSTNAME} {SHIPPING_LASTNAME}<br />{SHIPPING_ADDRESS}<br />{SHIPPING_CITY} {SHIPPING_ZIP}, {SHIPPING_COUNTRY}</p>')";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"notifications` VALUES('signup_to_admin', 'New signup email to admin', 'There is a new registration on {SITE_NAME}:\r\n\r\n{lang.Login}: {LOGIN}\r\n{lang.Name}: {NAME}\r\n{lang.E-mail}: {EMAIL}\r\n{lang.Telephone}: {TELEPHONE}\r\n{lang.Address}: {ADDRESS}\r\n{lang.City}: {CITY}\r\n{lang.Country}: {COUNTRY}\r\n{lang.Date}: {DATE}', 1, 60, 'Registration on  {SITE_NAME}', 1, '<p>There is a new registration on {SITE_NAME}:<br /><br /><strong>{lang.Login}:</strong> {LOGIN}<br /><strong>{lang.Name}:</strong> {NAME}<br /><strong>{lang.E-mail}:</strong> {EMAIL}<br /><strong>{lang.Telephone}:</strong> {TELEPHONE}<br /><strong>{lang.Address}:</strong> {ADDRESS}<br /><strong>{lang.City}:</strong> {CITY}<br /><strong>{lang.Country}:</strong> {COUNTRY}<br /><strong>{lang.Date}:</strong> {DATE}</p>')";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"notifications` VALUES('signup_to_user', 'New signup email to user', 'Hi {NAME},\r\n\r\nThank you for your registration on {SITE_NAME}\r\nPlease, click next link: {CONFIRMATION_LINK} to confirm your registration.\r\n\r\nThank you,\r\n{SITE_NAME}', 1, 70, 'Registration on  {SITE_NAME}', 1, '<p>Hi {NAME},<br /><br />Thank you for your registration on {SITE_NAME}!</p>')";
	$wpdb->query( $sql );
	

	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"notifications` VALUES('tell_a_friend', 'Tell a friend email', 'Hello {NAME2},\r\n\r\nYour friend, {NAME} at {EMAIL}, recommended this link: {URL}\r\n\r\nThank you,\r\n{SITE_NAME}', 1, 90, 'Tell a friend about {SITE_NAME}', 1, '<p>Hello {NAME2},<br /><br />Your friend, <strong>{NAME}</strong> at <strong>{EMAIL}</strong>, recommended this link: {URL}<br /><br />Thank you,<br />{SITE_NAME}</p>')";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"notifications` VALUES('subscription_to_admin', 'New subscription email to admin', '{SUBSCRIPTION_DETAILS}\r\n{lang.Date}: {DATE}\r\n\r\n{lang.Login}: {LOGIN}\r\n{lang.Name}: {NAME}\r\n{lang.E-mail}: {EMAIL}\r\n{lang.Telephone}: {TELEPHONE}\r\n{lang.Address}: {ADDRESS}\r\n{lang.Country}: {COUNTRY}', 1, 53, 'Subscription order {SUBSCRIPTION} on {SITE_NAME}', 1, '<p><strong>{SUBSCRIPTION_DETAILS}</strong><br /><strong>{lang.Date}:</strong> {DATE}<br /><br /><strong>{lang.Login}:</strong> {LOGIN}<br /><strong>{lang.Name}:</strong> {NAME}<br /><strong>{lang.E-mail}:</strong> {EMAIL}<br /><strong>{lang.Telephone}:</strong> {TELEPHONE}<br /><strong>{lang.Address}:</strong> {ADDRESS}<br /><strong>{lang.Country}:</strong> {COUNTRY}</p>')";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"notifications` VALUES('subscription_to_user', 'New subscription email to user', 'Hello {NAME},\r\n\r\nThanks for buying a subscription on {SITE_NAME}! \r\n\r\n{SUBSCRIPTION_DETAILS}\r\n{lang.DATE}: {DATE}\r\n\r\nThank you,\r\n{SITE_NAME}', 1, 52, 'Subscription order {SUBSCRIPTION} on {SITE_NAME}', 1, '<p>Hello {NAME},<br /><br />Thanks for buying a subscription on {SITE_NAME}! <br /><br /><strong>{SUBSCRIPTION_DETAILS}</strong><br /><strong>{lang.DATE}:</strong> {DATE}<br /><br />Thank you,<br />{SITE_NAME}</p>')";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"notifications` VALUES('credits_to_admin', 'New credits email to admin', '{CREDITS_DETAILS}\r\n{lang.Date}: {DATE}\r\n\r\n{lang.Login}: {LOGIN}\r\n{lang.Name}: {NAME}\r\n{lang.E-mail}: {EMAIL}\r\n{lang.Telephone}: {TELEPHONE}\r\n{lang.Address}: {ADDRESS}\r\n{lang.Country}: {COUNTRY}', 1, 55, 'Credits order {CREDITS} on {SITE_NAME}', 1, '<p><strong>{CREDITS_DETAILS}</strong><br /><strong>{lang.Date}:</strong> {DATE}<br /><br /><strong>{lang.Login}:</strong> {LOGIN}<br /><strong>{lang.Name}:</strong> {NAME}<br /><strong>{lang.E-mail}:</strong> {EMAIL}<br /><strong>{lang.Telephone}:</strong> {TELEPHONE}<br /><strong>{lang.Address}:</strong> {ADDRESS}<br /><strong>{lang.Country}:</strong> {COUNTRY}</p>')";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"notifications` VALUES('credits_to_user', 'New credits email to user', 'Hello {NAME},\r\n\r\nThanks for buying a credits on {SITE_NAME}! \r\n\r\n{CREDITS_DETAILS}\r\n{lang.Date}: {DATE}\r\n\r\nThank you,\r\n{SITE_NAME}', 1, 54, 'Credits order {CREDITS} on {SITE_NAME}', 1, '<p>Hello {NAME},<br /><br />Thanks for buying a credits on {SITE_NAME}! <br /><br /><strong>{CREDITS_DETAILS}</strong><br /><strong>{lang.Date}:</strong> {DATE}<br /><br />Thank you,<br />{SITE_NAME}</p>')";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"notifications` VALUES('signup_guest', 'New signup email to guest', 'Hi,\r\n\r\nThank you for your registration on {SITE_NAME}\r\nYour login: {LOGIN}\r\nPassword: {PASSWORD}\r\n\r\nThank you,\r\n{SITE_NAME}', 1, 75, 'Registration on  {SITE_NAME}', 1, '<p>Hi,<br /><br />Thank you for your registration on {SITE_NAME}.<br />Your login: <strong>{LOGIN}</strong><br />Password: <strong>{PASSWORD}</strong><br /><br />Thank you,<br />{SITE_NAME}</p>')";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"notifications` VALUES('commission_to_seller', 'New commission to seller', 'Hello {NAME},\r\n\r\nThere is a new sale at {SITE_NAME}.\r\n\r\n{lang.File}: {FILE}\r\n{lang.Order}: {ORDER_ID}\r\n{lang.Earning}: {EARNING}\r\n\r\nThank you,\r\n{SITE_NAME}', 1, 95, 'New sale on  {SITE_NAME}', 1, '<p>Hello {NAME},<br /><br />There is a new sale at {SITE_NAME}.<br /><br /><strong>{lang.File}:</strong> {FILE}<br /><strong>{lang.Order}:</strong> {ORDER_ID}<br /><strong>{lang.Earning}:</strong> {EARNING}<br /><br />Thank you,<br />{SITE_NAME}</p>')";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"notifications` VALUES('commission_to_affiliate', 'New commission to affiliate', 'Hello {NAME},\r\n\r\nThere is a new sale at {SITE_NAME}.\r\n{lang.Order}: {ORDER_ID}\r\n{lang.Earning}: {EARNING}\r\n\r\nThank you,\r\n{SITE_NAME}', 1, 105, 'New sale on  {SITE_NAME}', 1, '<p>Hello {NAME},<br /><br />There is a new sale at {SITE_NAME}.<br /><strong>{lang.Order}:</strong> {ORDER_ID}<br /><strong>{lang.Earning}:</strong> {EARNING}<br /><br />Thank you,<br />{SITE_NAME}</p>')";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"notifications` VALUES('exam_to_admin', 'New examination to admin', 'The user took an examination.\r\n\r\nLogin: {LOGIN}\r\nDate: {DATE}\r\nID: {ID}', 1, 110, 'New examination on {SITE_NAME}', 1, '<p>The user took an examination.<br /><br /><strong>Login:</strong> {LOGIN}<br /><strong>Date:</strong> {DATE}<br /><strong>ID:</strong> {ID}</p>')";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"notifications` VALUES('exam_to_seller', 'New examination to seller', 'Hello {NAME},\r\n\r\nThank you for taking an examination at {SITE_NAME}!\r\n\r\nResult: {RESULT}\r\nDate: {DATE}\r\nComments: {COMMENTS}\r\n\r\nBest regards,\r\n{SITE_NAME}', 1, 115, 'The examination on {SITE_NAME}', 1, '<p>Hello {NAME},<br /><br />Thank you for taking an examination at {SITE_NAME}!<br /><br /><strong>Result:</strong> {RESULT}<br /><strong>Date:</strong> {DATE}<br /><strong>Comments:</strong> {COMMENTS}<br /><br />Best regards,<br />{SITE_NAME}</p>')";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"notifications` VALUES('support_to_user', 'Support to user', 'Hello {NAME},\r\n\r\n{MESSAGE}\r\n\r\nBest regards,\r\n{SITE_NAME}', 1, 120, 'SUPPORT (ID${ID}) - Subject: {Subject}', 1, '<p>Hello {NAME},<br /><br />{MESSAGE}</p><p>{URL}<br /><br />Best regards,<br />{SITE_NAME}</p>')";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"notifications` VALUES('support_to_admin', 'Support to admin', '{MESSAGE}\r\n{URL}', 1, 125, 'SUPPORT (ID#{ID}) - Subject: {Subject}', 1, '<p>{MESSAGE}</p><p><br />{URL}</p>')";
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'notifications` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//orders
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "orders'" ) !=
	PVS_DB_PREFIX . 'orders' )
{

	$sql = 'CREATE TABLE `' . PVS_DB_PREFIX . 'orders` (
	  `id` int(11) NOT NULL auto_increment,
	  `user` int(11) default NULL,
	  `total` float default NULL,
	  `status` int(11) default NULL,
	  `payment` int(11) default NULL,
	  `data` int(11) default NULL,
	  `subtotal` float default NULL,
	  `discount` float default NULL,
	  `shipping` float default NULL,
	  `tax` float default NULL,
	  `shipping_firstname` varchar(100) default NULL,
	  `shipping_lastname` varchar(100) default NULL,
	  `shipping_address` varchar(200) default NULL,
	  `shipping_country` varchar(100) default NULL,
	  `shipping_city` varchar(100) default NULL,
	  `shipping_zip` varchar(100) default NULL,
	  `shipped` int(11) default NULL,
	  `billing_firstname` varchar(100) default NULL,
	  `billing_lastname` varchar(100) default NULL,
	  `billing_address` varchar(200) default NULL,
	  `billing_country` varchar(100) default NULL,
	  `billing_city` varchar(100) default NULL,
	  `billing_zip` varchar(100) default NULL,
	  `shipping_method` int(11) default NULL,
	  `shipping_state` varchar(250) default NULL,
	  `billing_state` varchar(250) default NULL,
	  `weight` float default NULL,
	  `comments` text,
	  `credits` tinyint(4) default NULL,
	  `billing_company` varchar(100) default NULL,
	  `billing_vat` varchar(40) default NULL,
	  `billing_business` tinyint(4) default NULL,
	  PRIMARY KEY  (`id`),
	  KEY `user` (`user`)
	)';
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'orders` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//orders_content
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "orders_content'" ) !=
	PVS_DB_PREFIX . 'orders_content' )
{

	$sql = 'CREATE TABLE `' . PVS_DB_PREFIX . 'orders_content` (
	  `id` int(11) NOT NULL auto_increment,
	  `id_parent` int(11) default NULL,
	  `price` float default NULL,
	  `item` int(11) default NULL,
	  `quantity` int(11) default NULL,
	  `prints` int(11) default NULL,
	  `option1_id` int(11) default NULL,
	  `option1_value` varchar(200) default NULL,
	  `option2_id` int(11) default NULL,
	  `option2_value` varchar(200) default NULL,
	  `option3_id` int(11) default NULL,
	  `option3_value` varchar(200) default NULL,
	  `rights_managed` varchar(250) default NULL,
	  `printslab` tinyint(4) default NULL,
	  `printslab_id` int(11) default NULL,
	  `option4_id` int(11) default NULL,
	  `option5_id` int(11) default NULL,
	  `option6_id` int(11) default NULL,
	  `option7_id` int(11) default NULL,
	  `option8_id` int(11) default NULL,
	  `option9_id` int(11) default NULL,
	  `option10_id` int(11) default NULL,
	  `option4_value` varchar(250) default NULL,
	  `option5_value` varchar(250) default NULL,
	  `option6_value` varchar(250) default NULL,
	  `option7_value` varchar(250) default NULL,
	  `option8_value` varchar(250) default NULL,
	  `option9_value` varchar(250) default NULL,
	  `option10_value` varchar(250) default NULL,
	  `taxes` float default NULL,
	  `taxes_id` int(11) default NULL,
	  `stock` tinyint(4) default NULL,
	  `stock_type` varchar(50) default NULL,
	  `stock_id` int(11) default NULL,
	  `stock_url` text,
	  `stock_preview` text,
	  `stock_site_url` text,
	  `x1` int(11) default NULL,
	  `y1` int(11) default NULL,
	  `x2` int(11) default NULL,
	  `y2` int(11) default NULL,
	  `print_width` int(11) default NULL,
	  `print_height` int(11) default NULL,
	  collection tinyint,
	  PRIMARY KEY  (`id`),
	  KEY `id_parent` (`id_parent`),
	  KEY `id_parent_2` (`id_parent`),
	  KEY `prints` (`prints`)
	)';
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'orders_content` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//payments
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "payments'" ) !=
	PVS_DB_PREFIX . 'payments' )
{

	$sql = 'CREATE TABLE `' . PVS_DB_PREFIX . 'payments` (
	  `id_parent` int(11) NOT NULL auto_increment,
	  `user` varchar(200) default NULL,
	  `data` int(11) default NULL,
	  `total` float default NULL,
	  `ip` varchar(200) default NULL,
	  `tnumber` varchar(200) default NULL,
	  `ptype` varchar(200) default NULL,
	  `pid` int(11) default NULL,
	  `processor` varchar(200) default NULL,
	  KEY `id_parent` (`id_parent`),
	  KEY `user` (`user`),
	  KEY `data` (`data`),
	  KEY `pid` (`pid`)
	)';
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'payments` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}





//payout
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "payout'" ) !=
	PVS_DB_PREFIX . 'payout' )
{

	$sql = 'CREATE TABLE `' . PVS_DB_PREFIX . 'payout` (
	`id` int(11) NOT NULL auto_increment,
	  `title` varchar(50) default NULL,
	  `activ` int(11) default NULL,
	  `svalue` varchar(50) default NULL,
	  PRIMARY KEY  (`id`)
	)';
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"payout` VALUES(1, 'Paypal account', 1, 'paypal')";
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'payout` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}



//photos_exif
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "photos_exif'" ) !=
	PVS_DB_PREFIX . 'photos_exif' )
{

	$sql = "CREATE TABLE `" . PVS_DB_PREFIX . "photos_exif` (
	  `id` int(11) NOT NULL auto_increment,
	  `photo_id` int(11) default NULL,
	  `FileName` varchar(100) default NULL,
	  `DateTime` varchar(50) default NULL,
	  `FileSize` int(11) default NULL,
	  `Width` int(11) default NULL,
	  `Height` int(11) default NULL,
	  `IsColor` tinyint(4) default NULL,
	  `UserComment` varchar(255) default NULL,
	  `Copyright` varchar(255) default NULL,
	  `Copyright_Photographer` varchar(255) default NULL,
	  `Copyright_Editor` varchar(255) default NULL,
	  `Orientation` int(11) default NULL,
	  `XResolution` varchar(50) default NULL,
	  `YResolution` varchar(50) default NULL,
	  `Software` varchar(50) default NULL,
	  `Make` varchar(50) default NULL,
	  `Model` varchar(50) default NULL,
	  `Artist` varchar(50) default NULL,
	  `ExposureTime` varchar(50) default NULL,
	  `FNumber` varchar(50) default NULL,
	  `ISOSpeedRatings` varchar(50) default NULL,
	  `ShutterSpeedValue` varchar(50) default NULL,
	  `ApertureValue` varchar(50) default NULL,
	  `ExposureBiasValue` varchar(50) default NULL,
	  `MeteringMode` varchar(50) default NULL,
	  `Flash` varchar(50) default NULL,
	  `FocalLength` varchar(50) default NULL,
	  `GPSLongitude` varchar(50) default NULL,
	  `GPSLongitudeRef` varchar(50) default NULL,
	  `GPSLatitude` varchar(50) default NULL,
	  `GPSLatitudeRef` varchar(50) default NULL,
	  PRIMARY KEY  (`id`),
	  KEY `photo_id` (`photo_id`)
	)";
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'photos_exif` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//photos_formats
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "photos_formats'" ) !=
	PVS_DB_PREFIX . 'photos_formats' )
{

	$sql = "CREATE TABLE `" . PVS_DB_PREFIX . "photos_formats` (
	  `id` int(11) NOT NULL auto_increment,
	  `photo_type` varchar(20) default NULL,
	  `title` varchar(20) default NULL,
	  `enabled` tinyint(4) default NULL,
	  PRIMARY KEY  (`id`)
	)";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"photos_formats` VALUES(1, 'jpg', '*.jpg,*.jpeg', 1)";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"photos_formats` VALUES(2, 'png', '*.png', 1)";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"photos_formats` VALUES(3, 'gif', '*.gif', 1)";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"photos_formats` VALUES(4, 'raw', '*.raw', 1)";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"photos_formats` VALUES(5, 'tiff', '*.tif,*.tiff', 1)";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"photos_formats` VALUES(6, 'eps', '*.eps', 1)";
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'photos_formats` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//printful_orders
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "printful_orders'" ) !=
	PVS_DB_PREFIX . 'printful_orders' )
{

	$sql = "CREATE TABLE `" . PVS_DB_PREFIX . "printful_orders` (
	  `order_id` int(11) default NULL,
	  `printful_id` varchar(100) default NULL,
	  `data` int(11) default NULL,
	  KEY `order_id` (`order_id`)
	)";
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'printful_orders` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//printful_prints
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "printful_prints'" ) !=
	PVS_DB_PREFIX . 'printful_prints' )
{

	$sql = "CREATE TABLE `" . PVS_DB_PREFIX . "printful_prints` (
	  `id` int(11) NOT NULL auto_increment,
	  `print_id` int(11) default NULL,
	  `printful_id` int(11) default NULL,
	  `option1` int(11) default NULL,
	  `option2` int(11) default NULL,
	  `option3` int(11) default NULL,
	  `option4` int(11) default NULL,
	  `option5` int(11) default NULL,
	  `option6` int(11) default NULL,
	  `option7` int(11) default NULL,
	  `option8` int(11) default NULL,
	  `option9` int(11) default NULL,
	  `option10` int(11) default NULL,
	  `option1_value` varchar(100) default NULL,
	  `option2_value` varchar(100) default NULL,
	  `option3_value` varchar(100) default NULL,
	  `option4_value` varchar(100) default NULL,
	  `option5_value` varchar(100) default NULL,
	  `option6_value` varchar(100) default NULL,
	  `option7_value` varchar(100) default NULL,
	  `option8_value` varchar(100) default NULL,
	  `option9_value` varchar(100) default NULL,
	  `option10_value` varchar(100) default NULL,
	  PRIMARY KEY  (`id`),
	  KEY `print_id` (`print_id`),
	  KEY `option1` (`option1`),
	  KEY `option2` (`option2`),
	  KEY `option3` (`option3`),
	  KEY `option4` (`option4`),
	  KEY `option5` (`option5`),
	  KEY `option6` (`option6`),
	  KEY `option7` (`option7`),
	  KEY `option8` (`option8`),
	  KEY `option9` (`option9`),
	  KEY `option10` (`option10`)
	)";
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'printful_prints` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//prints
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "prints'" ) !=
	PVS_DB_PREFIX . 'prints' )
{

	$sql = "CREATE TABLE `" . PVS_DB_PREFIX . "prints` (
	  `id_parent` int(11) NOT NULL auto_increment,
	  `title` varchar(200) default NULL,
	  `description` text,
	  `price` float default NULL,
	  `priority` int(11) default NULL,
	  `weight` float default NULL,
	  `option1` int(11) default NULL,
	  `option2` int(11) default NULL,
	  `option3` int(11) default NULL,
	  `photo` tinyint(4) default NULL,
	  `printslab` tinyint(4) default NULL,
	  `option4` int(11) default NULL,
	  `option5` int(11) default NULL,
	  `option6` int(11) default NULL,
	  `option7` int(11) default NULL,
	  `option8` int(11) default NULL,
	  `option9` int(11) default NULL,
	  `option10` int(11) default NULL,
	  `category` int(11) default NULL,
	  `preview` int(11) default NULL,
	  `resize` tinyint(4) default NULL,
	  `option1_value` varchar(250) default NULL,
	  `option2_value` varchar(250) default NULL,
	  `option3_value` varchar(250) default NULL,
	  `option4_value` varchar(250) default NULL,
	  `option5_value` varchar(250) default NULL,
	  `option6_value` varchar(250) default NULL,
	  `option7_value` varchar(250) default NULL,
	  `option8_value` varchar(250) default NULL,
	  `option9_value` varchar(250) default NULL,
	  `option10_value` varchar(250) default NULL,
	  `resize_min` int(11) default NULL,
	  `resize_value` int(11) default NULL,
	  `resize_max` int(11) default NULL,
	  `in_stock` int(11) default NULL,
	  KEY `id_parent` (`id_parent`),
	  KEY `priority` (`priority`),
	  KEY `photo` (`photo`),
	  KEY `printslab` (`printslab`),
	  KEY `category` (`category`),
	  KEY `preview` (`preview`),
	  KEY `in_stock` (`in_stock`)
	)";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"prints` VALUES(4139, 'Metal Prints', '', 10, 4, 1, 19, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 5, 1, '', '', '', '', '', '', '', '', '', '', 540, 540, 800, -1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"prints` VALUES(4138, 'Prints and Posters', '', 1, 3, 0.001, 19, 11, 16, 1, 1, 17, 18, 1, 0, 0, 0, 0, 1, 4, 1, '16cm', '0cm', '_resh_FFFFFF', '0cm', '_resh_FFFFFF', '', '', '', '', '', 540, 540, 800, -1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"prints` VALUES(4142, 'Greeting Cards', '', 3, 1, 0.001, 20, 13, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 6, 8, 1, '', '', '', '', '', '', '', '', '', '', 540, 540, 800, -1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"prints` VALUES(4137, 'Canvas Prints', '', 10, 1, 1, 8, 9, 10, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, '25cm', 'Glossy Finish Canvas', 'Mirrored Sides', '', '', '', '', '', '', '', 540, 540, 800, -1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"prints` VALUES(4140, 'Framed Prints', '', 10, 2, 1, 8, 6, 11, 1, 1, 16, 17, 18, 1, 0, 0, 0, 1, 6, 1, '', '', '', '', '', '', '', '', '', '', 540, 540, 800, -1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"prints` VALUES(4141, 'Acrylic Prints', '', 10, 5, 1, 8, 12, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 7, 1, '', 'Aluminum Mounting Posts', '', '', '', '', '', '', '', '', 540, 540, 800, -1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"prints` VALUES(4143, 'iPhone Cases', '', 30, 1, 0.1, 23, 24, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 2, 9, 1, 'iPhone 7', 'Vertical', '', '', '', '', '', '', '', '', 540, 700, 1000, -1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"prints` VALUES(4144, 'Galaxy Cases', '', 30, 2, 0.1, 25, 24, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 2, 10, 1, '', 'Vertical', '', '', '', '', '', '', '', '', 540, 700, 1000, -1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"prints` VALUES(4145, 'Pillows', '', 10, 1, 0.1, 26, 27, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 4, 12, 1, '35cm x 35cm', 'Yes', '', '', '', '', '', '', '', '', 540, 540, 800, -1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"prints` VALUES(4146, 'Tote Bags', '', 20, 1, 0.1, 28, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 7, 13, 1, '32cm x 32cm', '', '', '', '', '', '', '', '', '', 540, 540, 800, -1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"prints` VALUES(4147, 'Duvet Covers', '', 100, 2, 1, 29, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 4, 14, 1, 'King', '', '', '', '', '', '', '', '', '', 540, 800, 1000, -1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"prints` VALUES(4148, 'Shower Curtain', '', 50, 3, 0.1, 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 4, 15, 1, '', '', '', '', '', '', '', '', '', '', 540, 800, 1000, -1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"prints` VALUES(4149, 'T-Shirts', '', 20, 1, 0.1, 2, 30, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 5, 16, 0, '', '', '', '', '', '', '', '', '', '', 170, 170, 300, -1)";
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'prints` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//prints_categories
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "prints_categories'" ) !=
	PVS_DB_PREFIX . 'prints_categories' )
{

	$sql = "CREATE TABLE `" . PVS_DB_PREFIX . "prints_categories` (
	  `id` int(11) NOT NULL auto_increment,
	  `title` varchar(250) default NULL,
	  `priority` int(11) default NULL,
	  `active` tinyint(4) default NULL,
	  PRIMARY KEY  (`id`),
	  KEY `priority` (`priority`),
	  KEY `active` (`active`)
	)";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"prints_categories` VALUES(1, 'Wall Art', 1, 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"prints_categories` VALUES(2, 'Phone Cases', 2, 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"prints_categories` VALUES(4, 'Home Decor', 3, 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"prints_categories` VALUES(5, 'Clothes', 4, 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"prints_categories` VALUES(6, 'Souvenirs', 5, 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"prints_categories` VALUES(7, 'Bags', 6, 1)";
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'prints_categories` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//prints_items
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "prints_items'" ) !=
	PVS_DB_PREFIX . 'prints_items' )
{

	$sql = "CREATE TABLE `" . PVS_DB_PREFIX . "prints_items` (
	  `id_parent` int(11) NOT NULL auto_increment,
	  `title` varchar(200) default NULL,
	  `price` float default NULL,
	  `itemid` int(11) default NULL,
	  `priority` int(11) default NULL,
	  `printsid` int(11) default NULL,
	  `in_stock` int(11) default NULL,
	  PRIMARY KEY  (`id_parent`),
	  UNIQUE KEY `id_parent_2` (`id_parent`),
	  KEY `id_parent` (`id_parent`),
	  KEY `itemid` (`itemid`),
	  KEY `priority` (`priority`),
	  KEY `printsid` (`printsid`),
	  KEY `in_stock` (`in_stock`)
	)";
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'prints_items` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//prints_previews
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "prints_previews'" ) !=
	PVS_DB_PREFIX . 'prints_previews' )
{

	$sql = "CREATE TABLE `" . PVS_DB_PREFIX . "prints_previews` (
	  `id` int(11) NOT NULL auto_increment,
	  `title` varchar(250) default NULL,
	  `preview` varchar(30) default NULL,
	  PRIMARY KEY  (`id`)
	)";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"prints_previews` VALUES(1, 'Canvas Prints ', 'canvas_prints')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"prints_previews` VALUES(6, 'Framed prints', 'framed_prints')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"prints_previews` VALUES(4, 'Prints', 'prints')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"prints_previews` VALUES(5, 'Metal prints', 'metal_prints')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"prints_previews` VALUES(7, 'Acrylic prints', 'acrylic_prints')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"prints_previews` VALUES(8, 'Greeting cards', 'greeting_cards')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"prints_previews` VALUES(9, 'iPhone Cases', 'iphone_cases')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"prints_previews` VALUES(10, 'Galaxy Cases', 'galaxy_cases')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"prints_previews` VALUES(12, 'Pillow', 'pillow')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"prints_previews` VALUES(13, 'Tote Bag', 'bag')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"prints_previews` VALUES(14, 'Duvet Cover', 'duvet_cover')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"prints_previews` VALUES(15, 'Shower Curtain', 'shower_curtain')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"prints_previews` VALUES(16, 'T-Shirt', 'tshirt')";
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'prints_previews` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//products_options
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "products_options'" ) !=
	PVS_DB_PREFIX . 'products_options' )
{

	$sql = "CREATE TABLE `" . PVS_DB_PREFIX . "products_options` (
	  `id` int(11) NOT NULL auto_increment,
	  `title` varchar(100) default NULL,
	  `type` varchar(100) default NULL,
	  `activ` tinyint(4) default NULL,
	  `required` tinyint(4) default NULL,
	  `description` int(11) default NULL,
	  `property_name` varchar(50) default NULL,
	  PRIMARY KEY  (`id`),
	  KEY `activ` (`activ`)
	)";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options` VALUES(1, 'Paper', 'selectform', 1, 1, 0, 'print_paper')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options` VALUES(2, 'Size of T-shirt', 'selectform', 1, 1, 0, 'tshirt_size')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options` VALUES(6, 'Frame', 'frame', 1, 1, 7503, 'print_frame')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options` VALUES(8, 'Size', 'selectform', 1, 1, 0, 'print_size')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options` VALUES(9, 'Canvas', 'radio', 1, 1, 0, 'print_canvas')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options` VALUES(10, 'Wrap', 'selectform', 1, 1, 0, 'print_wrap')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options` VALUES(11, 'Top Mat Size', 'selectform', 1, 1, 0, 'top_mat_size')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options` VALUES(12, 'Mounting', 'radio', 1, 1, 0, 'print_mounting')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options` VALUES(13, 'Quantity', 'selectform', 1, 1, 0, 'print_quantity')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options` VALUES(14, 'Orientation', 'selectform', 1, 1, 0, 'print_orientation')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options` VALUES(23, 'iPhone Model', 'selectform', 1, 1, 0, 'iphone_model')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options` VALUES(16, 'Top Mat Color', 'colors', 1, 1, 0, 'top_mat_color')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options` VALUES(17, 'Bottom Mat Size', 'selectform', 1, 1, 0, 'bottom_mat_size')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options` VALUES(18, 'Bottom Mat Color', 'colors', 1, 1, 0, 'bottom_mat_color')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options` VALUES(19, 'Print Size', 'selectform', 1, 1, 0, 'print_size')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options` VALUES(20, 'Card Size', 'selectform', 1, 1, 0, 'print_size')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options` VALUES(24, 'Case Orientation', 'selectform', 1, 1, 0, 'orientation_case')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options` VALUES(25, 'Galaxy Model', 'selectform', 1, 1, 0, 'galaxy_model')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options` VALUES(26, 'Pillow Size', 'selectform', 1, 1, 0, 'pillow_size')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options` VALUES(27, 'Pillow Insert', 'radio', 1, 1, 0, 'pillow_insert')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options` VALUES(28, 'Bag Size', 'selectform', 1, 1, 0, 'bag_size')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options` VALUES(29, 'Duvet Size', 'selectform', 1, 1, 0, 'duvet_size')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options` VALUES(30, 'T-shirt Color', 'background', 1, 1, 0, 'tshirt_color')";
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'products_options` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//products_options_items
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX .
	"products_options_items'" ) != PVS_DB_PREFIX . 'products_options_items' )
{

	$sql = "CREATE TABLE `" . PVS_DB_PREFIX . "products_options_items` (
	  `id` int(11) NOT NULL auto_increment,
	  `id_parent` int(11) default NULL,
	  `title` varchar(100) default NULL,
	  `price` float default NULL,
	  `adjust` int(11) default NULL,
	  `property_value` varchar(250) default NULL,
	  PRIMARY KEY  (`id`),
	  KEY `id_parent` (`id_parent`)
	)";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(663, 1, 'Picture Rag', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(650, 2, 'XXXL', 1, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(649, 2, 'XXL', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(648, 2, 'XL', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(647, 2, 'L', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(646, 2, 'M', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(665, 1, 'Watercolor Paper', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(645, 2, 'S', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(194, 8, '102cm', 90, 1, '1000')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(664, 1, 'Somerset Velvet', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(603, 23, 'iPhone 4 /4s', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(644, 2, 'XS', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(193, 8, '91cm', 80, 1, '1000')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(192, 8, '76cm', 70, 1, '1000')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(191, 8, '61cm', 60, 1, '1000')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(190, 8, '51cm', 50, 1, '1000')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(110, 9, 'Glossy Finish Canvas', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(111, 9, 'Matte Finish Canvas', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(602, 23, 'iPhone 5c', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(225, 10, 'Mirrored Sides', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(224, 10, 'Black Sides', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(223, 10, 'White Sides', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(222, 10, 'No Wrap - Rolled In A Tube', 20, -1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(288, 11, '2cm', 4, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(662, 1, 'Semi-Matte Photo Paper', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(661, 1, 'Luster Photo Paper', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(660, 1, 'Glossy Photo Paper', 1, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(659, 1, 'Archival Matte Paper', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(139, 12, 'Hanging Wire', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(140, 12, 'Aluminum Mounting Posts', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(141, 13, 'Single card', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(142, 13, 'Pack of 10', 20, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(143, 13, 'Pack of 25', 40, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(144, 14, 'Horizontal', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(145, 14, 'Vertical', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(195, 8, '122cm', 100, 1, '1000')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(189, 8, '41cm', 40, 1, '1000')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(188, 8, '36cm', 30, 1, '1000')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(187, 8, '25cm', 20, 1, '1000')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(186, 8, '20cm', 10, 1, '1000')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(601, 23, 'iPhone 5 / 5s', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(600, 23, 'iPhone 6s Plus', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(284, 11, '0cm', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(287, 11, '1.5cm', 3, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(395, 16, '#294964', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(394, 16, '#4b5d6b', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(393, 16, '#425277', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(392, 16, '#3d3c52', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(286, 11, '1cm', 2, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(391, 16, '#c9c59d', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(293, 17, '2cm', 4, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(292, 17, '1.5cm', 3, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(291, 17, '1cm', 2, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(290, 17, '0.5cm', 1, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(289, 17, '0cm', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(433, 18, '#faf8e4', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(432, 18, '#fef9e4', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(431, 18, '#fef9e3', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(430, 18, '#faf8f4', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(429, 18, '#ffffff', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(264, 19, '10cm', 1, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(265, 19, '12cm', 2, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(266, 19, '15cm', 3, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(267, 19, '16cm', 4, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(268, 19, '20cm', 5, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(269, 19, '22cm', 6, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(285, 11, '0.5cm', 1, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(390, 16, '#99b4a0', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(389, 16, '#8b9a66', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(388, 16, '#848e61', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(387, 16, '#495a2b', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(386, 16, '#3e6b55', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(385, 16, '#3a4e3b', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(384, 16, '#4e4934', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(383, 16, '#fceb43', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(382, 16, '#ac875e', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(381, 16, '#c39b6a', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(380, 16, '#bba783', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(379, 16, '#dec092', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(378, 16, '#e6cbb3', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(377, 16, '#e8d7ab', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(376, 16, '#e3d2ac', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(375, 16, '#e3d7b0', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(374, 16, '#e0d4bb', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(373, 16, '#f1e8d1', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(372, 16, '#fbf3cc', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(371, 16, '#fdf5d2', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(370, 16, '#fcf6db', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(369, 16, '#fdeed7', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(368, 16, '#fcf6db', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(367, 16, '#faf8e4', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(366, 16, '#fef9e4', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(365, 16, '#fef9e3', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(364, 16, '#faf8f4', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(363, 16, '#ffffff', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(396, 16, '#2a567b', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(397, 16, '#467286', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(398, 16, '#87a0b1', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(399, 16, '#9ea2a0', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(400, 16, '#b1c8cf', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(401, 16, '#45332d', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(402, 16, '#6b4d30', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(403, 16, '#886446', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(404, 16, '#80664a', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(405, 16, '#ebd592', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(406, 16, '#e1b75e', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(407, 16, '#e55b36', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(408, 16, '#f6a226', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(409, 16, '#a86838', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(410, 16, '#a84025', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(411, 16, '#f67938', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(412, 16, '#d7dadc', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(413, 16, '#b0bbb2', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(414, 16, '#504a52', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(415, 16, '#564e42', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(416, 16, '#242827', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(417, 16, '#1f1c1c', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(418, 16, '#febcc5', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(419, 16, '#a83a3c', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(420, 16, '#e30038', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(421, 16, '#a81839', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(422, 16, '#b00031', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(423, 16, '#66346d', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(424, 16, '#63272e', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(425, 16, '#f9faec', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(426, 16, '#fdfdf4', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(427, 16, '#fbfbfa', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(428, 16, '#262925', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(434, 18, '#fcf6db', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(435, 18, '#fdeed7', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(436, 18, '#fcf6db', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(437, 18, '#fdf5d2', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(438, 18, '#fbf3cc', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(439, 18, '#f1e8d1', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(440, 18, '#e0d4bb', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(441, 18, '#e3d7b0', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(442, 18, '#e3d2ac', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(443, 18, '#e8d7ab', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(444, 18, '#e6cbb3', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(445, 18, '#dec092', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(446, 18, '#bba783', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(447, 18, '#c39b6a', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(448, 18, '#ac875e', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(449, 18, '#fceb43', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(450, 18, '#4e4934', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(451, 18, '#3a4e3b', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(452, 18, '#3e6b55', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(453, 18, '#495a2b', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(454, 18, '#848e61', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(455, 18, '#8b9a66', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(456, 18, '#99b4a0', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(457, 18, '#c9c59d', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(458, 18, '#3d3c52', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(459, 18, '#425277', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(460, 18, '#4b5d6b', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(461, 18, '#294964', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(462, 18, '#2a567b', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(463, 18, '#467286', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(464, 18, '#87a0b1', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(465, 18, '#9ea2a0', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(466, 18, '#b1c8cf', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(467, 18, '#45332d', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(468, 18, '#6b4d30', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(469, 18, '#886446', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(470, 18, '#80664a', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(471, 18, '#ebd592', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(472, 18, '#e1b75e', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(473, 18, '#e55b36', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(474, 18, '#f6a226', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(475, 18, '#a86838', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(476, 18, '#a84025', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(477, 18, '#f67938', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(478, 18, '#d7dadc', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(479, 18, '#b0bbb2', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(480, 18, '#504a52', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(481, 18, '#564e42', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(482, 18, '#242827', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(483, 18, '#1f1c1c', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(484, 18, '#febcc5', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(485, 18, '#a83a3c', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(486, 18, '#e30038', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(487, 18, '#a81839', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(488, 18, '#b00031', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(489, 18, '#66346d', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(490, 18, '#63272e', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(491, 18, '#f9faec', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(492, 18, '#fdfdf4', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(493, 18, '#fbfbfa', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(494, 18, '#262925', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(503, 20, '8cm', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(502, 20, '7cm', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(501, 20, '6cm', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(599, 23, 'iPhone 6s', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(598, 23, 'iPhone 7 Plus', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(658, 6, 'frame0', 0, 1, '0cm')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(657, 6, 'frame7', 35, 1, '6cm')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(656, 6, 'frame6', 30, 1, '6cm')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(655, 6, 'frame5', 20, 1, '1cm')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(654, 6, 'frame4', 40, 1, '6cm')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(653, 6, 'frame3', 20, 1, '1cm')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(652, 6, 'frame2', 34, 1, '1cm')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(651, 6, 'frame1', 25, 1, '2cm')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(597, 23, 'iPhone 7', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(594, 24, 'Vertical', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(595, 24, 'Horizontal Right', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(596, 24, 'Horizontal Left', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(604, 25, 'Galaxy S7', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(605, 25, 'Galaxy S6', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(606, 25, 'Galaxy S5', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(607, 25, 'Galaxy S4', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(608, 26, '35cm x 35cm', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(609, 26, '40cm x 40cm', 3, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(610, 26, '45cm x 45cm', 6, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(611, 26, '50cm x 50cm', 9, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(612, 26, '65cm x 65cm', 15, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(613, 27, 'Yes', 8, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(614, 27, 'No', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(615, 28, '32cm x 32cm', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(616, 28, '40cm x 40cm', 5, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(617, 28, '45cm x 45cm', 10, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(618, 29, 'King', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(619, 29, 'Queen', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(620, 29, 'Full', 20, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(621, 29, 'Twin', 30, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(642, 30, 'tshirt_light_blue.png', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(641, 30, 'tshirt_green.png', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(640, 30, 'tshirt_blue.png', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(639, 30, 'tshirt_brown.png', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(638, 30, 'tshirt_yellow.png', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(637, 30, 'tshirt_orange.png', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(636, 30, 'tshirt_red.png', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(635, 30, 'tshirt_black.png', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(634, 30, 'tshirt_gray.png', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(633, 30, 'tshirt_white.png', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(643, 30, 'tshirt_purple.png', 0, 1, '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"products_options_items` VALUES(666, 1, 'Metallic Paper', 0, 1, '')";
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'products_options_items` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//pwinty
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "pwinty'" ) !=
	PVS_DB_PREFIX . 'pwinty' )
{

	$sql = "CREATE TABLE `" . PVS_DB_PREFIX . "pwinty` (
	  `account` varchar(250) default NULL,
	  `password` varchar(250) default NULL,
	  `testmode` tinyint(4) default NULL,
	  `order_number` int(11) default NULL,
	  `countrycode` varchar(50) default NULL,
	  `usetrackedshipping` tinyint(4) default NULL,
	  `payment` varchar(50) default NULL,
	  `qualitylevel` varchar(50) default NULL,
	  `photoresizing` varchar(50) default NULL
	)";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"pwinty` VALUES('test', 'test', 1, 1, 'United Kingdom', 1, 'InvoiceMe', 'Standard', 'ShrinkToFit')";
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'pwinty` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//pwinty_orders
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "pwinty_orders'" ) !=
	PVS_DB_PREFIX . 'pwinty_orders' )
{

	$sql = "CREATE TABLE `" . PVS_DB_PREFIX . "pwinty_orders` (
	  `order_id` int(11) default NULL,
	  `pwinty_id` int(11) default NULL,
	  `data` int(11) default NULL,
	  KEY `order_id` (`order_id`)
	)";
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'pwinty_orders` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//pwinty_prints
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "pwinty_prints'" ) !=
	PVS_DB_PREFIX . 'pwinty_prints' )
{

	$sql = "CREATE TABLE `" . PVS_DB_PREFIX . "pwinty_prints` (
	  `print_id` int(11) default NULL,
	  `activ` tinyint(4) default NULL,
	  `title` varchar(100) default NULL,
	  KEY `print_id` (`print_id`),
	  KEY `activ` (`activ`)
	)";
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'pwinty_prints` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//reviews
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "reviews'" ) !=
	PVS_DB_PREFIX . 'reviews' )
{

	$sql = "CREATE TABLE `" . PVS_DB_PREFIX . "reviews` (
	  `id_parent` int(11) NOT NULL auto_increment,
	  `fromuser` varchar(200) default NULL,
	  `content` text,
	  `itemid` int(11) default NULL,
	  `data` int(11) default NULL,
	  KEY `id_parent` (`id_parent`),
	  KEY `fromuser` (`fromuser`),
	  KEY `itemid` (`itemid`),
	  KEY `data` (`data`)
	)";
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'reviews` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//rights_managed
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "rights_managed'" ) !=
	PVS_DB_PREFIX . 'rights_managed' )
{

	$sql = "CREATE TABLE `" . PVS_DB_PREFIX . "rights_managed` (
	  `id` int(11) NOT NULL auto_increment,
	  `title` varchar(100) default NULL,
	  `price` float default NULL,
	  `formats` varchar(250) default NULL,
	  `photo` tinyint(4) default NULL,
	  `video` tinyint(4) default NULL,
	  `audio` tinyint(4) default NULL,
	  `vector` tinyint(4) default NULL,
	  PRIMARY KEY  (`id`)
	)";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed` VALUES(1, 'Rights managed (Example like gettyimages. Prices are not real)', 2, 'jpg,jpeg,wmv,mp3,zip,png,gif', 1, 1, 1, 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed` VALUES(7, 'Test', 1, 'jpg,jpeg', 1, 1, 1, 1)";
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'rights_managed` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//rights_managed_groups
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX .
	"rights_managed_groups'" ) != PVS_DB_PREFIX . 'rights_managed_groups' )
{

	$sql = "CREATE TABLE `" . PVS_DB_PREFIX . "rights_managed_groups` (
	  `id` int(11) NOT NULL auto_increment,
	  `title` varchar(100) default NULL,
	  `description` text,
	  PRIMARY KEY  (`id`)
	)";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_groups` VALUES(2, 'Use', '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_groups` VALUES(3, 'Formats - Web and app', '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_groups` VALUES(4, 'Formats - Advertising - Print, display and TV', '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_groups` VALUES(5, 'Formats - Marketing and promotional collateral', '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_groups` VALUES(6, 'Formats - Publishing and editorial', '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_groups` VALUES(7, 'Formats - Film, video and TV programs', '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_groups` VALUES(8, 'Formats - Internal use - Companies and organizations', '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_groups` VALUES(9, 'Formats - Retail, product and packaging', '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_groups` VALUES(10, 'Size', '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_groups` VALUES(11, 'Circulation', '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_groups` VALUES(12, 'Duration', '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_groups` VALUES(13, ' Territory', '')";
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'rights_managed_groups` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//rights_managed_options
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX .
	"rights_managed_options'" ) != PVS_DB_PREFIX . 'rights_managed_options' )
{

	$sql = "CREATE TABLE `" . PVS_DB_PREFIX . "rights_managed_options` (
	  `id` int(11) NOT NULL auto_increment,
	  `id_parent` int(11) NOT NULL,
	  `title` varchar(100) default NULL,
	  `adjust` varchar(1) default NULL,
	  `price` float default NULL,
	  PRIMARY KEY  (`id`),
	  KEY `id_parent` (`id_parent`)
	)";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(43, 2, 'Internal use - Companies and organizations', '+', 5)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(42, 2, 'Film, video and TV programs', '+', 100)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(41, 2, 'Publishing and editorial', '+', 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(40, 2, 'Marketing and promotional collateral', '+', 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(39, 2, 'Advertising - Print, display and TV', '+', 100)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(38, 2, 'Web and app', '+', 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(20, 3, 'Web, app or software advertisement', '+', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(21, 3, 'Web - Corporate and promotional site', '+', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(22, 3, 'Web - Webisode', '+', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(23, 3, 'Web  Social Media', '+', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(24, 3, 'Web - Electronic brochure, email and direct promotion', '+', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(25, 3, 'OEM portable device', '+', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(26, 3, 'Apps - Corporate or promotional use', '+', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(27, 3, 'Apps  Retail', '+', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(50, 4, 'Display - Non-point of sale advertising', '+', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(49, 4, 'Display - Billboard', '+', 5)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(48, 4, 'Print ad - Event program', '+', 4)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(47, 4, 'Print ad - Magazine and newspaper', '+', 3)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(46, 4, 'Print ad - Freestanding insert', '+', 2)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(45, 4, 'Print ad - Directory', '+', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(44, 2, 'Retail, product and packaging', '+', 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(51, 4, 'Display - Point of sale', '+', 2)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(52, 4, 'TV - Commercial', '+', 3)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(53, 4, 'TV - Infomercial', '+', 4)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(54, 4, 'Advertorial - Any placement', '+', 5)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(55, 5, 'Brochure and direct mail', '+', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(56, 5, 'Single sheet and postcard', '+', 2)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(57, 5, 'Corporate report', '+', 3)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(58, 5, 'External presentation or report', '+', 4)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(59, 5, 'Sales giveaway', '+', 5)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(60, 5, 'Newsletter, press collateral and event programs', '+', 6)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(61, 5, 'Sales CD, DVD and video', '+', 2)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(62, 5, 'Travel brochure - Cover', '+', 8)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(63, 5, 'Travel brochure - Interior', '+', 3)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(64, 5, 'Corporate calendar and greeting card', '+', 8)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(65, 6, 'Retail book cover - Print and electronic', '+', 2)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(66, 6, 'Textbook cover - Print and electronic', '+', 3)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(67, 6, 'Retail book interior - Print and electronic', '+', 4)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(68, 6, 'Textbook interior - Print and electronic', '+', 8)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(69, 6, 'Book - Electronic', '+', 6)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(70, 6, 'Editorial - Magazine cover', '+', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(71, 6, 'Editorial - Magazine interior', '+', 5)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(72, 6, 'Editorial - Newspaper', '+', 2)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(73, 6, 'Editorial - Electronic (web or app)', '+', 34)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(74, 6, 'Custom or contract publishing - Cover', '+', 12)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(75, 6, 'Custom or contract publishing - Interior', '+', 7)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(100, 7, 'Major motion picture - Non-documentary insert, Flash or graphic element', '+', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(99, 7, 'Film trailer or theatrical promo', '+', 3)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(98, 7, 'Promotional - All media promo', '+', 3)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(97, 7, 'Promotional - Broadcast network online promo', '+', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(96, 7, 'Promotional - On air promo', '+', 2)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(95, 7, 'Music video', '+', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(94, 7, 'Show title sequence - Television (cable &amp; standard)', '+', 14)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(93, 7, 'Non-editorial program insert', '+', 13)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(92, 7, 'Non-editorial program prop and set decor', '+', 11)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(91, 7, 'Television educational, documentary or doc style progra', '+', 12)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(90, 7, 'Television (cable &amp; standard) news program', '+', 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(101, 7, 'Major motion picture - Non-documentary set decor', '+', 4)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(102, 7, 'Major motion picture - Documentary', '+', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(103, 7, 'Major motion picture - Title sequence', '+', 5)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(113, 8, 'Nonprofit and museum - Display', '+', 4)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(112, 8, 'Internal - Wall decor and display', '+', 8)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(111, 8, 'Internal digital - Intranet, email, video and presentation', '+', 2)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(110, 8, 'Internal print - Brochure, newsletter and collateral', '+', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(114, 8, 'Nonprofit and museum - Electronic display', '+', 3)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(115, 8, 'Theatrical - Live performance', '+', 3)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(116, 9, 'Product packaging, covers and tags', '+', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(117, 9, 'Product design - Games, toys and other', '+', 2)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(118, 9, 'Greeting card', '+', 3)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(119, 9, 'Check/Credit/ATM cards and checks', '+', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(120, 9, 'Phone, store and transit cards', '+', 4)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(121, 9, 'Retail - Calendar cover', '+', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(122, 9, 'Retail - Calendar interior', '+', 2)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(123, 9, 'Retail - Poster', '+', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(124, 9, 'Retail - Stationery and postcards', '+', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(125, 9, 'Retail - Miscellaneous and novelty', '+', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(126, 9, 'Product design - Software and video games', '+', 5)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(127, 9, 'Trading cards - Exclusive use', '+', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(128, 9, 'Trading cards - Non-exclusive use', '+', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(129, 9, 'Event ticket', '+', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(130, 10, 'Up to 1/8 of ad', '+', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(131, 10, 'Up to 1/4 of ad', '+', 2)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(132, 10, 'Up to 1/2 of ad', '+', 3)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(133, 10, 'Up to full ad', '+', 4)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(134, 11, 'One', '+', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(135, 11, 'Up to 5', '+', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(136, 11, 'Up to 50', '+', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(137, 11, 'Up to 100', '+', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(138, 11, 'Up to 250', '+', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(139, 11, 'Up to 500', '+', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(140, 11, 'More than 500', '+', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(141, 12, 'Up to 1 week', '+', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(142, 12, 'Up to 1 month', '+', 20)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(143, 12, 'Up to 3 months', '+', 40)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(144, 12, 'Up to 6 months', '+', 100)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(145, 12, 'Up to 1 year', '+', 140)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(146, 12, 'Up to 2 years', '+', 200)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(147, 12, 'Up to 3 years', '+', 250)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(148, 12, 'Up to 5 years', '+', 300)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(149, 13, 'USA and Canada', '+', 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_options` VALUES(150, 13, 'EU', '+', 20)";
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'rights_managed_options` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//rights_managed_structure
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX .
	"rights_managed_structure'" ) != PVS_DB_PREFIX . 'rights_managed_structure' )
{

	$sql = "CREATE TABLE `" . PVS_DB_PREFIX . "rights_managed_structure` (
	  `id` int(11) NOT NULL auto_increment,
	  `id_parent` int(11) NOT NULL,
	  `types` int(1) default NULL,
	  `title` varchar(100) default NULL,
	  `adjust` varchar(1) default NULL,
	  `price` float default NULL,
	  `price_id` int(11) default NULL,
	  `group_id` int(11) default NULL,
	  `option_id` int(11) default NULL,
	  `conditions` varchar(250) default NULL,
	  `collapse` tinyint(4) default NULL,
	  PRIMARY KEY  (`id`),
	  KEY `id_parent` (`id_parent`),
	  KEY `price_id` (`price_id`),
	  KEY `group_id` (`group_id`),
	  KEY `option_id` (`option_id`)
	)";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(61, 0, 0, 'Target market', '', 0, 1, 0, 0, NULL, 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(60, 0, 0, ' Usage specs', '', 0, 1, 0, 0, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(59, 0, 0, 'Image usage', '', 0, 1, 0, 0, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(77, 70, 2, 'Display - Point of sale', '+', 2, 1, 4, 51, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(75, 70, 2, 'Print ad - Freestanding insert', '+', 2, 1, 4, 46, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(76, 70, 2, 'Print ad - Directory', '+', 1, 1, 4, 45, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(74, 70, 2, 'Print ad - Magazine and newspaper', '+', 3, 1, 4, 47, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(73, 70, 2, 'Print ad - Event program', '+', 4, 1, 4, 48, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(70, 67, 1, 'Formats - Advertising - Print, display and TV', '', 0, 1, 4, 0, NULL, 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(71, 70, 2, 'Display - Non-point of sale advertising', '+', 1, 1, 4, 50, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(72, 70, 2, 'Display - Billboard', '+', 5, 1, 4, 49, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(69, 62, 2, 'Retail, product and packaging', '+', 10, 1, 2, 44, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(68, 62, 2, 'Web and app', '+', 10, 1, 2, 38, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(67, 62, 2, 'Advertising - Print, display and TV', '+', 100, 1, 2, 39, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(62, 59, 1, 'Use', '', 0, 1, 2, 0, '0-0-0-0-0-0-0', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(63, 62, 2, 'Internal use - Companies and organizations', '+', 5, 1, 2, 43, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(64, 62, 2, 'Film, video and TV programs', '+', 100, 1, 2, 42, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(65, 62, 2, 'Publishing and editorial', 'x', 2, 1, 2, 41, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(66, 62, 2, 'Marketing and promotional collateral', '+', 10, 1, 2, 40, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(78, 70, 2, 'TV - Commercial', '+', 3, 1, 4, 52, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(79, 70, 2, 'TV - Infomercial', '+', 4, 1, 4, 53, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(80, 70, 2, 'Advertorial - Any placement', '+', 5, 1, 4, 54, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(81, 63, 1, 'Formats - Internal use - Companies and organizations', '', 0, 1, 8, 0, NULL, 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(82, 81, 2, 'Nonprofit and museum - Display', '+', 4, 1, 8, 113, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(83, 81, 2, 'Internal - Wall decor and display', '+', 8, 1, 8, 112, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(84, 81, 2, 'Internal digital - Intranet, email, video and presentation', '+', 2, 1, 8, 111, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(85, 81, 2, 'Internal print - Brochure, newsletter and collateral', '+', 1, 1, 8, 110, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(86, 81, 2, 'Nonprofit and museum - Electronic display', '+', 3, 1, 8, 114, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(87, 81, 2, 'Theatrical - Live performance', '+', 3, 1, 8, 115, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(88, 64, 1, 'Formats - Film, video and TV programs', '', 0, 1, 7, 0, NULL, 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(89, 88, 2, 'Major motion picture - Non-documentary insert, Flash or graphic element', '+', 1, 1, 7, 100, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(90, 88, 2, 'Film trailer or theatrical promo', '+', 3, 1, 7, 99, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(91, 88, 2, 'Promotional - All media promo', '+', 3, 1, 7, 98, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(92, 88, 2, 'Promotional - Broadcast network online promo', '+', 1, 1, 7, 97, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(93, 88, 2, 'Promotional - On air promo', '+', 2, 1, 7, 96, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(94, 88, 2, 'Music video', '+', 1, 1, 7, 95, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(95, 88, 2, 'Show title sequence - Television (cable &amp; standard)', '+', 14, 1, 7, 94, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(96, 88, 2, 'Non-editorial program insert', '+', 13, 1, 7, 93, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(97, 88, 2, 'Non-editorial program prop and set decor', '+', 11, 1, 7, 92, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(98, 88, 2, 'Television educational, documentary or doc style progra', '+', 12, 1, 7, 91, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(99, 88, 2, 'Television (cable &amp; standard) news program', '+', 10, 1, 7, 90, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(100, 88, 2, 'Major motion picture - Non-documentary set decor', '+', 4, 1, 7, 101, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(101, 88, 2, 'Major motion picture - Documentary', '+', 1, 1, 7, 102, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(102, 88, 2, 'Major motion picture - Title sequence', '+', 5, 1, 7, 103, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(103, 65, 1, 'Formats - Publishing and editorial', '', 0, 1, 6, 0, NULL, 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(104, 103, 2, 'Retail book cover - Print and electronic', '+', 2, 1, 6, 65, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(105, 103, 2, 'Textbook cover - Print and electronic', '+', 3, 1, 6, 66, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(106, 103, 2, 'Retail book interior - Print and electronic', '+', 4, 1, 6, 67, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(107, 103, 2, 'Textbook interior - Print and electronic', '+', 8, 1, 6, 68, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(108, 103, 2, 'Book - Electronic', '+', 6, 1, 6, 69, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(109, 103, 2, 'Editorial - Magazine cover', '+', 1, 1, 6, 70, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(110, 103, 2, 'Editorial - Magazine interior', '+', 5, 1, 6, 71, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(111, 103, 2, 'Editorial - Newspaper', '+', 2, 1, 6, 72, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(112, 103, 2, 'Editorial - Electronic (web or app)', '+', 34, 1, 6, 73, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(113, 103, 2, 'Custom or contract publishing - Cover', '+', 12, 1, 6, 74, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(114, 103, 2, 'Custom or contract publishing - Interior', '+', 7, 1, 6, 75, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(115, 66, 1, 'Formats - Marketing and promotional collateral', '', 0, 1, 5, 0, NULL, 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(116, 115, 2, 'Brochure and direct mail', '+', 1, 1, 5, 55, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(117, 115, 2, 'Single sheet and postcard', '+', 2, 1, 5, 56, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(118, 115, 2, 'Corporate report', '+', 3, 1, 5, 57, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(119, 115, 2, 'External presentation or report', '+', 4, 1, 5, 58, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(120, 115, 2, 'Sales giveaway', '+', 5, 1, 5, 59, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(121, 115, 2, 'Newsletter, press collateral and event programs', '+', 6, 1, 5, 60, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(122, 115, 2, 'Sales CD, DVD and video', '+', 2, 1, 5, 61, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(123, 115, 2, 'Travel brochure - Cover', '+', 8, 1, 5, 62, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(124, 115, 2, 'Travel brochure - Interior', '+', 3, 1, 5, 63, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(125, 115, 2, 'Corporate calendar and greeting card', '+', 8, 1, 5, 64, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(126, 68, 1, 'Formats - Web and app', '', 0, 1, 3, 0, NULL, 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(127, 126, 2, 'Web, app or software advertisement', '+', 1, 1, 3, 20, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(128, 126, 2, 'Web - Corporate and promotional site', '+', 1, 1, 3, 21, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(129, 126, 2, 'Web - Webisode', '+', 1, 1, 3, 22, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(130, 126, 2, 'Web  Social Media', '+', 1, 1, 3, 23, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(131, 126, 2, 'Web - Electronic brochure, email and direct promotion', '+', 1, 1, 3, 24, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(132, 126, 2, 'OEM portable device', '+', 1, 1, 3, 25, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(133, 126, 2, 'Apps - Corporate or promotional use', '+', 1, 1, 3, 26, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(134, 126, 2, 'Apps  Retail', '+', 1, 1, 3, 27, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(135, 69, 1, 'Formats - Retail, product and packaging', '', 0, 1, 9, 0, NULL, 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(136, 135, 2, 'Product packaging, covers and tags', '+', 1, 1, 9, 116, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(137, 135, 2, 'Product design - Games, toys and other', '+', 2, 1, 9, 117, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(138, 135, 2, 'Greeting card', '+', 3, 1, 9, 118, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(139, 135, 2, 'Check/Credit/ATM cards and checks', '+', 1, 1, 9, 119, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(140, 135, 2, 'Phone, store and transit cards', '+', 4, 1, 9, 120, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(141, 135, 2, 'Retail - Calendar cover', '+', 1, 1, 9, 121, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(142, 135, 2, 'Retail - Calendar interior', '+', 2, 1, 9, 122, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(143, 135, 2, 'Retail - Poster', '+', 1, 1, 9, 123, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(144, 135, 2, 'Retail - Stationery and postcards', '+', 1, 1, 9, 124, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(145, 135, 2, 'Retail - Miscellaneous and novelty', '+', 1, 1, 9, 125, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(146, 135, 2, 'Product design - Software and video games', '+', 5, 1, 9, 126, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(147, 135, 2, 'Trading cards - Exclusive use', '+', 1, 1, 9, 127, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(148, 135, 2, 'Trading cards - Non-exclusive use', '+', 1, 1, 9, 128, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(149, 135, 2, 'Event ticket', '+', 1, 1, 9, 129, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(150, 60, 1, 'Duration', '', 0, 1, 12, 0, '0-0-0-0-0-0-0', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(151, 150, 2, 'Up to 1 week', '+', 1, 1, 12, 141, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(152, 150, 2, 'Up to 1 month', '+', 20, 1, 12, 142, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(153, 150, 2, 'Up to 3 months', '+', 40, 1, 12, 143, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(154, 150, 2, 'Up to 6 months', '+', 100, 1, 12, 144, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(155, 150, 2, 'Up to 1 year', '+', 140, 1, 12, 145, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(156, 150, 2, 'Up to 2 years', '+', 200, 1, 12, 146, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(157, 150, 2, 'Up to 3 years', '+', 250, 1, 12, 147, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(158, 150, 2, 'Up to 5 years', '+', 300, 1, 12, 148, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(159, 60, 1, 'Size', '', 0, 1, 10, 0, '39-40-41-44-0-0-0', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(160, 159, 2, 'Up to 1/8 of ad', '+', 1, 1, 10, 130, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(161, 159, 2, 'Up to 1/4 of ad', '+', 2, 1, 10, 131, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(162, 159, 2, 'Up to 1/2 of ad', '+', 3, 1, 10, 132, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(163, 159, 2, 'Up to full ad', '+', 4, 1, 10, 133, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(164, 60, 1, 'Circulation', '', 0, 1, 11, 0, '39-40-41-42-43-44-0', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(165, 164, 2, 'One', '+', 1, 1, 11, 134, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(166, 164, 2, 'Up to 5', '+', 1, 1, 11, 135, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(167, 164, 2, 'Up to 50', '+', 1, 1, 11, 136, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(168, 164, 2, 'Up to 100', '+', 1, 1, 11, 137, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(169, 164, 2, 'Up to 250', '+', 1, 1, 11, 138, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(170, 164, 2, 'Up to 500', '+', 1, 1, 11, 139, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(171, 164, 2, 'More than 500', '+', 1, 1, 11, 140, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(182, 180, 2, 'EU', '+', 20, 1, 13, 150, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(181, 180, 2, 'USA and Canada', '+', 10, 1, 13, 149, NULL, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(180, 61, 1, ' Territory', '', 0, 1, 13, 0, NULL, 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"rights_managed_structure` VALUES(242, 0, 0, 'Step 1', '', 0, 7, 0, 0, '', 0)";
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'rights_managed_structure` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//search_history
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "search_history'" ) !=
	PVS_DB_PREFIX . 'search_history' )
{

	$sql = "CREATE TABLE `" . PVS_DB_PREFIX . "search_history` (
	  `zapros` varchar(250) default NULL,
	  `data` int(11) default NULL,
	  KEY `zapros` (`zapros`),
	  KEY `data` (`data`)
	)";
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'search_history` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//settings
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "settings'" ) !=
	PVS_DB_PREFIX . 'settings' )
{

	$sql = 'CREATE TABLE `' . PVS_DB_PREFIX . 'settings` (
	  `id` int(11) NOT NULL auto_increment,
	  `name` varchar(250) default NULL,
	  `svalue` varchar(250) default NULL,
	  `setting_key` varchar(250) default NULL,
	  `priority` int(11) default NULL,
	  `stype` varchar(20) default NULL,
	  `checkboxes` tinyint(4) default NULL,
	  PRIMARY KEY  (`id`),
	  KEY `stype` (`stype`)
	)';
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'settings` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Small thumb width', '120', 'thumb_width', 85, 'site', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Big thumb width', '540', 'thumb_width2', 95, 'site', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Lightbox photo', '1', 'lightbox_photo', 130, 'site', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Lightbox video', '1', 'lightbox_video', 140, 'site', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Items on the page', '10', 'k_str', 80, 'site', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('photographers', '1', 'userupload', 73, 'site', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Lightbox video width', '300', 'video_width', 140, 'site', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Lightbox video height', '225', 'video_height', 150, 'site', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Require Shipping Address for the Order Checkout', '1', 'checkout_order_shipping', 720, 'checkout', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('user status as default', 'Silver', 'userstatus', 240, 'site', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('fixed height', '1', 'fixed_height', 163, 'site', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Preview fixed height', '200', 'height_flow', 165, 'site', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Photo preupload folder', '/content/photopreupload/', 'photopreupload', 310, 'site', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Video preupload folder', '/content/videopreupload/', 'videopreupload', 320, 'site', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Audio preupload folder', '/content/audiopreupload/', 'audiopreupload', 330, 'site', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('small thumb height', '120', 'thumb_height', 90, 'site', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('big thumb height', '540', 'thumb_height2', 100, 'site', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Allow photo', '1', 'allow_photo', 50, 'site', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Allow video', '1', 'allow_video', 53, 'site', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Allow audio', '1', 'allow_audio', 55, 'site', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Messages', '1', 'messages', 350, 'site', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Testimonials', '1', 'testimonials', 360, 'site', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Reviews', '1', 'reviews', 370, 'site', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Friends', '1', 'friends', 380, 'site', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('prints', '1', 'prints', 64, 'site', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('grid', '1', 'grid', 161, 'site', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('fixed width', '1', 'fixed_width', 162, 'site', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('sell prints only', '0', 'printsonly', 66, 'site', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('allow vector', '1', 'allow_vector', 60, 'site', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('vector preupload folder', '/content/vectorpreupload/', 'vectorpreupload', 335, 'site', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('credits', '1', 'credits', 78, 'site', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('download limit', '5', 'download_limit', 430, 'site', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('days till download expiration', '15', 'download_expiration', 440, 'site', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('catalog view by default', 'fixed_width', 'catalog_view', 160, 'site', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Download sample', '1', 'download_sample', 450, 'site', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Require Billing Address for the Order Checkout', '1', 'checkout_order_billing', 720, 'checkout', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Subscription', '1', 'subscription', 79, 'site', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Related items', '1', 'related_items', 480, 'site', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Content type as default', 'Common', 'content_type', 242, 'site', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Related items quantity', '10', 'related_items_quantity', 485, 'site', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Zoomer', '1', 'zoomer', 490, 'site', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('user uploads premoderation', '1', 'moderation', 77, 'site', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('prints for users', '1', 'prints_users', 65, 'site', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('model property release', '1', 'model', 510, 'site', 1)";
	$wpdb->query( $sql );


	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Seller examination', '1', 'examination', 77, 'site', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Items in Bulk Upload', '10', 'bulk_upload', 580, 'site', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('show model property release', '1', 'show_model', 515, 'site', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Google Coordinates', '1', 'google_coordinates', 585, 'site', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Google map <a href=http://code.google.com/intl/en/apis/maps/signup.html target=blank>API</a>', '', 'google_api', 590, 'site', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Show EXIF info', '1', 'exif', 595, 'site', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('affiliates', '1', 'affiliates', 74, 'site', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Subscription only', '0', 'subscription_only', 79, 'site', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Common account for buyers,sellers and affiliates', '1', 'common_account', 77, 'site', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Login as guest', '1', 'site_guest', 77, 'site', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Google <a href=https://www.google.com/recaptcha/admin/create target=blank>Captcha', '0', 'google_captcha', 600, 'site', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Google Captcha Public Key', '6LdEIxcUAAAAAKbimwnTRqbQLA-Xky5-aPeGywFE', 'google_captcha_public', 605, 'site', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Google Captcha Private Key', '6LdEIxcUAAAAAIQGpdpX_FM2b_SH8t1ToL4fRhSE', 'google_captcha_private', 610, 'site', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Java Photo Uploader', '1', 'java_uploader', 620, 'site', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Address', 'Your company name\r\n15 Noname St., 250\r\nLos Angeles 90210, USA\r\nTelephone: 1-675-234-56-78', 'company_address', 17, 'site', 0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Telephone', '1-234-765-4967', 'telephone', 18, 'site', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Facebook link', 'https://www.facebook.com/cmsaccount/', 'facebook_link', 22, 'site', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Google Plus link', '', 'google_link', 23, 'site', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Twitter link', 'https://twitter.com/cmsaccount/', 'twitter_link', 24, 'site', 0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Sorting of catalog', 'date', 'sorting_catalog', 81, 'site', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Simple Photo Uploader', '1', 'jquery_uploader', 631, 'site', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Seller may set prices', '1', 'seller_prices', 640, 'site', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Automatic language detection', '1', 'language_detection', 650, 'site', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Photo resolution in DPI', '300', 'resolution_dpi', 83, 'site', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Adult content', '1', 'adult_content', 82, 'site', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Category preview', '200', 'category_preview', 110, 'site', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Weight', 'lbs', 'weight', 660, 'site', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('auto paging by default', '1', 'auto_paging_default', 178, 'site', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('auto paging', '1', 'auto_paging', 177, 'site', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('CD weight', '0.01', 'cd_weight', 670, 'site', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Require Billing Address for the Credits Checkout', '0', 'checkout_credits_billing', 720, 'checkout', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Plupload Photo Uploader', '1', 'plupload_uploader', 632, 'site', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Only registered users may download free files', '1', 'auth_freedownload', 680, 'site', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Only registered users may set rating', '1', 'auth_rating', 690, 'site', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('multilingual option for categories', '1', 'multilingual_categories', 700, 'site', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Rights managed files', '1', 'rights_managed', 79, 'site', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Royalty free files', '1', 'royalty_free', 79, 'site', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Rights managed files for sellers', '1', 'rights_managed_sellers', 79, 'site', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Caching', '0', 'caching', 710, 'caching', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Image resize library', 'GD', 'image_resize', 83, 'site', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Video uploader', 'jquery uploader', 'video_uploader', 635, 'site', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Audio uploader', 'jquery uploader', 'audio_uploader', 636, 'site', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Vector uploader', 'jquery uploader', 'vector_uploader', 637, 'site', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('show content type in the search', '1', 'show_content_type', 243, 'site', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Photo uploader', 'jquery uploader', 'photo_uploader', 635, 'site', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('support', '1', 'support', 385, 'site', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('search history', '0', 'search_history', 82, 'site', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Preview fixed width', '200', 'width_flow', 164, 'site', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('How many free files a user may download per day', '100', 'daily_download_limit', 685, 'site', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Prints lab', '1', 'prints_lab', 67, 'site', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Prints lab photo size (MB)', '10', 'prints_lab_filesize', 68, 'site', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Require Billing Address for the Subscription Checkout', '1', 'checkout_subscription_billing', 720, 'checkout', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Exclusive price', '1', 'exclusive_price', 82, 'site', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Contact us to get the price', '1', 'contacts_price', 82, 'site', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Watermark photo', '/content/watermark.png', 'watermark_photo', 0, 'watermark', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Watermark position', '5', 'watermark_position', 0, 'watermark', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Affiliate buyer commission', '15', 'buyer_commission', 0, 'affiliate', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Affiliate seller commission', '10', 'seller_commission', 0, 'affiliate', 0)";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Rackspace', '0', 'rackspace', 0, 'rackspace', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Rackspace prefix', 'cmsaccount1', 'rackspace_prefix', 0, 'rackspace', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Rackspace username', 'cmsaccount', 'rackspace_username', 0, 'rackspace', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Rackspace API Key', 'test', 'rackspace_api_key', 0, 'rackspace', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Amazon S3', '0', 'amazon', 0, 'amazon', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Amazon S3 Prefix', 'cmsaccount4', 'amazon_prefix', 0, 'amazon', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Amazon S3 Username', 'test', 'amazon_username', 0, 'amazon', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Amazon S3 API Key', 'test', 'amazon_api_key', 0, 'amazon', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Amazon S3 Region', 'REGION_US_E1', 'amazon_region', 0, 'amazon', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Video width', '540', 'ffmpeg_video_width', 102, 'site', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('FFMPEG', '0', 'ffmpeg', 0, 'ffmpeg', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Payout price', '1', 'payout_price', 0, 'payout', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Video height', '400', 'ffmpeg_video_height', 103, 'site', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('FFMPEG path', '/usr/local/bin/ffmpeg', 'ffmpeg_path', 0, 'ffmpeg', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('FFMPEG thumb width', '120', 'ffmpeg_thumb_width', 0, 'ffmpeg', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('FFMPEG thumb height', '80', 'ffmpeg_thumb_height', 0, 'ffmpeg', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('FFMPEG frequency', '5', 'ffmpeg_frequency', 0, 'ffmpeg', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('FFMPEG duration', '10', 'ffmpeg_duration', 0, 'ffmpeg', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('FFMPEG video format ', 'flv', 'ffmpeg_video_format', 0, 'ffmpeg', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('FFMPEG watermark', '1', 'ffmpeg_watermark', 0, 'ffmpeg', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Sox', '0', 'sox', 0, 'sox', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Sox path', '/usr/local/bin/sox', 'sox_path', 0, 'sox', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Sox library', 'sox', 'sox_library', 0, 'sox', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Sox duration', '10', 'sox_duration', 0, 'sox', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Sox watermark', '1', 'sox_watermark', 0, 'sox', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Sox watermark file', '/content/watermark.mp3', 'sox_watermark_file', 0, 'sox', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('FFMPEG cron', '0', 'ffmpeg_cron', 0, 'ffmpeg', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('CCBill account', 'test', 'ccbill_account', 0, 'gateways', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Show left search panel in catalog', '1', 'left_search', 180, 'site', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Show left search panel in catalog by default', '1', 'left_search_default', 185, 'site', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Use credits and currency', '1', 'credits_currency', 78, 'site', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Show taxes in shopping cart', '1', 'taxes_cart', 730, 'site', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Prints previews', '1', 'prints_previews', 0, 'prints', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Targetpay account', '48501', 'targetpay_account', 0, 'gateways', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Targetpay active', '0', 'targetpay_active', 0, 'gateways', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Targetpay test', '1', 'targetpay_test', 0, 'gateways', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Hover view photo - max width/height', '400', 'max_hover_size', 135, 'site', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Yandex Shop ID', 'test', 'yandex_account', 0, 'gateways', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Yandex scid', 'test', 'yandex_account2', 0, 'gateways', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Yandex Shop password', 'test', 'yandex_password', 0, 'gateways', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Yandex active', '0', 'yandex_active', 0, 'gateways', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Yandex test mode', '1', 'yandex_test', 0, 'gateways', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Stats photo', '22', 'stats_photo', 0, 'stats', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Transferuj ID', 'test', 'transferuj_account', 0, 'gateways', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Transferuj password', 'test', 'transferuj_password', 0, 'gateways', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Transferuj active', '0', 'transferuj_active', 0, 'gateways', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Fotomoto Store ID', '', 'fotomoto_id', 0, 'prints', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Printful API Key', 'test', 'printful_api', 0, 'prints', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Printful order ID', '100', 'printful_order_id', 0, 'prints', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Printful mode', 'noconfirm', 'printful_mode', 0, 'prints', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('PayUMoney ID', 'JBZaLc', 'payumoney_account', 0, 'gateways', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('PayUMoney password', 'GQs7yium', 'payumoney_password', 0, 'gateways', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('PayUMoney active', '0', 'payumoney_active', 0, 'gateways', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('PayUMoney test mode', '1', 'payumoney_test', 0, 'gateways', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Checkout.fi ID', '375917', 'checkoutfi_account', 0, 'gateways', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Checkout.fi password', 'SAIPPUAKAUPPIAS', 'checkoutfi_password', 0, 'gateways', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Checkout.fi active', '0', 'checkoutfi_active', 0, 'gateways', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Stats video', '2', 'stats_video', 0, 'stats', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Stats audio', '2', 'stats_audio', 0, 'stats', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Stats vector', '3', 'stats_vector', 0, 'stats', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Stats users', '6', 'stats_users', 0, 'stats', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Not to calculate search count to decrease database loading', '0', 'no_calculation', 186, 'site', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Not to calculate search count and show more', '999', 'no_calculation_result', 187, 'site', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Not to calculate search count and set total quantity equal', '100000', 'no_calculation_total', 188, 'site', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Verotel Shop ID', 'test', 'verotel_account', 0, 'gateways', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Verotel password', 'test', 'verotel_password', 0, 'gateways', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Verotel active', '0', 'verotel_active', 0, 'gateways', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Invoice prefix', 'INV', 'invoice_prefix', 0, 'invoice', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Next invoice number', '10030', 'invoice_number', 0, 'invoice', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Credit notes prefix', 'CRN', 'credit_notes_prefix', 0, 'invoice', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Next credit notes number', '20002', 'credit_notes_number', 0, 'invoice', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Company name', 'My Company Inc.', 'company_name', 0, 'invoice', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Company address 1', '30 Orange St., 47', 'company_address1', 0, 'invoice', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Company address 2', 'Berlin 90210, Germany', 'company_address2', 0, 'invoice', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Country', 'Germany', 'company_country', 0, 'invoice', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('EU VAT Reg No', 'GB 12345678', 'company_vat_number', 0, 'invoice', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Invoice logo size', '200', 'invoice_logo_size', 0, 'invoice', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Balance threshold for payout', '100', 'payout_limit', 0, 'payout', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Shutterstock API', '1', 'shutterstock_api', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Shutterstock Client ID', 'bc62601140e2f0fd0f43', 'shutterstock_id', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Shutterstock Client Secret', '10f37e0c069e8058ab8db97d703649f0062d1725', 'shutterstock_secret', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Fotolia API', '1', 'fotolia_api', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Fotolia API Key', 'VxWsSMXAbDmkNM4LKoT7QnLr6lntuM1F', 'fotolia_id', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('IStockphoto API', '1', 'istockphoto_api', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('IStockphoto Key', 'dz892kh3m4qqeyy6bhaw3rp8', 'istockphoto_id', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('IStockphoto Secret', 'eKEQHzkrp3aJmd89xFjs2duQd3wsDDMmd4n8qhMn8US48', 'istockphoto_secret', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Depositphotos API', '1', 'depositphotos_api', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Depositphotos  API Key', '4e98ede20c7ed09ef09a8e500da23d98647a8544', 'depositphotos_id', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('123rf API', '1', 'rf123_api', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('123rf Key', '26b7fd32da0ebca772c41c5664464f59', 'rf123_id', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('123rf Secret', '01e9fa82cf6fa4', 'rf123_secret', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Default media stock', 'site', 'stock_default', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Show site stock', '1', 'site_api', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Create internal pages for files', '1', 'shutterstock_pages', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Shutterstock Affiliate ID', 'http://shutterstock.7eer.net/c/202194/42119/1305', 'shutterstock_affiliate', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Shutterstock Contributor', '', 'shutterstock_contributor', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Fotolia Contributor', '', 'fotolia_contributor', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Shutterstock Category', '-1', 'shutterstock_category', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Create internal pages for files', '1', 'fotolia_pages', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Fotolia query', 'people', 'fotolia_query', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Fotolia Category', '-1', 'fotolia_category', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Fotolia account ID', '205927285', 'fotolia_account', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Istockphoto Contributor', '', 'istockphoto_contributor', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Create internal pages for files', '1', 'istockphoto_pages', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Istockphoto site', 'gettyimages', 'istockphoto_site', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Istockphoto query', 'people', 'istockphoto_query', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Istockphoto affiliate link', '{URL}', 'istockphoto_affiliate', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Create internal pages for files', '1', 'depositphotos_pages', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Depositphotos Affiliate URL', 'http://tracking.depositphotos.com/aff_c?offer_id=4&amp;aff_id=9914&amp;url={URL_ENCODED}%3Faff%3D9914', 'depositphotos_affiliate', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Depositphotos Contributor', '', 'depositphotos_contributor', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Depositphotos Category', '22', 'depositphotos_category', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Bigstockphoto API', '1', 'bigstockphoto_api', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Bigstockphoto  API Key', '233490', 'bigstockphoto_id', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Create internal pages for files', '1', 'bigstockphoto_pages', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Bigstockphoto Affiliate URL', '{URL}', 'bigstockphoto_affiliate', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Bigstockphoto Contributor', '', 'bigstockphoto_contributor', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Bigstockphoto Category', 'Animals', 'bigstockphoto_category', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Create internal pages for files', '1', 'rf123_pages', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('rf123 Affiliate URL', '{URL}_resh_cmsaccount', 'rf123_affiliate', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('rf123 Contributor', '', 'rf123_contributor', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('rf123 Category', '-1', 'rf123_category', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('rf123 query', 'people', 'rf123_query', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Seller may set balance threshold for payout', '1', 'payout_set', 0, 'payout', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Last photo ID', '7873', 'cron_photos', 0, 'cron', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('IStockphoto Prints', '1', 'istockphoto_prints', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Shutterstock Prints', '1', 'shutterstock_prints', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Fotolia Prints', '1', 'fotolia_prints', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Depositphotos Prints', '1', 'depositphotos_prints', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Bigstockphoto Prints', '1', 'bigstockphoto_prints', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('123RF Prints', '1', 'rf123_prints', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('IStockphoto Files', '1', 'istockphoto_files', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Shutterstock files', '1', 'shutterstock_files', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Fotolia files', '1', 'fotolia_files', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Depositphotos files', '1', 'depositphotos_files', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Bigstockphoto files', '1', 'bigstockphoto_files', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('123RF files', '1', 'rf123_files', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('IStockphoto show files/prints by default', '1', 'istockphoto_show', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Shutterstock show files/prints by default', '1', 'shutterstock_show', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Fotolia show files/prints by default', '1', 'fotolia_show', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Depositphotos show files/prints by default', '1', 'depositphotos_show', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Bigstockphoto show files/prints by default', '1', 'bigstockphoto_show', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('123RF show files/prints by default', '1', 'rf123_show', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('multilingual option for publications', '1', 'multilingual_publications', 705, 'site', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Users rating', '1', 'users_rating', 695, 'site', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Only registered users may rate other users', '1', 'users_rating_limited', 696, 'site', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Apply EU tax rules', '1', 'eu_tax', 0, 'eu_tax', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Allow B2B sales only', '0', 'eu_tax_b2b', 0, 'eu_tax', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Commission from net price', '1', 'eu_tax_commission', 0, 'eu_tax', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Payout with VAT', '0', 'eu_tax_payout', 0, 'eu_tax', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Publish invoice', '0', 'invoice_publish', 0, 'invoice', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Max price in catalog', '150', 'max_price', 189, 'site', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Pixabay API', '1', 'pixabay_api', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Pixabay API key', '3775320-00cac0e195c5ea041d9335786', 'pixabay_id', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Create internal pages for files', '1', 'pixabay_pages', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Pixabay Category', '-1', 'pixabay_category', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Pixabay Prints', '1', 'pixabay_prints', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Pixabay files', '1', 'pixabay_files', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Pixabay show files/prints by default', '1', 'pixabay_show', 0, 'stockapi', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Paystack public key', 'test1', 'paystack_account', 0, 'gateways', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Paystack private key', 'test2', 'paystack_password', 0, 'gateways', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Paystack active', '0', 'paystack_active', 0, 'gateways', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Bitpay API key', 'g7dzBwM30NibprLF7LzhjNjSoHEmfzEsB11yWr5Y8d4', 'bitpay_account', 0, 'gateways', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Bitpay test', '1', 'bitpay_test', 0, 'gateways', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Bitpay active', '0', 'bitpay_active', 0, 'gateways', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Paygate public key', '10011072130', 'paygate_account', 0, 'gateways', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Paygate private key', 'secret', 'paygate_password', 0, 'gateways', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Paygate active', '0', 'paygate_active', 0, 'gateways', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('CCBill subaccount', 'test', 'ccbill_subaccount', 0, 'gateways', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('CCBill form', 'test', 'ccbill_form', 0, 'gateways', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('CCBill salt', 'test', 'ccbill_password', 0, 'gateways', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('CCBill active', '0', 'ccbill_active', 0, 'gateways', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('CCBill Flex form', '1', 'ccbill_flexform', 0, 'gateways', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Create thumbs for preview', '1', 'prints_previews_thumb', 0, 'prints', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Prints thumbs width', '800', 'prints_previews_width', 0, 'prints', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('JVZoo password', 'test', 'jvzoo_password', 0, 'gateways', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('JVZoo active', '0', 'jvzoo_active', 0, 'gateways', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('JVZoo account', 'test', 'jvzoo_account', 0, 'gateways', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Clarifai', '0', 'clarifai', 0, 'clarifai', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Clarifai Key', '', 'clarifai_key', 0, 'clarifai', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Clarifai Secure key', '', 'clarifai_password', 0, 'clarifai', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Clarifai Model', 'general-v1.3', 'clarifai_model', 0, 'clarifai', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Clarifai language', 'en', 'clarifai_language', 0, 'clarifai', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('QIWI account', 'test', 'qiwi_account', 0, 'gateways', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('QIWI API ID', 'test', 'qiwi_account2', 0, 'gateways', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('QIWI active', '0', 'qiwi_active', 0, 'gateways', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('QIWI password', 'test', 'qiwi_password', 0, 'gateways', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('QIWI notification password', 'test', 'qiwi_password2', 0, 'gateways', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Midtrans client key', 'test', 'midtrans_account', 0, 'gateways', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Midtrans server key', 'test', 'midtrans_password', 0, 'gateways', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Midtrans active', '0', 'midtrans_active', 0, 'gateways', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Google reCaptcha. I am not a robot', '0', 'google_recaptcha', 603, 'site', 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Midtrans test', '1', 'midtrans_test', 0, 'gateways', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Twitter', '1', 'auth_twitter', 0, 'auth', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Twitter Public Key', 'snlPXUlvzPHkzR1Kyv4MMA', 'auth_twitter_key', 0, 'auth', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Twitter Secret Key', '9feJCd6CnezgKwi17Onu3MUppCanxleS6kezR2nqAs', 'auth_twitter_secret', 0, 'auth', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Facebook', '1', 'auth_facebook', 0, 'auth', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Facebook Public Key', '', 'auth_facebook_key', 0, 'auth', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Facebook Secret Key', '', 'auth_facebook_secret', 0, 'auth', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Vkontakte', '1', 'auth_vkontakte', 0, 'auth', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Vkontakte Public Key', '', 'auth_vkontakte_key', 0, 'auth', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Vkontakte Secret Key', '', 'auth_vkontakte_secret', 0, 'auth', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Instagram', '1', 'auth_instagram', 0, 'auth', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Instagram Public Key', '', 'auth_instagram_key', 0, 'auth', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Instagram Secret Key', '', 'auth_instagram_secret', 0, 'auth', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Google auth', '1', 'auth_google', 0, 'auth', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Google auth Public Key', '', 'auth_google_key', 0, 'auth', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Google auth Secret Key', '', 'auth_google_secret', 0, 'auth', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Yandex auth', '1', 'auth_yandex', 0, 'auth', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Yandex auth Public Key', '', 'auth_yandex_key', 0, 'auth', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Yandex auth Secret Key', '', 'auth_yandex_secret', 0, 'auth', 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Subscription limit', 'Credits', 'subscription_limit', 0, 'subscription',0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Imagga', '0', 'imagga', 0, 'imagga',1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Imagga Key', '', 'imagga_key', 0, 'imagga',0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Imagga Secure key', '', 'imagga_password', 0, 'imagga',0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Imagga language', 'en', 'imagga_language', 0, 'imagga',0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Show quantity in stock', '1', 'show_in_stock', 70, 'site',1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Show prints not in stock', '1', 'show_not_in_stock', 71, 'site',1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Seller may set prints quantity', '0', 'seller_prints_quantity', 72, 'site',1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Not to create previews during upload to accelerate the process', '0', 'upload_previews', 105, 'site',1)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Show colors', '1', 'show_colors', 592, 'site',1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Number of colors', '6', 'colors_number', 593, 'site',0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Collections', '1', 'collections', 80, 'site',1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Category view', 'grid', 'category_view', 111, 'site',0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Show items number in the categories', '1', 'category_items', 112, 'site',1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Category sorting', 'title', 'category_sort', 113, 'site',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('terms and conditions', '0', 'upload_terms', 640, 'site',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Signup agreement', '0', 'signup_terms', 0, 'signup',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Default wordpress links for signup', '0', 'wordpress_signup', 700, 'site',1)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Paypal account', '', 'paypal_account', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Paypal IPN', '1', 'paypal_ipn', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Paypal active', '0', 'paypal_active', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Paypal PRO account', '', 'paypalpro_account', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Paypal PRO password', '', 'paypalpro_password', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Paypal PRO signature', '', 'paypalpro_signature', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Paypal PRO active', '0', 'paypalpro_active', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Authorize account', '', 'authorize_account', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Authorize IPN', '1', 'authorize_ipn', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Authorize password', '', 'authorize_password', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Authorize active', '0', 'authorize_active', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('2checkout account', '', '2checkout_account', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('2checkout IPN', '1', '2checkout_ipn', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('2checkout password', '', '2checkout_password', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('2checkout active', '0', '2checkout_active', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Worldpay account', '', 'worldpay_account', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Worldpay IPN', '1', 'worldpay_ipn', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Worldpay password', '', 'worldpay_password', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Worldpay active', '0', 'worldpay_active', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Chronopay account', '', 'chronopay_account', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Chronopay IPN', '1', 'chronopay_ipn', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Chronopay password', '', 'chronopay_password', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Chronopay active', '0', 'chronopay_active', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Skrill account', '', 'skrill_account', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Skrill IPN', '1', 'skrill_ipn', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Skrill password', '', 'skrill_password', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Skrill active', '0', 'skrill_active', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Nochex account', '', 'nochex_account', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Nochex IPN', '1', 'nochex_ipn', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Nochex password', '', 'nochex_password', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Nochex active', '0', 'nochex_active', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('eWay account', '', 'eway_account', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('eWay IPN', '1', 'eway_ipn', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('eWay password', '', 'eway_password', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('eWay active', '0', 'eway_active', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('eNETS account', '', 'enets_account', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('eNETS IPN', '1', 'enets_ipn', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('eNETS password', '', 'enets_password', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('eNETS active', '0', 'enets_active', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Segpay account', '', 'segpay_account', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Segpay IPN', '1', 'segpay_ipn', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Segpay password', '', 'segpay_password', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Segpay active', '0', 'segpay_active', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Google Checkout account', '', 'google_account', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Google Checkout IPN', '1', 'google_ipn', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Google Checkout password', '', 'google_password', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Google Checkout active', '0', 'google_active', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('CashU account', '', 'cashu_account', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('CashU IPN', '1', 'cashu_ipn', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('CashU password', '', 'cashu_password', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('CashU active', '0', 'cashu_active', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Webmoney account', '', 'webmoney_account', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Webmoney IPN', '1', 'webmoney_ipn', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Webmoney password', '', 'webmoney_password', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Webmoney active', '0', 'webmoney_active', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Epoch account', '', 'epoch_account', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Epoch IPN', '1', 'epoch_ipn', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Epoch active', '0', 'epoch_active', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Multicards account', '', 'multicards_account', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Multicards account 2', '', 'multicards_account2', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Multicards IPN', '1', 'multicards_ipn', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Multicards password', '', 'multicards_password', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Multicards active', '0', 'multicards_active', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('ClickBank account', '', 'clickbank_account', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('ClickBank account2', '', 'clickbank_account2', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('ClickBank IPN', '1', 'clickbank_ipn', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('ClickBank active', '0', 'clickbank_active', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Alertpay account', '', 'alertpay_account', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Alertpay IPN', '1', 'alertpay_ipn', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Alertpay password', '', 'alertpay_password', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Alertpay active', '0', 'alertpay_active', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Epay.bg account', '', 'epay_account', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Epay.bg IPN', '1', 'epay_ipn', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Epay.bg password', '', 'epay_password', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Epay.bg active', '0', 'epay_active', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('MyVirtualMerchant account', '', 'myvirtualmerchant_account', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('MyVirtualMerchant account 2', '', 'myvirtualmerchant_account2', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('MyVirtualMerchant IPN', '1', 'myvirtualmerchant_ipn', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('MyVirtualMerchant password', '', 'myvirtualmerchant_password', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('MyVirtualMerchant active', '0', 'myvirtualmerchant_active', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Fortumo account', '', 'fortumo_account', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Fortumo password', '', 'fortumo_password', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Fortumo active', '0', 'fortumo_active', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Zombaio account', '', 'zombaio_account', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Zombaio account 2', '', 'zombaio_account2', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Zombaio password', '', 'zombaio_password', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Zombaio active', '0', 'zombaio_active', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Pagseguro account', '', 'pagseguro_account', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Pagseguro password', '', 'pagseguro_password', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Pagseguro active', '0', 'pagseguro_active', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Robokassa account', '', 'robokassa_account', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Robokassa password', '', 'robokassa_password', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Robokassa password2', '', 'robokassa_password2', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Robokassa active', '0', 'robokassa_active', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('RBK Money account', '', 'rbkmoney_account', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('RBK Money password', '', 'rbkmoney_password', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('RBK Money active', '0', 'rbkmoney_active', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Epay.kkb.kz account', '', 'epaykkbkz_active', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('PayPrin account', '', 'payprin_account', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('PayPrin password', '', 'payprin_password', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('PayPrin active', '0', 'payprin_active', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Dwolla account', '', 'dwolla_account', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Dwolla password', '', 'dwolla_password', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Dwolla password 2', '', 'dwolla_password2', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Dwolla password 3', '', 'dwolla_password3', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Dwolla active', '0', 'dwolla_active', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Dwolla test', '0', 'dwolla_test', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Stripe account', '', 'stripe_account', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Stripe password', '', 'stripe_password', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Stripe active', '0', 'stripe_active', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Money.ua account', '', 'moneyua_account', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Money.ua password', '', 'moneyua_password', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Money.ua active', '0', 'moneyua_active', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Money.ua test', '0', 'moneyua_test', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Money.ua commission', '0', 'moneyua_commission', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Privatbank account', '', 'privatbank_account', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Privatbank password', '', 'privatbank_password', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Privatbank active', '0', 'privatbank_active', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Paysera account', '', 'paysera_account', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Paysera password', '', 'paysera_password', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Paysera active', '0', 'paysera_active', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Dotpay account', '', 'dotpay_account', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Dotpay password', '', 'dotpay_password', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Dotpay active', '0', 'dotpay_active', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('PayU account', '', 'payu_account', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('PayU password', '', 'payu_password', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('PayU password2', '', 'payu_password2', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('PayU password3', '', 'payu_password3', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('PayU active', '0', 'payu_active', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Paxum account', '', 'paxum_account', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Paxum password', '', 'paxum_password', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Paxum active', '0', 'paxum_active', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('NMI account', '', 'nmi_account', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('NMI password', '', 'nmi_password', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('NMI active', '0', 'nmi_active', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Payfast account', '', 'payfast_account', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Payfast password', '', 'payfast_password', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Payfast active', '0', 'payfast_active', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('InetCash account', '', 'inetcash_account', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('InetCash password', '', 'inetcash_password', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('InetCash active', '0', 'inetcash_active', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('GoPay account', '', 'gopay_account', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('GoPay password', '', 'gopay_password', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('GoPay active', '0', 'gopay_active', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('GoPay test', '0', 'gopay_test', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('CCAvenue account', '', 'ccavenue_account', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('CCAvenue password', '', 'ccavenue_password', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('CCAvenue password2', '', 'ccavenue_password2', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('CCAvenue active', '0', 'ccavenue_active', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('GoEMerchant account', '', 'goemerchant_account', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('GoEMerchant account2', '', 'goemerchant_account2', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('GoEMerchant password', '', 'goemerchant_password', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('GoEMerchant active', '0', 'goemerchant_active', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Mollie account', '', 'mollie_account', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Mollie password', '', 'mollie_password', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Mollie active', '0', 'mollie_active', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Payson account', '', 'payson_account', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Payson account2', '', 'payson_account2', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Payson password', '', 'payson_password', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Payson active', '0', 'payson_active', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Victoriabank account', '', 'victoriabank_account', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Victoriabank account2', '', 'victoriabank_account2', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Victoriabank active', '0', 'victoriabank_active', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Webpay account', '', 'webpay_account', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Webpay account2', '', 'webpay_account2', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Webpay password', '', 'webpay_password', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Webpay password2', '', 'webpay_password2', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Webpay active', '0', 'webpay_active', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Webpay test', '0', 'webpay_test', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Mellat account', '', 'mellatbank_account', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Mellat account2', '', 'mellatbank_account2', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Mellat password', '', 'mellatbank_password', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Mellat active', '0', 'mellatbank_active', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Cheque or money order', 'Cheque or money order', 'cheque_account', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Cheque or money order description', '0', 'cheque_account2', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Cheque or money order active', '0', 'cheque_active', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Coinpayments account', '', 'coinpayments_account', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Coinpayments password', '', 'coinpayments_password', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Coinpayments active', '0', 'coinpayments_active', 0, 'gateways',0)";
	$wpdb->query( $sql );
	
		
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Backblaze B2', '', 'backblaze', 0, 'backblaze',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Backblaze B2 Prefix', '', 'backblaze_prefix', 0, 'backblaze',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Backblaze Access Key', '0', 'backblaze_username', 0, 'backblaze',0)";
	$wpdb->query( $sql );
			
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Backblaze Secret Key', '', 'backblaze_api_key', 0, 'backblaze',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Backblaze bucket preview', '', 'backblaze_preview', 0, 'backblaze',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Backblaze bucket files', '0', 'backblaze_files', 0, 'backblaze',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Lightboxes', '1', 'lightboxes', 86, 'site',1)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Invoices', '1', 'invoices', 85, 'site',1)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Examination description', '0', 'examination_description', 78, 'site',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Examination result', '0', 'examination_result', 78, 'site',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('API key', '', 'api_key', 0, 'api',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('API secret', '', 'api_secret', 0, 'api',0)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"settings` (name, svalue,setting_key, priority, stype	, checkboxes) values ('Activation', '0', 'activation', 0, 'api',0)";
	$wpdb->query( $sql );
}

//shipping
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "shipping'" ) !=
	PVS_DB_PREFIX . 'shipping' )
{

	$sql = "CREATE TABLE `" . PVS_DB_PREFIX . "shipping` (
	  `id` int(11) NOT NULL auto_increment,
	  `title` varchar(100) default NULL,
	  `shipping_time` varchar(100) default NULL,
	  `activ` tinyint(4) default NULL,
	  `methods` varchar(100) default NULL,
	  `methods_calculation` varchar(100) default NULL,
	  `taxes` tinyint(4) default NULL,
	  `regions` tinyint(4) default NULL,
	  `weight_min` int(11) default NULL,
	  `weight_max` int(11) default NULL,
	  PRIMARY KEY  (`id`),
	  KEY `activ` (`activ`),
	  KEY `weight_max` (`weight_max`),
	  KEY `weight_min` (`weight_min`)
	)";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"shipping` VALUES(8, 'DHL/Airborne', '2-3 days', 1, 'weight', 'currency', 1, 0, 0, 1000)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"shipping` VALUES(6, 'UPS', '3-5 days', 1, 'weight', 'currency', 0, 0, 0, 100)";
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'shipping` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//shipping_ranges
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "shipping_ranges'" ) !=
	PVS_DB_PREFIX . 'shipping_ranges' )
{

	$sql = "CREATE TABLE `" . PVS_DB_PREFIX . "shipping_ranges` (
	  `id` int(11) NOT NULL auto_increment,
	  `id_parent` int(11) default NULL,
	  `price` float default NULL,
	  `from_param` float default NULL,
	  `to_param` float default NULL,
	  PRIMARY KEY  (`id`),
	  KEY `id_parent` (`id_parent`),
	  KEY `to_param` (`to_param`),
	  KEY `from_param` (`from_param`)
	)";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"shipping_ranges` VALUES(86, 8, 75, 100, 1e+06)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"shipping_ranges` VALUES(41, 6, 3, 2, 3)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"shipping_ranges` VALUES(40, 6, 2, 1, 2)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"shipping_ranges` VALUES(39, 6, 1, 0, 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"shipping_ranges` VALUES(85, 8, 50, 0, 100)";
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'shipping_ranges` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//shipping_regions
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "shipping_regions'" ) !=
	PVS_DB_PREFIX . 'shipping_regions' )
{

	$sql = "CREATE TABLE `" . PVS_DB_PREFIX . "shipping_regions` (
	  `id` int(11) NOT NULL auto_increment,
	  `id_parent` int(11) default NULL,
	  `country` varchar(250) default NULL,
	  `state` varchar(250) default NULL,
	  PRIMARY KEY  (`id`),
	  KEY `id_parent` (`id_parent`),
	  KEY `country` (`country`),
	  KEY `state` (`state`)
	)";
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'shipping_regions` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//sizes
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "sizes'" ) !=
	PVS_DB_PREFIX . 'sizes' )
{

	$sql = "CREATE TABLE `" . PVS_DB_PREFIX . "sizes` (
	  `id_parent` int(11) NOT NULL auto_increment,
	  `size` int(11) default NULL,
	  `description` varchar(200) default NULL,
	  `price` float default NULL,
	  `priority` int(11) default NULL,
	  `title` varchar(200) default NULL,
	  `license` int(10) NOT NULL,
	  `watermark` tinyint(1) default NULL,
	  `jpg` tinyint(4) default NULL,
	  `png` tinyint(4) default NULL,
	  `gif` tinyint(4) default NULL,
	  `raw` tinyint(4) default NULL,
	  `tiff` tinyint(4) default NULL,
	  `eps` tinyint(4) default NULL,
	  KEY `license` (`license`),
	  KEY `id_parent` (`id_parent`),
	  KEY `priority` (`priority`)
	)";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"sizes` VALUES(1005, 0, NULL, 125, 4, 'Electronic Items for Resale (unlimited run)', 4584, 0, 1, 0, 0, 0, 0, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"sizes` VALUES(1006, 0, NULL, 125, 3, 'Items for Resale (limited run)', 4584, 0, 1, 0, 0, 0, 0, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"sizes` VALUES(1007, 0, NULL, 125, 2, 'Unlimited Reproduction / Print Runs', 4584, 0, 1, 0, 0, 0, 0, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"sizes` VALUES(1008, 0, NULL, 75, 1, 'Multi-Seat (unlimited)', 4584, 0, 1, 0, 0, 0, 0, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"sizes` VALUES(1004, 0, NULL, 4, 4, 'Original size', 4583, 0, 1, 0, 0, 0, 0, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"sizes` VALUES(1003, 900, NULL, 3, 3, 'Large', 4583, 0, 1, 0, 0, 0, 0, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"sizes` VALUES(1001, 500, NULL, 0, 1, 'Small Free', 4583, 1, 1, 0, 0, 0, 0, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"sizes` VALUES(1002, 800, NULL, 2, 2, 'Medium', 4583, 0, 1, 0, 0, 0, 0, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"sizes` VALUES(1009, 0, NULL, 100, 5, 'Extended Legal Guarantee covers up to $250,000', 4584, 0, 1, 0, 0, 0, 0, 0)";
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'sizes` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//subscription
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "subscription'" ) !=
	PVS_DB_PREFIX . 'subscription' )
{

	$sql = "CREATE TABLE `" . PVS_DB_PREFIX . "subscription` (
	  `id_parent` int(11) NOT NULL auto_increment,
	  `title` varchar(200) default NULL,
	  `price` float default NULL,
	  `days` int(11) default NULL,
	  `content_type` varchar(200) default NULL,
	  `bandwidth` int(20) default NULL,
	  `priority` int(11) default NULL,
	  `recurring` tinyint(4) default NULL,
	  `bandwidth_daily` int(11) default NULL,
	  KEY `id_parent` (`id_parent`),
	  KEY `content_type` (`content_type`),
	  KEY `bandwidth` (`bandwidth`),
	  KEY `days` (`days`),
	  KEY `priority` (`priority`)
	)";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"subscription` VALUES(1, '1 day instant access', 10, 1, 'Common', 15, 1, 1, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"subscription` VALUES(2, '1 month instant access', 100, 30, 'Common', 200, 2, 1, 10)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"subscription` VALUES(3, '1 day instant premium access', 50, 1, 'Common|Premium', 20, 3, 1, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"subscription` VALUES(4, '1 month instant premium access', 300, 30, 'Common|Premium', 250, 4, 1, 10)";
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'subscription` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//subscription_list
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "subscription_list'" ) !=
	PVS_DB_PREFIX . 'subscription_list' )
{

	$sql = "CREATE TABLE `" . PVS_DB_PREFIX . "subscription_list` (
	  `id_parent` int(11) NOT NULL auto_increment,
	  `title` varchar(200) default NULL,
	  `user` varchar(200) default NULL,
	  `data1` int(11) default NULL,
	  `data2` int(11) default NULL,
	  `bandwidth` double default NULL,
	  `bandwidth_limit` int(40) default NULL,
	  `subscription` int(11) default NULL,
	  `approved` int(11) default NULL,
	  `subtotal` float default NULL,
	  `discount` float default NULL,
	  `taxes` float default NULL,
	  `total` float default NULL,
	  `billing_firstname` varchar(250) default NULL,
	  `billing_lastname` varchar(250) default NULL,
	  `billing_address` varchar(250) default NULL,
	  `billing_city` varchar(250) default NULL,
	  `billing_zip` varchar(250) default NULL,
	  `billing_country` varchar(250) default NULL,
	  `recurring` tinyint(4) default NULL,
	  `subscr_id` varchar(19) default NULL,
	  `payments` int(11) default NULL,
	  `recurring_data` int(11) default NULL,
	  `bandwidth_daily` int(11) default NULL,
	  `bandwidth_daily_limit` int(11) default NULL,
	  `bandwidth_date` int(11) default NULL,
	  `billing_state` varchar(250) default NULL,
	  `taxes_id` int(11) default NULL,
	  `billing_company` varchar(100) default NULL,
	  `billing_vat` varchar(40) default NULL,
	  `billing_business` tinyint(4) default NULL,
	  KEY `id_parent` (`id_parent`),
	  KEY `user` (`user`),
	  KEY `data1` (`data1`),
	  KEY `data2` (`data2`),
	  KEY `bandwidth` (`bandwidth`),
	  KEY `bandwidth_limit` (`bandwidth_limit`),
	  KEY `subscription` (`subscription`)
	)";
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'subscription_list` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//support
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "support'" ) !=
	PVS_DB_PREFIX . 'support' )
{

	$sql = "CREATE TABLE `" . PVS_DB_PREFIX . "support` (
	  `id_parent` int(11) NOT NULL auto_increment,
	  `name` varchar(200) default NULL,
	  `email` varchar(200) default NULL,
	  `telephone` varchar(200) default NULL,
	  `question` text,
	  `username` varchar(200) default NULL,
	  `status` varchar(200) default NULL,
	  `data` int(11) default NULL,
	  `method` varchar(200) default NULL,
	  KEY `id_parent` (`id_parent`),
	  KEY `data` (`data`)
	)";
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'support` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//support_tickets
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "support_tickets'" ) !=
	PVS_DB_PREFIX . 'support_tickets' )
{

	$sql = "CREATE TABLE `" . PVS_DB_PREFIX . "support_tickets` (
	  `id` int(11) NOT NULL auto_increment,
	  `id_parent` int(11) default NULL,
	  `admin_id` int(11) default NULL,
	  `user_id` int(11) default NULL,
	  `message` text,
	  `data` int(11) default NULL,
	  `viewed_admin` tinyint(4) default NULL,
	  `viewed_user` tinyint(4) default NULL,
	  `rating` float default NULL,
	  `closed` tinyint(4) default NULL,
	  `subject` varchar(250) default NULL,
	  PRIMARY KEY  (`id`),
	  KEY `id_parent` (`id_parent`),
	  KEY `admin_id` (`admin_id`),
	  KEY `user_id` (`user_id`),
	  KEY `data` (`data`)
	)";
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'support_tickets` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//tax
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "tax'" ) !=
	PVS_DB_PREFIX . 'tax' )
{

	$sql = "CREATE TABLE `" . PVS_DB_PREFIX . "tax` (
	  `id` int(11) NOT NULL auto_increment,
	  `title` varchar(100) default NULL,
	  `rates_depend` int(11) default NULL,
	  `price_include` int(11) default NULL,
	  `rate_all` float default NULL,
	  `rate_all_type` int(11) default NULL,
	  `enabled` int(11) default NULL,
	  `regions` int(11) default NULL,
	  `files` tinyint(4) default NULL,
	  `credits` tinyint(4) default NULL,
	  `subscription` tinyint(4) default NULL,
	  `customer` int(11) default NULL,
	  `prints` tinyint(4) default NULL,
	  PRIMARY KEY  (`id`)
	)";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"tax` VALUES(10, 'VAT', 2, 0, 19, 1, 1, 1, 1, 1, 1, 0, 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"tax` VALUES(14, 'VAT', 2, 0, 17, 1, 1, 1, 1, 1, 1, 0, 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"tax` VALUES(12, 'VAT', 2, 0, 21, 1, 1, 1, 1, 1, 1, 0, 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"tax` VALUES(13, 'VAT', 2, 0, 20, 1, 1, 1, 1, 1, 1, 0, 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"tax` VALUES(15, 'VAT', 2, 0, 18, 1, 1, 1, 1, 1, 1, 0, 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"tax` VALUES(16, 'VAT', 2, 0, 22, 1, 1, 1, 1, 1, 1, 0, 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"tax` VALUES(17, 'VAT', 2, 0, 23, 1, 1, 1, 1, 1, 1, 0, 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"tax` VALUES(18, 'VAT', 2, 0, 24, 1, 1, 1, 1, 1, 1, 0, 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"tax` VALUES(19, 'VAT', 2, 0, 25, 1, 1, 1, 1, 1, 1, 0, 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"tax` VALUES(20, 'VAT', 2, 0, 27, 1, 1, 1, 1, 1, 1, 0, 1)";
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'tax` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//tax_regions
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "tax_regions'" ) !=
	PVS_DB_PREFIX . 'tax_regions' )
{

	$sql = "CREATE TABLE `" . PVS_DB_PREFIX . "tax_regions` (
	  `id` int(11) NOT NULL auto_increment,
	  `id_parent` int(11) default NULL,
	  `country` varchar(250) default NULL,
	  `state` varchar(250) default NULL,
	  PRIMARY KEY  (`id`),
	  KEY `id_parent` (`id_parent`),
	  KEY `country` (`country`),
	  KEY `state` (`state`)
	)";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"tax_regions` VALUES(70, 13, 'United Kingdom', '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"tax_regions` VALUES(74, 12, 'Lithuania', '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"tax_regions` VALUES(69, 13, 'Slovakia', '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"tax_regions` VALUES(64, 10, 'Germany', '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"tax_regions` VALUES(68, 13, 'France', '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"tax_regions` VALUES(67, 13, 'Estonia', '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"tax_regions` VALUES(66, 13, 'Bulgaria', '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"tax_regions` VALUES(65, 13, 'Austria', '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"tax_regions` VALUES(63, 10, 'Cyprus', '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"tax_regions` VALUES(73, 12, 'Latvia', '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"tax_regions` VALUES(72, 12, 'Czech Republic', '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"tax_regions` VALUES(71, 12, 'Belgium', '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"tax_regions` VALUES(61, 14, 'Luxembourg', '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"tax_regions` VALUES(62, 15, 'Malta', '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"tax_regions` VALUES(78, 16, 'Slovenia', '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"tax_regions` VALUES(77, 16, 'Italy', '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"tax_regions` VALUES(82, 17, 'Portugal', '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"tax_regions` VALUES(81, 17, 'Poland', '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"tax_regions` VALUES(80, 17, 'Ireland', '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"tax_regions` VALUES(88, 18, 'Romania', '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"tax_regions` VALUES(87, 18, 'Finland', '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"tax_regions` VALUES(86, 19, 'Sweden', '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"tax_regions` VALUES(85, 19, 'Denmark', '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"tax_regions` VALUES(84, 19, 'Croatia', '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"tax_regions` VALUES(83, 20, 'Hungary', '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"tax_regions` VALUES(79, 17, 'Greece', '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"tax_regions` VALUES(75, 12, 'Netherlands', '')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"tax_regions` VALUES(76, 12, 'Spain', '')";
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'tax_regions` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}


//templates_admin_home
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "templates_admin_home'" ) != PVS_DB_PREFIX . 'templates_admin_home' )
{

	$sql = "CREATE TABLE `" . PVS_DB_PREFIX . "templates_admin_home` (
	  `id` int(11) NOT NULL auto_increment,
	  `title` varchar(100) default NULL,
	  `left_right` tinyint(4) default NULL,
	  `activ` tinyint(1) default NULL,
	  `priority` int(11) default NULL,
	  PRIMARY KEY  (`id`)
	)";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "templates_admin_home` VALUES(1, 'Sales', 0, 1, 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "templates_admin_home` VALUES(2, 'Orders', 0, 1, 2)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "templates_admin_home` VALUES(3, 'New Orders', 0, 1, 3)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "templates_admin_home` VALUES(4, 'Credits', 0, 1, 4)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "templates_admin_home` VALUES(5, 'New Credits', 0, 1, 5)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "templates_admin_home` VALUES(6, 'Subscription', 0, 1, 6)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "templates_admin_home` VALUES(7, 'New Subscription', 0, 1, 7)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "templates_admin_home` VALUES(8, 'New Users', 1, 1, 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "templates_admin_home` VALUES(9, 'New Comments', 1, 1, 2)";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "templates_admin_home` VALUES(11, 'Last Downloads', 1, 1, 4)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "templates_admin_home` VALUES(12, 'Last Uploads', 1, 1, 4)";
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'templates_admin_home` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}



//terms
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "terms'" ) !=
	PVS_DB_PREFIX . 'terms' )
{

	$sql = "CREATE TABLE `" . PVS_DB_PREFIX . "terms` (
	  `id` int(11) NOT NULL auto_increment,
	  `types` int(11) default NULL,
	  `title` varchar(250) default NULL,
	  `page_id` int(11) default NULL,
	  `priority` int(11) default NULL,
	  PRIMARY KEY  (`id`),
	  KEY `priority` (`priority`)
	)";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"terms` VALUES(1, 1, 'Terms and conditions', 4334, 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"terms` VALUES(3, 2, 'Terms and conditions', 4334, 2)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"terms` VALUES(4, 3, 'Terms and conditions', 4334, 3)";
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'terms` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//testimonials
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "testimonials'" ) !=
	PVS_DB_PREFIX . 'testimonials' )
{

	$sql = "CREATE TABLE `" . PVS_DB_PREFIX . "testimonials` (
	  `id_parent` int(11) NOT NULL auto_increment,
	  `touser` varchar(200) default NULL,
	  `fromuser` varchar(200) default NULL,
	  `content` text,
	  `data` int(11) default NULL,
	  KEY `id_parent` (`id_parent`),
	  KEY `touser` (`touser`),
	  KEY `fromuser` (`fromuser`),
	  KEY `data` (`data`)
	)";
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'testimonials` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//translations
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "translations'" ) !=
	PVS_DB_PREFIX . 'translations' )
{

	$sql = "CREATE TABLE `" . PVS_DB_PREFIX . "translations` (
	  `id` int(11) default NULL,
	  `title` varchar(250) character set utf8 NOT NULL,
	  `keywords` text character set utf8 NOT NULL,
	  `description` text character set utf8 NOT NULL,
	  `types` tinyint(1) default NULL,
	  `lang` varchar(3) character set utf8 default NULL,
	  KEY `id` (`id`),
	  KEY `id_lang` (`id`,`lang`),
	  KEY `types` (`types`)
	)";
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'translations` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//user_category
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "user_category'" ) !=
	PVS_DB_PREFIX . 'user_category' )
{

	$sql = "CREATE TABLE `" . PVS_DB_PREFIX . "user_category` (
	  `id_parent` int(11) NOT NULL auto_increment,
	  `category` int(11) default NULL,
	  `upload` int(11) default NULL,
	  `percentage` float default NULL,
	  `name` varchar(200) default NULL,
	  `upload2` int(11) default NULL,
	  `priority` int(11) default NULL,
	  `videolimit` int(11) default NULL,
	  `previewvideolimit` int(11) default NULL,
	  `photolimit` int(11) default NULL,
	  `blog` int(11) default NULL,
	  `menu` int(11) default NULL,
	  `upload3` int(11) default NULL,
	  `audiolimit` int(11) default NULL,
	  `previewaudiolimit` int(11) default NULL,
	  `upload4` int(11) default NULL,
	  `vectorlimit` int(11) default NULL,
	  `percentage_prints` float default NULL,
	  `percentage_type` tinyint(4) default NULL,
	  `percentage_prints_type` tinyint(4) default NULL,
	  `percentage_subscription` float default NULL,
	  `percentage_subscription_type` tinyint(4) default NULL,
	  KEY `id_parent` (`id_parent`)
	)";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"user_category` VALUES(1, 1, 1, 0.7, 'Gold', 1, 1, 250, 10, 5, 1, 1, 1, 50, 5, 1, 20, 1, 1, 1, 0.6, 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"user_category` VALUES(2, 1, 1, 0.6, 'Silver', 1, 2, 50, 10, 10, 1, 0, 1, 20, 2, 1, 15, 0.9, 1, 1, 0.5, 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"user_category` VALUES(3, 0, 1, 0.5, 'Bronze', 0, 3, 0, 0, 2, 0, 0, 0, 0, 0, 0, 0, 0.8, 1, 1, 0.4, 1)";
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'user_category` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}


//users_fields
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "users_fields'" ) !=
	PVS_DB_PREFIX . 'users_fields' )
{

	$sql = "CREATE TABLE `" . PVS_DB_PREFIX .
		"users_fields` (
	  `id` int(11) NOT NULL auto_increment,
	  `title` varchar(50) default NULL,
	  `field_name` varchar(50) default NULL,
	  `required` tinyint(4) default NULL,
	  `columns` tinyint(4) default NULL,
	  `priority` int(11) default NULL,
	  `signup` tinyint(4) default NULL,
	  `profile` tinyint(4) default NULL,
	  PRIMARY KEY  (`id`),
	  KEY `priority` (`priority`),
	  KEY `columns` (`columns`)
	)";
	$wpdb->query( $sql );
	
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "users_fields` VALUES(1, 'Login', 'login', 1, 0, 1, 1, 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "users_fields` VALUES(2, 'Password', 'password', 1, 0, 2, 1, 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "users_fields` VALUES(3, 'first name', 'name', 1, 0, 3, 1, 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "users_fields` VALUES(4, 'last name', 'lastname', 1, 0, 4, 1, 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "users_fields` VALUES(5, 'e-mail', 'email', 1, 0, 5, 1, 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "users_fields` VALUES(6, 'country', 'country', 1, 0, 6, 1, 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "users_fields` VALUES(7, 'telephone', 'telephone', 0, 0, 7, 1, 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "users_fields` VALUES(8, 'about', 'description', 0, 0, 8, 0, 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "users_fields` VALUES(9, 'state', 'state', 0, 1, 1, 1, 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "users_fields` VALUES(10, 'city', 'city', 0, 1, 2, 1, 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "users_fields` VALUES(11, 'zipcode', 'zipcode', 0, 1, 3, 1, 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "users_fields` VALUES(12, 'website', 'website', 0, 1, 4, 1, 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "users_fields` VALUES(13, 'company', 'company', 0, 1, 5, 1, 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "users_fields` VALUES(14, 'address', 'address', 0, 1, 6, 1, 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "users_fields` VALUES(15, 'status', 'business', 0, 1, 7, 1, 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "users_fields` VALUES(16, 'VAT number', 'vat', 0, 1, 8, 1, 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "users_fields` VALUES(17, 'newsletter', 'newsletter', 0, 1, 9, 1, 1)";
	$wpdb->query( $sql );
}



//vector_types
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "vector_types'" ) !=
	PVS_DB_PREFIX . 'vector_types' )
{

	$sql = "CREATE TABLE `" . PVS_DB_PREFIX . "vector_types` (
	  `id_parent` int(11) NOT NULL auto_increment,
	  `title` varchar(200) default NULL,
	  `types` varchar(200) default NULL,
	  `price` float default NULL,
	  `priority` int(11) default NULL,
	  `shipped` int(11) default NULL,
	  `license` int(10) NOT NULL,
	  `thesame` int(11) default NULL,
	  KEY `id_parent` (`id_parent`),
	  KEY `priority` (`priority`),
	  KEY `license` (`license`),
	  KEY `thesame` (`thesame`)
	)";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"vector_types` VALUES(1000, 'ZIP', 'zip', 5, 2, 0, 4583, 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"vector_types` VALUES(1001, 'Shipped CD', 'shipped', 10, 5, 1, 4583, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"vector_types` VALUES(1002, 'ZIP', 'zip', 50, 0, 0, 4584, 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"vector_types` VALUES(1003, 'Shipped CD', 'shipped', 100, 5, 1, 4584, 0)";
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'vector_types` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}



//video_fields
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "video_fields'" ) !=
	PVS_DB_PREFIX . 'video_fields' )
{

	$sql = "CREATE TABLE `" . PVS_DB_PREFIX . "video_fields` (
	  `id` int(11) NOT NULL auto_increment,
	  `name` varchar(250) default NULL,
	  `priority` int(11) default NULL,
	  `activ` int(11) default NULL,
	  `required` int(11) default NULL,
	  `always` int(11) default NULL,
	  `fname` varchar(20) default NULL,
	  PRIMARY KEY  (`id`)
	)";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"video_fields` VALUES(1, 'category', 1, 1, 1, 1, 'folder')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"video_fields` VALUES(2, 'title', 2, 1, 1, 1, 'title')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"video_fields` VALUES(3, 'description', 3, 1, 1, 0, 'description')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"video_fields` VALUES(4, 'keywords', 4, 1, 1, 0, 'keywords')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"video_fields` VALUES(5, 'file for sale', 5, 1, 1, 1, 'sale')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"video_fields` VALUES(6, 'preview video', 6, 1, 1, 1, 'previewvideo')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"video_fields` VALUES(7, 'preview picture', 7, 1, 1, 1, 'previewpicture')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"video_fields` VALUES(9, 'U.S. 2257 Information', 15, 0, 0, 0, 'usa')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"video_fields` VALUES(10, 'duration', 9, 1, 1, 0, 'duration')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"video_fields` VALUES(11, 'clip format', 10, 1, 0, 0, 'format')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"video_fields` VALUES(12, 'aspect ratio', 11, 1, 0, 0, 'ratio')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"video_fields` VALUES(13, 'field rendering', 12, 1, 0, 0, 'rendering')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"video_fields` VALUES(14, 'frames per second', 13, 1, 0, 0, 'frames')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"video_fields` VALUES(15, 'copyright holder', 14, 1, 0, 0, 'holder')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"video_fields` VALUES(16, 'terms and conditions', 16, 1, 1, 0, 'terms')";
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'video_fields` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//video_format
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "video_format'" ) !=
	PVS_DB_PREFIX . 'video_format' )
{

	$sql = "CREATE TABLE `" . PVS_DB_PREFIX . "video_format` (
	  `id` int(11) NOT NULL auto_increment,
	  `name` varchar(250) default NULL,
	  PRIMARY KEY  (`id`)
	)";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"video_format` VALUES(3, 'DV / MiniDV / DVCam')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "video_format` VALUES(4, 'Beta sp')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "video_format` VALUES(5, 'Digibeta')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "video_format` VALUES(6, 'HDV')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"video_format` VALUES(7, 'Other Hi-Def')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "video_format` VALUES(8, '35mm film')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "video_format` VALUES(9, '16mm film')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "video_format` VALUES(10, '8mm film')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"video_format` VALUES(11, 'Computer generated')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"video_format` VALUES(12, 'Flash File')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "video_format` VALUES(13, 'Other')";
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'video_format` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//video_frames
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "video_frames'" ) !=
	PVS_DB_PREFIX . 'video_frames' )
{

	$sql = "CREATE TABLE `" . PVS_DB_PREFIX . "video_frames` (
	  `id` int(11) NOT NULL auto_increment,
	  `name` varchar(250) default NULL,
	  PRIMARY KEY  (`id`)
	)";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "video_frames` VALUES(2, 'PAL')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "video_frames` VALUES(3, 'NTSC')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "video_frames` VALUES(4, 'HD1080')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "video_frames` VALUES(5, 'HD720')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "video_frames` VALUES(6, 'Other')";
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'video_frames` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//video_ratio
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "video_ratio'" ) !=
	PVS_DB_PREFIX . 'video_ratio' )
{

	$sql = "CREATE TABLE `" . PVS_DB_PREFIX . "video_ratio` (
	  `id` int(11) NOT NULL auto_increment,
	  `name` varchar(250) default NULL,
	  `width` int(11) default NULL,
	  `height` int(11) default NULL,
	  PRIMARY KEY  (`id`)
	)";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "video_ratio` VALUES(2, '4:3', 4, 3)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"video_ratio` VALUES(3, '16:9 native', 16, 9)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"video_ratio` VALUES(4, '16:9 anamorphic', 16, 9)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"video_ratio` VALUES(5, '16:9 letterboxed', 16, 9)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "video_ratio` VALUES(8, 'Other', 4, 3)";
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'video_ratio` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//video_rendering
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "video_rendering'" ) !=
	PVS_DB_PREFIX . 'video_rendering' )
{

	$sql = "CREATE TABLE `" . PVS_DB_PREFIX . "video_rendering` (
	  `id` int(11) NOT NULL auto_increment,
	  `name` varchar(250) default NULL,
	  PRIMARY KEY  (`id`)
	)";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"video_rendering` VALUES(2, 'Interlaced')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"video_rendering` VALUES(3, 'Progressive scan')";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX . "video_rendering` VALUES(4, 'Other')";
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'video_rendering` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//video_types
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "video_types'" ) !=
	PVS_DB_PREFIX . 'video_types' )
{

	$sql = "CREATE TABLE `" . PVS_DB_PREFIX . "video_types` (
	  `id_parent` int(11) NOT NULL auto_increment,
	  `title` varchar(200) default NULL,
	  `priority` int(11) default NULL,
	  `types` varchar(200) default NULL,
	  `price` float default NULL,
	  `shipped` int(11) default NULL,
	  `license` int(10) NOT NULL,
	  `thesame` int(11) default NULL,
	  KEY `id_parent` (`id_parent`),
	  KEY `priority` (`priority`),
	  KEY `shipped` (`shipped`),
	  KEY `license` (`license`),
	  KEY `thesame` (`thesame`)
	)";
	$wpdb->query( $sql );

	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"video_types` VALUES(1001, 'QuickTime', 1, 'mov', 5, 0, 4583, 2)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"video_types` VALUES(1002, 'AVI', 2, 'avi', 6, 0, 4583, 3)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"video_types` VALUES(1003, 'WMV', 3, 'wmv', 3, 0, 4583, 4)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"video_types` VALUES(1004, 'FLV', 4, 'flv', 5, 0, 4583, 5)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"video_types` VALUES(1005, 'Shipped CD', 5, 'shipped', 10, 1, 4583, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"video_types` VALUES(1006, 'AVI', 2, 'avi', 60, 0, 4584, 3)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"video_types` VALUES(1007, 'QuickTime', 1, 'mov', 50, 0, 4584, 2)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"video_types` VALUES(1008, 'WMV', 3, 'wmv', 30, 0, 4584, 4)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"video_types` VALUES(1009, 'FLV', 4, 'flv', 50, 0, 4584, 5)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"video_types` VALUES(1010, 'Shipped CD', 5, 'shipped', 100, 1, 4584, 0)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"video_types` VALUES(1011, 'MP4', 0, 'mp4', 5, 0, 4583, 1)";
	$wpdb->query( $sql );
	$sql = "INSERT INTO `" . PVS_DB_PREFIX .
		"video_types` VALUES(1012, 'MP4', 0, 'mp4', 40, 0, 4584, 1)";
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'video_types` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//voteitems
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "voteitems'" ) !=
	PVS_DB_PREFIX . 'voteitems' )
{

	$sql = "CREATE TABLE `" . PVS_DB_PREFIX . "voteitems` (
	  `id` int(11) default NULL,
	  `ip` varchar(20) NOT NULL,
	  `vote` float default NULL,
	  KEY `id` (`id`),
	  KEY `ip` (`ip`),
	  KEY `ip_id` (`ip`,`id`)
	)";
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'voteitems` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//voteitems2
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "voteitems2'" ) !=
	PVS_DB_PREFIX . 'voteitems2' )
{

	$sql = "CREATE TABLE `" . PVS_DB_PREFIX . "voteitems2` (
	  `id` int(11) default NULL,
	  `ip` varchar(20) NOT NULL,
	  `vote` float default NULL,
	  KEY `id` (`id`),
	  KEY `ip` (`ip`),
	  KEY `ip_id` (`ip`,`id`)
	)";
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'voteitems2` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}

//voteitems_users
if ( $wpdb->get_var( "SHOW TABLES LIKE '" . PVS_DB_PREFIX . "voteitems_users'" ) !=
	PVS_DB_PREFIX . 'voteitems_users' )
{

	$sql = "CREATE TABLE `" . PVS_DB_PREFIX . "voteitems_users` (
	  `id` int(11) default NULL,
	  `ip` varchar(20) NOT NULL,
	  `vote` float default NULL,
	  KEY `id` (`id`),
	  KEY `ip` (`ip`),
	  KEY `ip_id` (`ip`,`id`)
	)";
	$wpdb->query( $sql );

	$sql = 'ALTER TABLE `' . PVS_DB_PREFIX .
		'voteitems_users` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;';
	$wpdb->query( $sql );
}
?>