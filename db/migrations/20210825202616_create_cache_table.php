<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateCacheTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $this
            ->table('cache')

            ->addColumn('cache_key', 'string', ['null' => false])
            ->addColumn('cache_value', 'string')
            ->addColumn('created_at', 'timestamp', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('ttl', 'integer', ['null' => false, 'default' => 3600])

            ->addIndex('cache_key', [
                'name' => 'cache_key_index',
                'unique' => true,
            ])

            ->create();
    }
}
