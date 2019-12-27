<?php

use yii\db\Migration;

class m170301_163301_init extends Migration
{
    public function up()
    {
        $this->db->createCommand("
SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for category
-- ----------------------------
DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `ordering` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk-category-parent_id-category-id` (`parent_id`),
  CONSTRAINT `fk-category-parent_id-category-id` FOREIGN KEY (`parent_id`) REFERENCES `category` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for comment
-- ----------------------------
DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `template_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `message` text,
  `answer` text,
  `score` tinyint(1) unsigned DEFAULT '0',
  `is_published` tinyint(1) unsigned DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk-comment-template_id-template-id` (`template_id`),
  KEY `fk-comment-user_id-user-id` (`user_id`),
  CONSTRAINT `fk-comment-template_id-template-id` FOREIGN KEY (`template_id`) REFERENCES `template` (`id`),
  CONSTRAINT `fk-comment-user_id-user-id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for download
-- ----------------------------
DROP TABLE IF EXISTS `download`;
CREATE TABLE `download` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `template_file_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `user_email` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for favorite
-- ----------------------------
DROP TABLE IF EXISTS `favorite`;
CREATE TABLE `favorite` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `template_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk-favotite-user_id-user-id` (`user_id`),
  KEY `fk-favotite-template_id-template-id` (`template_id`),
  CONSTRAINT `fk-favotite-template_id-template-id` FOREIGN KEY (`template_id`) REFERENCES `template` (`id`),
  CONSTRAINT `fk-favotite-user_id-user-id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for hosting
-- ----------------------------
DROP TABLE IF EXISTS `hosting`;
CREATE TABLE `hosting` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for invoice
-- ----------------------------
DROP TABLE IF EXISTS `invoice`;
CREATE TABLE `invoice` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `template_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `user_email` varchar(255) DEFAULT NULL,
  `sum` int(10) unsigned NOT NULL DEFAULT '0',
  `payout` int(10) unsigned NOT NULL DEFAULT '0',
  `status` varchar(32) NOT NULL DEFAULT 'pending',
  `paid_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for invoice_option
-- ----------------------------
DROP TABLE IF EXISTS `invoice_option`;
CREATE TABLE `invoice_option` (
  `invoice_id` int(10) unsigned NOT NULL,
  `option_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`invoice_id`,`option_id`),
  KEY `fk-invoice_service-option_id-option-id` (`option_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for invoice_service
-- ----------------------------
DROP TABLE IF EXISTS `invoice_service`;
CREATE TABLE `invoice_service` (
  `invoice_id` int(10) unsigned NOT NULL,
  `service_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`invoice_id`,`service_id`),
  KEY `fk-invoice_service-service_id-service-id` (`service_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for migration
-- ----------------------------
DROP TABLE IF EXISTS `migration`;
CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for news
-- ----------------------------
DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `picture` varchar(64) NOT NULL,
  `content_short` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for option
-- ----------------------------
DROP TABLE IF EXISTS `option`;
CREATE TABLE `option` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` int(10) NOT NULL,
  `is_required` tinyint(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for page
-- ----------------------------
DROP TABLE IF EXISTS `page`;
CREATE TABLE `page` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for payout
-- ----------------------------
DROP TABLE IF EXISTS `payout`;
CREATE TABLE `payout` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `sum` int(10) unsigned NOT NULL DEFAULT '0',
  `status` varchar(32) NOT NULL DEFAULT 'blocked',
  `comment` text NOT NULL,
  `paid_at` datetime DEFAULT NULL,
  `payment_type` varchar(32) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for seller_request
-- ----------------------------
DROP TABLE IF EXISTS `seller_request`;
CREATE TABLE `seller_request` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `skype` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for service
-- ----------------------------
DROP TABLE IF EXISTS `service`;
CREATE TABLE `service` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` int(10) NOT NULL,
  `is_required` tinyint(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for slider
-- ----------------------------
DROP TABLE IF EXISTS `slider`;
CREATE TABLE `slider` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `picture` varchar(255) DEFAULT NULL,
  `ordering` int(11) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `url_title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for snippet
-- ----------------------------
DROP TABLE IF EXISTS `snippet`;
CREATE TABLE `snippet` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tag
-- ----------------------------
DROP TABLE IF EXISTS `tag`;
CREATE TABLE `tag` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(32) NOT NULL,
  `alias` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for template
-- ----------------------------
DROP TABLE IF EXISTS `template`;
CREATE TABLE `template` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `label` varchar(32) NOT NULL DEFAULT '',
  `type` varchar(32) NOT NULL DEFAULT '',
  `demo_url` varchar(255) NOT NULL DEFAULT '',
  `price` int(10) unsigned DEFAULT NULL,
  `new_price` int(10) unsigned DEFAULT NULL,
  `discount_date` datetime DEFAULT NULL,
  `is_free` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `rating` decimal(3,2) unsigned NOT NULL DEFAULT '0.00',
  `sales_count` int(11) unsigned NOT NULL DEFAULT '0',
  `status` varchar(32) NOT NULL DEFAULT 'available',
  `moderate_status` varchar(32) NOT NULL DEFAULT 'pending',
  `features` text,
  `version_history` text,
  `created_at` varchar(255) NOT NULL,
  `hosting_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk-template-user_id-user-id` (`user_id`),
  CONSTRAINT `fk-template-user_id-user-id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for template_category
-- ----------------------------
DROP TABLE IF EXISTS `template_category`;
CREATE TABLE `template_category` (
  `template_id` int(10) unsigned NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`category_id`,`template_id`),
  KEY `fk-template_category-template_id-template-id` (`template_id`),
  CONSTRAINT `fk-template_category-category_id-category-id` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  CONSTRAINT `fk-template_category-template_id-template-id` FOREIGN KEY (`template_id`) REFERENCES `template` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for template_file
-- ----------------------------
DROP TABLE IF EXISTS `template_file`;
CREATE TABLE `template_file` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `template_id` int(10) unsigned NOT NULL,
  `original_name` varchar(255) NOT NULL,
  `file_name` varchar(64) NOT NULL,
  `size` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for template_option
-- ----------------------------
DROP TABLE IF EXISTS `template_option`;
CREATE TABLE `template_option` (
  `template_id` int(10) unsigned NOT NULL,
  `option_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`template_id`,`option_id`),
  KEY `fk-template_service-option_id-option-id` (`option_id`) USING BTREE,
  CONSTRAINT `template_option_ibfk_1` FOREIGN KEY (`option_id`) REFERENCES `option` (`id`),
  CONSTRAINT `template_option_ibfk_2` FOREIGN KEY (`template_id`) REFERENCES `template` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for template_picture
-- ----------------------------
DROP TABLE IF EXISTS `template_picture`;
CREATE TABLE `template_picture` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `template_id` int(10) unsigned NOT NULL,
  `original_name` varchar(255) NOT NULL,
  `file_name` varchar(64) NOT NULL,
  `size` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for template_service
-- ----------------------------
DROP TABLE IF EXISTS `template_service`;
CREATE TABLE `template_service` (
  `template_id` int(10) unsigned NOT NULL,
  `service_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`template_id`,`service_id`),
  KEY `fk-template_service-service_id-service-id` (`service_id`),
  CONSTRAINT `fk-template_service-service_id-service-id` FOREIGN KEY (`service_id`) REFERENCES `service` (`id`),
  CONSTRAINT `fk-template_service-template_id-template-id` FOREIGN KEY (`template_id`) REFERENCES `template` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for template_tag
-- ----------------------------
DROP TABLE IF EXISTS `template_tag`;
CREATE TABLE `template_tag` (
  `template_id` int(10) unsigned NOT NULL,
  `tag_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`tag_id`,`template_id`),
  KEY `fk-template_tag-template_id-template-id` (`template_id`),
  CONSTRAINT `fk-template_tag-tag_id-tag-id` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`),
  CONSTRAINT `fk-template_tag-template_id-template-id` FOREIGN KEY (`template_id`) REFERENCES `template` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `first_name` varchar(32) NOT NULL,
  `last_name` varchar(32) NOT NULL,
  `picture` varchar(0) DEFAULT NULL,
  `email` varchar(128) NOT NULL,
  `phone` varchar(32) NOT NULL,
  `comment` text,
  `status` varchar(32) DEFAULT NULL,
  `skype` varchar(128) NOT NULL,
  `access_token` varchar(32) NOT NULL,
  `auth_key` varchar(32) NOT NULL,
  `password_hash` varchar(128) NOT NULL,
  `role` varchar(32) NOT NULL DEFAULT 'user',
  `wmz` varchar(32) NOT NULL,
  `wmr` varchar(32) NOT NULL,
  `yandex_money` varchar(32) NOT NULL,
  `purchases_count` int(11) unsigned NOT NULL DEFAULT '0',
  `payout_percent` int(3) unsigned DEFAULT '50',
  `ip` varchar(32) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_visit` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
SET FOREIGN_KEY_CHECKS=1;

")->execute();
    }

    public function down()
    {
        echo "m170301_163301_init cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
