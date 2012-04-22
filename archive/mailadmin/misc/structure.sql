# phpMyAdmin SQL Dump
# version 2.5.7-pl1
# http://www.phpmyadmin.net
#
# Host: localhost
# Generation Time: Feb 10, 2006 at 08:25 PM
# Server version: 3.23.58
# PHP Version: 4.3.8
# 
# Database : `mail`
# 

# --------------------------------------------------------

#
# Table structure for table `group`
#

CREATE TABLE `group` (
  `g_group_id` int(16) unsigned NOT NULL auto_increment,
  `g_title` varchar(255) NOT NULL default '',
  `g_timestamp` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`g_group_id`),
  KEY `g_timestamp` (`g_timestamp`)
) TYPE=MyISAM  ;

# --------------------------------------------------------

#
# Table structure for table `log`
#

CREATE TABLE `log` (
  `l_logid` int(10) unsigned NOT NULL auto_increment,
  `l_groupid` int(10) unsigned NOT NULL default '0',
  `l_from` varchar(255) NOT NULL default '',
  `l_code` varchar(255) NOT NULL default '',
  `l_subject` varchar(255) NOT NULL default '',
  `l_body` text NOT NULL,
  `l_timestamp` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`l_logid`),
  KEY `l_groupid` (`l_groupid`),
  KEY `l_code` (`l_code`)
) TYPE=MyISAM  ;

# --------------------------------------------------------

#
# Table structure for table `record`
#

CREATE TABLE `record` (
  `r_id` int(10) unsigned NOT NULL auto_increment,
  `r_group_id` int(10) unsigned NOT NULL default '0',
  `r_address` varchar(255) NOT NULL default '',
  `r_validity` tinyint(1) NOT NULL default '1',
  `r_noerror` tinyint(1) unsigned NOT NULL default '1',
  `r_member` tinyint(1) unsigned NOT NULL default '0',
  `r_sentnum` int(10) unsigned NOT NULL default '0',
  `r_lastsent` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`r_id`),
  UNIQUE KEY `r_address` (`r_address`),
  KEY `r_setnum` (`r_sentnum`),
  KEY `r_lastsent` (`r_lastsent`),
  KEY `r_member` (`r_member`),
  KEY `r_group_id` (`r_group_id`),
  KEY `r_noerror` (`r_noerror`),
  KEY `r_validity` (`r_validity`)
) TYPE=MyISAM  ;

# --------------------------------------------------------

#
# Table structure for table `schedule`
#

CREATE TABLE `schedule` (
  `s_id` int(10) unsigned NOT NULL auto_increment,
  `s_logid` int(10) unsigned NOT NULL default '0',
  `s_status` tinyint(3) unsigned NOT NULL default '0',
  `s_start` datetime NOT NULL default '0000-00-00 00:00:00',
  `s_schedule` datetime NOT NULL default '0000-00-00 00:00:00',
  `s_end` datetime default NULL,
  PRIMARY KEY  (`s_id`),
  KEY `s_status` (`s_status`),
  KEY `s_logid` (`s_logid`),
  KEY `s_schedule` (`s_schedule`)
) TYPE=MyISAM  ;
    


