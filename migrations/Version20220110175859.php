<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220110175859 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE images (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_E01FBE6AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lead_membership (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, lead_id INT NOT NULL, INDEX IDX_AE64C919A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE model_mail (id INT AUTO_INCREMENT NOT NULL, model_mail_id INT NOT NULL, name VARCHAR(255) NOT NULL, model_object VARCHAR(255) NOT NULL, model_body LONGTEXT NOT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_7C7180AFA8E406F0 (model_mail_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6AA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE lead_membership ADD CONSTRAINT FK_AE64C919A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE model_mail ADD CONSTRAINT FK_7C7180AFA8E406F0 FOREIGN KEY (model_mail_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE users ADD first_name VARCHAR(255) NOT NULL, ADD last_name VARCHAR(255) NOT NULL, ADD username VARCHAR(255) DEFAULT NULL, ADD city VARCHAR(255) DEFAULT NULL, ADD birthdate VARCHAR(255) DEFAULT NULL, ADD country VARCHAR(255) DEFAULT NULL, ADD address VARCHAR(255) DEFAULT NULL, ADD calendly_token VARCHAR(255) DEFAULT NULL, ADD ringover_phone_number VARCHAR(255) DEFAULT NULL, ADD ringover_token VARCHAR(255) DEFAULT NULL, ADD learnybox_token VARCHAR(255) DEFAULT NULL, ADD uuid_calendly VARCHAR(255) DEFAULT NULL, ADD contact_number VARCHAR(255) DEFAULT NULL, ADD client_id_google VARCHAR(255) DEFAULT NULL, ADD refresh_token_google VARCHAR(255) DEFAULT NULL, ADD client_secret_google VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE images');
        $this->addSql('DROP TABLE lead_membership');
        $this->addSql('DROP TABLE model_mail');
        $this->addSql('ALTER TABLE users DROP first_name, DROP last_name, DROP username, DROP city, DROP birthdate, DROP country, DROP address, DROP calendly_token, DROP ringover_phone_number, DROP ringover_token, DROP learnybox_token, DROP uuid_calendly, DROP contact_number, DROP client_id_google, DROP refresh_token_google, DROP client_secret_google');
    }
}
