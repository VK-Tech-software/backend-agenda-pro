<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateEmpresaTable extends AbstractMigration
{
    public function change(): void
    {
        $this->table('companies')
            ->addColumn('user_id', 'integer')
            ->addColumn('name', 'string', ['limit' => 255])
            ->addColumn('cnpj', 'string', ['limit' => 50, 'null' => true])
            ->addColumn('address', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('city', 'string', ['limit' => 120, 'null' => true])
            ->addColumn('state', 'string', ['limit' => 50, 'null' => true])
            ->addColumn('active', 'boolean', ['default' => true])
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime', ['null' => true])
            ->create();
    }
}
