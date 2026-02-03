<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateUsersTable extends AbstractMigration
{
    
    public function change(): void
    {
        $table = $this->table('users');
        $table->addColumn('name', 'string', ['limit' => 255])
            ->addColumn('email', 'string', ['limit' => 255])
            ->addColumn('password', 'string', ['limit' => 255])
            ->addColumn('tipo_conta', 'string', ['limit' => 50, 'null' => true])
            ->addColumn('telefone', 'string', ['limit' => 50, 'null' => true])
            ->addColumn('zip_code', 'string', ['limit' => 50, 'null' => true])
            ->addColumn('verification_code', 'string', ['limit' => 50, 'null' => true])          
            ->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'datetime', ['null' => true, 'default' => null])
            ->addIndex(['email'], ['unique' => true])
            ->create();
    }
}
