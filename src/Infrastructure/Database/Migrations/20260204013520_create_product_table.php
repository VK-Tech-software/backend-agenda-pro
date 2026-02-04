<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateProductTable extends AbstractMigration
{
    
    public function change(): void
    {

        $this->table('products')
            ->addColumn('name', 'string', ['limit' => 255])
            ->addColumn('description', 'string', ['limit' => 1024, 'null' => true])
            ->addColumn('price', 'decimal', ['precision' => 10, 'scale' => 2, 'null' => true])
            ->addColumn('active', 'boolean', ['default' => true])
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime', ['null' => true])
            ->create();

        }
}

