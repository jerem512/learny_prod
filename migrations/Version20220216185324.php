<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220216185324 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE member_pack (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE wp_commentmeta (meta_id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, comment_id BIGINT UNSIGNED DEFAULT 0 NOT NULL, meta_key VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_520_ci`, meta_value LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_520_ci`, INDEX meta_key (meta_key(191)), INDEX comment_id (comment_id), PRIMARY KEY(meta_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_520_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE wp_comments (comment_ID BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, comment_post_ID BIGINT UNSIGNED DEFAULT 0 NOT NULL, comment_author TINYTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_520_ci`, comment_author_email VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT \'\' NOT NULL COLLATE `utf8mb4_unicode_520_ci`, comment_author_url VARCHAR(200) CHARACTER SET utf8mb4 DEFAULT \'\' NOT NULL COLLATE `utf8mb4_unicode_520_ci`, comment_author_IP VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT \'\' NOT NULL COLLATE `utf8mb4_unicode_520_ci`, comment_date DATETIME DEFAULT \'0000-00-00 00:00:00\' NOT NULL, comment_date_gmt DATETIME DEFAULT \'0000-00-00 00:00:00\' NOT NULL, comment_content TEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_520_ci`, comment_karma INT DEFAULT 0 NOT NULL, comment_approved VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT \'1\' NOT NULL COLLATE `utf8mb4_unicode_520_ci`, comment_agent VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'\' NOT NULL COLLATE `utf8mb4_unicode_520_ci`, comment_type VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT \'comment\' NOT NULL COLLATE `utf8mb4_unicode_520_ci`, comment_parent BIGINT UNSIGNED DEFAULT 0 NOT NULL, user_id BIGINT UNSIGNED DEFAULT 0 NOT NULL, INDEX comment_date_gmt (comment_date_gmt), INDEX comment_author_email (comment_author_email(10)), INDEX comment_approved_date_gmt (comment_approved, comment_date_gmt), INDEX comment_parent (comment_parent), INDEX comment_post_ID (comment_post_ID), PRIMARY KEY(comment_ID)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_520_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE wp_links (link_id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, link_url VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'\' NOT NULL COLLATE `utf8mb4_unicode_520_ci`, link_name VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'\' NOT NULL COLLATE `utf8mb4_unicode_520_ci`, link_image VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'\' NOT NULL COLLATE `utf8mb4_unicode_520_ci`, link_target VARCHAR(25) CHARACTER SET utf8mb4 DEFAULT \'\' NOT NULL COLLATE `utf8mb4_unicode_520_ci`, link_description VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'\' NOT NULL COLLATE `utf8mb4_unicode_520_ci`, link_visible VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT \'Y\' NOT NULL COLLATE `utf8mb4_unicode_520_ci`, link_owner BIGINT UNSIGNED DEFAULT 1 NOT NULL, link_rating INT DEFAULT 0 NOT NULL, link_updated DATETIME DEFAULT \'0000-00-00 00:00:00\' NOT NULL, link_rel VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'\' NOT NULL COLLATE `utf8mb4_unicode_520_ci`, link_notes MEDIUMTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_520_ci`, link_rss VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'\' NOT NULL COLLATE `utf8mb4_unicode_520_ci`, INDEX link_visible (link_visible), PRIMARY KEY(link_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_520_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE wp_options (option_id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, option_name VARCHAR(191) CHARACTER SET utf8mb4 DEFAULT \'\' NOT NULL COLLATE `utf8mb4_unicode_520_ci`, option_value LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_520_ci`, autoload VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT \'yes\' NOT NULL COLLATE `utf8mb4_unicode_520_ci`, INDEX autoload (autoload), UNIQUE INDEX option_name (option_name), PRIMARY KEY(option_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_520_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE wp_postmeta (meta_id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, post_id BIGINT UNSIGNED DEFAULT 0 NOT NULL, meta_key VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_520_ci`, meta_value LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_520_ci`, INDEX meta_key (meta_key(191)), INDEX post_id (post_id), PRIMARY KEY(meta_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_520_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE wp_posts (ID BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, post_author BIGINT UNSIGNED DEFAULT 0 NOT NULL, post_date DATETIME DEFAULT \'0000-00-00 00:00:00\' NOT NULL, post_date_gmt DATETIME DEFAULT \'0000-00-00 00:00:00\' NOT NULL, post_content LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_520_ci`, post_title TEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_520_ci`, post_excerpt TEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_520_ci`, post_status VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT \'publish\' NOT NULL COLLATE `utf8mb4_unicode_520_ci`, comment_status VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT \'open\' NOT NULL COLLATE `utf8mb4_unicode_520_ci`, ping_status VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT \'open\' NOT NULL COLLATE `utf8mb4_unicode_520_ci`, post_password VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'\' NOT NULL COLLATE `utf8mb4_unicode_520_ci`, post_name VARCHAR(200) CHARACTER SET utf8mb4 DEFAULT \'\' NOT NULL COLLATE `utf8mb4_unicode_520_ci`, to_ping TEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_520_ci`, pinged TEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_520_ci`, post_modified DATETIME DEFAULT \'0000-00-00 00:00:00\' NOT NULL, post_modified_gmt DATETIME DEFAULT \'0000-00-00 00:00:00\' NOT NULL, post_content_filtered LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_520_ci`, post_parent BIGINT UNSIGNED DEFAULT 0 NOT NULL, guid VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'\' NOT NULL COLLATE `utf8mb4_unicode_520_ci`, menu_order INT DEFAULT 0 NOT NULL, post_type VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT \'post\' NOT NULL COLLATE `utf8mb4_unicode_520_ci`, post_mime_type VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT \'\' NOT NULL COLLATE `utf8mb4_unicode_520_ci`, comment_count BIGINT DEFAULT 0 NOT NULL, INDEX post_parent (post_parent), INDEX type_status_date (post_type, post_status, post_date, ID), INDEX post_author (post_author), INDEX post_name (post_name(191)), PRIMARY KEY(ID)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_520_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE wp_term_relationships (object_id BIGINT UNSIGNED DEFAULT 0 NOT NULL, term_taxonomy_id BIGINT UNSIGNED DEFAULT 0 NOT NULL, term_order INT DEFAULT 0 NOT NULL, INDEX term_taxonomy_id (term_taxonomy_id), PRIMARY KEY(object_id, term_taxonomy_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_520_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE wp_term_taxonomy (term_taxonomy_id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, term_id BIGINT UNSIGNED DEFAULT 0 NOT NULL, taxonomy VARCHAR(32) CHARACTER SET utf8mb4 DEFAULT \'\' NOT NULL COLLATE `utf8mb4_unicode_520_ci`, description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_520_ci`, parent BIGINT UNSIGNED DEFAULT 0 NOT NULL, count BIGINT DEFAULT 0 NOT NULL, INDEX taxonomy (taxonomy), UNIQUE INDEX term_id_taxonomy (term_id, taxonomy), PRIMARY KEY(term_taxonomy_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_520_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE wp_termmeta (meta_id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, term_id BIGINT UNSIGNED DEFAULT 0 NOT NULL, meta_key VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_520_ci`, meta_value LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_520_ci`, INDEX meta_key (meta_key(191)), INDEX term_id (term_id), PRIMARY KEY(meta_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_520_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE wp_terms (term_id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, name VARCHAR(200) CHARACTER SET utf8mb4 DEFAULT \'\' NOT NULL COLLATE `utf8mb4_unicode_520_ci`, slug VARCHAR(200) CHARACTER SET utf8mb4 DEFAULT \'\' NOT NULL COLLATE `utf8mb4_unicode_520_ci`, term_group BIGINT DEFAULT 0 NOT NULL, INDEX name (name(191)), INDEX slug (slug(191)), PRIMARY KEY(term_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_520_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE wp_usermeta (umeta_id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, user_id BIGINT UNSIGNED DEFAULT 0 NOT NULL, meta_key VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_520_ci`, meta_value LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_520_ci`, INDEX meta_key (meta_key(191)), INDEX user_id (user_id), PRIMARY KEY(umeta_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_520_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE wp_users (ID BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, user_login VARCHAR(60) CHARACTER SET utf8mb4 DEFAULT \'\' NOT NULL COLLATE `utf8mb4_unicode_520_ci`, user_pass VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'\' NOT NULL COLLATE `utf8mb4_unicode_520_ci`, user_nicename VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT \'\' NOT NULL COLLATE `utf8mb4_unicode_520_ci`, user_email VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT \'\' NOT NULL COLLATE `utf8mb4_unicode_520_ci`, user_url VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT \'\' NOT NULL COLLATE `utf8mb4_unicode_520_ci`, user_registered DATETIME DEFAULT \'0000-00-00 00:00:00\' NOT NULL, user_activation_key VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'\' NOT NULL COLLATE `utf8mb4_unicode_520_ci`, user_status INT DEFAULT 0 NOT NULL, display_name VARCHAR(250) CHARACTER SET utf8mb4 DEFAULT \'\' NOT NULL COLLATE `utf8mb4_unicode_520_ci`, INDEX user_nicename (user_nicename), INDEX user_email (user_email), INDEX user_login_key (user_login), PRIMARY KEY(ID)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_520_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE member_pack');
        $this->addSql('ALTER TABLE category CHANGE lead_category lead_category VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE images CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE lead CHANGE last_name last_name VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE first_name first_name VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(65) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE mail CHANGE recipient recipient VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE sender sender VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE object object VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE body_mail body_mail LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE member_cpf CHANGE last_name last_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE lead_id lead_id VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE date_creation date_creation VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE first_name first_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE member_ninja CHANGE last_name last_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE first_name first_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE lead_id lead_id VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE date_creation date_creation VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE groups groups VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE model_mail CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE model_object model_object VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE model_body model_body LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE type type VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE notifications_path_leads CHANGE notification_body notification_body LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE notification_type notification_type VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE notification_title notification_title VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE lead_id lead_id VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE notifs CHANGE type type VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE user_from user_from VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE user_to user_to VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE lead_id lead_id VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE number_surtaxe CHANGE pays_name pays_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE indicative indicative VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE report_bug CHANGE sender sender VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE object_report object_report VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE body_report body_report VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE reset_password_request CHANGE selector selector VARCHAR(20) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE hashed_token hashed_token VARCHAR(100) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE users CHANGE email email VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE first_name first_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE last_name last_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE pseudo pseudo VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE city city VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE birthdate birthdate VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE country country VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE address address VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE calendly_token calendly_token VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE ringover_phone_number ringover_phone_number VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE ringover_token ringover_token VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE learnybox_token learnybox_token VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE uuid_calendly uuid_calendly VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE contact_number contact_number VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE client_id_google client_id_google VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE refresh_token_google refresh_token_google VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE client_secret_google client_secret_google VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
