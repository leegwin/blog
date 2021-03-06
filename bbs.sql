/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50640
 Source Host           : localhost
 Source Database       : bbs

 Target Server Type    : MySQL
 Target Server Version : 50640
 File Encoding         : utf-8

 Date: 08/31/2018 15:17:17 PM
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `houseThumbs`
-- ----------------------------
DROP TABLE IF EXISTS `houseThumbs`;
CREATE TABLE `houseThumbs` (
  `uId` int(10) unsigned NOT NULL,
  `tId` int(11) NOT NULL,
  `hFlag` bit(1) NOT NULL DEFAULT b'0',
  `upFlag` bit(1) NOT NULL DEFAULT b'0',
  `downFlag` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`uId`,`tId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `log`
-- ----------------------------
DROP TABLE IF EXISTS `log`;
CREATE TABLE `log` (
  `logId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uName` varchar(255) NOT NULL,
  `logIp` varchar(255) NOT NULL,
  `logTime` datetime NOT NULL,
  PRIMARY KEY (`logId`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `reply`
-- ----------------------------
DROP TABLE IF EXISTS `reply`;
CREATE TABLE `reply` (
  `rId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tId` int(10) unsigned NOT NULL,
  `uId` int(10) unsigned NOT NULL,
  `rContents` text NOT NULL,
  `rTime` datetime NOT NULL,
  `rType` int(11) NOT NULL,
  PRIMARY KEY (`rId`),
  KEY `tId` (`tId`),
  KEY `uId` (`uId`),
  CONSTRAINT `reply_ibfk_1` FOREIGN KEY (`tId`) REFERENCES `topic` (`tId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `reply_ibfk_2` FOREIGN KEY (`uId`) REFERENCES `users` (`uId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `roles`
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `roId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `roName` varchar(16) NOT NULL,
  `authSec` bit(1) NOT NULL DEFAULT b'0',
  `authTop` bit(1) NOT NULL DEFAULT b'0',
  `authRep` bit(1) NOT NULL DEFAULT b'0',
  `authMan` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`roId`),
  UNIQUE KEY `roleNameUnique` (`roName`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `section`
-- ----------------------------
DROP TABLE IF EXISTS `section`;
CREATE TABLE `section` (
  `sId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sName` varchar(64) NOT NULL,
  `sImg` varchar(255) DEFAULT NULL,
  `uId` int(10) unsigned NOT NULL,
  `sMark` varchar(255) DEFAULT NULL,
  `sClickCount` int(10) unsigned NOT NULL DEFAULT '0',
  `sTopicCount` int(11) NOT NULL DEFAULT '0',
  `sTime` datetime DEFAULT NULL,
  PRIMARY KEY (`sId`),
  UNIQUE KEY `sectionNameUnique` (`sName`),
  KEY `uId` (`uId`),
  CONSTRAINT `section_ibfk_1` FOREIGN KEY (`uId`) REFERENCES `users` (`uId`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `topic`
-- ----------------------------
DROP TABLE IF EXISTS `topic`;
CREATE TABLE `topic` (
  `tId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sId` int(10) unsigned NOT NULL,
  `uId` int(10) unsigned NOT NULL,
  `tTopic` varchar(255) NOT NULL,
  `tContents` text NOT NULL,
  `tTime` datetime NOT NULL,
  `tFlag` int(10) unsigned NOT NULL DEFAULT '0',
  `tMark` varchar(255) DEFAULT NULL,
  `tLastClickTime` datetime DEFAULT NULL,
  `tClickLike` int(10) unsigned zerofill DEFAULT NULL,
  `tClickHate` int(10) unsigned zerofill DEFAULT NULL,
  PRIMARY KEY (`tId`),
  KEY `sId` (`sId`),
  KEY `uId` (`uId`),
  CONSTRAINT `topic_ibfk_1` FOREIGN KEY (`sId`) REFERENCES `section` (`sId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `topic_ibfk_2` FOREIGN KEY (`uId`) REFERENCES `users` (`uId`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `uId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uName` varchar(32) NOT NULL,
  `uPassword` varchar(32) NOT NULL,
  `token` varchar(255) NOT NULL,
  `roId` int(11) unsigned NOT NULL DEFAULT '2',
  `uPhone` varchar(11) NOT NULL,
  `uEmail` varchar(32) NOT NULL,
  `uBirthday` date NOT NULL,
  `uSex` bit(1) NOT NULL DEFAULT b'1',
  `uRegDate` datetime NOT NULL,
  `uState` int(11) NOT NULL DEFAULT '1',
  `uMark` varchar(255) NOT NULL,
  PRIMARY KEY (`uId`),
  UNIQUE KEY `user_name` (`uName`),
  UNIQUE KEY `uEmail` (`uEmail`),
  KEY `roid` (`roId`),
  KEY `user_phone` (`uPhone`) USING BTREE,
  CONSTRAINT `roid_fk` FOREIGN KEY (`roId`) REFERENCES `roles` (`roId`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

SET FOREIGN_KEY_CHECKS = 1;
