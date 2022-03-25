<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220325184717 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE service_suite (service_id INT NOT NULL, suite_id INT NOT NULL, INDEX IDX_BC4E09C1ED5CA9E6 (service_id), INDEX IDX_BC4E09C14FFCB518 (suite_id), PRIMARY KEY(service_id, suite_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE service_suite ADD CONSTRAINT FK_BC4E09C1ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE service_suite ADD CONSTRAINT FK_BC4E09C14FFCB518 FOREIGN KEY (suite_id) REFERENCES suite (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE booking ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDEA76ED395 ON booking (user_id)');
        $this->addSql('ALTER TABLE gallery ADD suite_id INT NOT NULL');
        $this->addSql('ALTER TABLE gallery ADD CONSTRAINT FK_472B783A4FFCB518 FOREIGN KEY (suite_id) REFERENCES suite (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_472B783A4FFCB518 ON gallery (suite_id)');
        $this->addSql('ALTER TABLE suite ADD establishment_id INT NOT NULL, ADD booking_id INT NOT NULL');
        $this->addSql('ALTER TABLE suite ADD CONSTRAINT FK_153CE4268565851 FOREIGN KEY (establishment_id) REFERENCES establishment (id)');
        $this->addSql('ALTER TABLE suite ADD CONSTRAINT FK_153CE4263301C60 FOREIGN KEY (booking_id) REFERENCES booking (id)');
        $this->addSql('CREATE INDEX IDX_153CE4268565851 ON suite (establishment_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_153CE4263301C60 ON suite (booking_id)');
        $this->addSql('ALTER TABLE user ADD establishment_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6498565851 FOREIGN KEY (establishment_id) REFERENCES establishment (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6498565851 ON user (establishment_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE service_suite');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDEA76ED395');
        $this->addSql('DROP INDEX IDX_E00CEDDEA76ED395 ON booking');
        $this->addSql('ALTER TABLE booking DROP user_id, CHANGE slug slug VARCHAR(100) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE establishment CHANGE nom nom VARCHAR(100) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE ville ville VARCHAR(100) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE adresse adresse VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE page_web page_web VARCHAR(100) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE slug slug VARCHAR(100) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE gallery DROP FOREIGN KEY FK_472B783A4FFCB518');
        $this->addSql('DROP INDEX UNIQ_472B783A4FFCB518 ON gallery');
        $this->addSql('ALTER TABLE gallery DROP suite_id, CHANGE titre titre VARCHAR(100) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE lien lien VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE slug slug VARCHAR(100) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE messenger_messages CHANGE body body LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE headers headers LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE queue_name queue_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE role CHANGE titre titre VARCHAR(100) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE service CHANGE titre titre VARCHAR(100) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE slug slug VARCHAR(100) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE suite DROP FOREIGN KEY FK_153CE4268565851');
        $this->addSql('ALTER TABLE suite DROP FOREIGN KEY FK_153CE4263301C60');
        $this->addSql('DROP INDEX IDX_153CE4268565851 ON suite');
        $this->addSql('DROP INDEX UNIQ_153CE4263301C60 ON suite');
        $this->addSql('ALTER TABLE suite DROP establishment_id, DROP booking_id, CHANGE titre titre VARCHAR(100) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE image image VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE lien_booking lien_booking VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE slug slug VARCHAR(100) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D6498565851');
        $this->addSql('DROP INDEX UNIQ_8D93D6498565851 ON `user`');
        $this->addSql('ALTER TABLE `user` DROP establishment_id, CHANGE email email VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE prenom prenom VARCHAR(100) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE nom nom VARCHAR(100) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE telephone telephone VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
