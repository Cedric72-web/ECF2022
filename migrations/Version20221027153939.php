<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221027153939 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'First migration';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE franchise (id INT AUTO_INCREMENT NOT NULL, id_user_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, activate TINYINT(1) NOT NULL, INDEX IDX_66F6CE2A79F37AE5 (id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE module (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, activate TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE module_structure (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE module_structure_partner (module_structure_id INT NOT NULL, partner_id INT NOT NULL, INDEX IDX_6357F5174D679879 (module_structure_id), INDEX IDX_6357F5179393F8FE (partner_id), PRIMARY KEY(module_structure_id, partner_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE module_structure_module (module_structure_id INT NOT NULL, module_id INT NOT NULL, INDEX IDX_180D119B4D679879 (module_structure_id), INDEX IDX_180D119BAFC2B591 (module_id), PRIMARY KEY(module_structure_id, module_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE partner (id INT AUTO_INCREMENT NOT NULL, owner_id INT DEFAULT NULL, franchise_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, zipcode VARCHAR(5) NOT NULL, city VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, activate TINYINT(1) NOT NULL, INDEX IDX_312B3E167E3C61F9 (owner_id), INDEX IDX_312B3E16523CAB89 (franchise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE franchise ADD CONSTRAINT FK_66F6CE2A79F37AE5 FOREIGN KEY (id_user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE module_structure_partner ADD CONSTRAINT FK_6357F5174D679879 FOREIGN KEY (module_structure_id) REFERENCES module_structure (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE module_structure_partner ADD CONSTRAINT FK_6357F5179393F8FE FOREIGN KEY (partner_id) REFERENCES partner (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE module_structure_module ADD CONSTRAINT FK_180D119B4D679879 FOREIGN KEY (module_structure_id) REFERENCES module_structure (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE module_structure_module ADD CONSTRAINT FK_180D119BAFC2B591 FOREIGN KEY (module_id) REFERENCES module (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE partner ADD CONSTRAINT FK_312B3E167E3C61F9 FOREIGN KEY (owner_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE partner ADD CONSTRAINT FK_312B3E16523CAB89 FOREIGN KEY (franchise_id) REFERENCES franchise (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE franchise DROP FOREIGN KEY FK_66F6CE2A79F37AE5');
        $this->addSql('ALTER TABLE module_structure_partner DROP FOREIGN KEY FK_6357F5174D679879');
        $this->addSql('ALTER TABLE module_structure_partner DROP FOREIGN KEY FK_6357F5179393F8FE');
        $this->addSql('ALTER TABLE module_structure_module DROP FOREIGN KEY FK_180D119B4D679879');
        $this->addSql('ALTER TABLE module_structure_module DROP FOREIGN KEY FK_180D119BAFC2B591');
        $this->addSql('ALTER TABLE partner DROP FOREIGN KEY FK_312B3E167E3C61F9');
        $this->addSql('ALTER TABLE partner DROP FOREIGN KEY FK_312B3E16523CAB89');
        $this->addSql('DROP TABLE franchise');
        $this->addSql('DROP TABLE module');
        $this->addSql('DROP TABLE module_structure');
        $this->addSql('DROP TABLE module_structure_partner');
        $this->addSql('DROP TABLE module_structure_module');
        $this->addSql('DROP TABLE partner');
        $this->addSql('DROP TABLE `user`');
    }
}
