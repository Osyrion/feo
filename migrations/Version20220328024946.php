<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220328024946 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // added indexes
        $this->addSql('ALTER TABLE `users` ADD CONSTRAINT `id` UNIQUE(`user_id`)');
        $this->addSql('ALTER TABLE `transactions` ADD INDEX `user_idx` (`user_id`)');
        $this->addSql('ALTER TABLE `transactions` ADD INDEX `created_idx` (`created_at`)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
