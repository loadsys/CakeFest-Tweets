CREATE TABLE `prefs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `since_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE `tweets` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `user_image` varchar(255) DEFAULT NULL,
  `user_id` int(11) unsigned DEFAULT NULL,
  `twitter_id` varchar(255) DEFAULT NULL,
  `tweet_id` varchar(255) DEFAULT NULL,
  `tweet_datetime` datetime DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  `from` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `twitter_id` int(11) unsigned DEFAULT NULL,
  `user_image` varchar(255) DEFAULT NULL,
  `tweet_count` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE `accounts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `password` char(40) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

ALTER TABLE tweets ADD COLUMN is_blacklist TINYINT(1) default 0;
ALTER TABLE users ADD COLUMN is_blacklist TINYINT(1) default 0;