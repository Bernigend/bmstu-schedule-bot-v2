<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateCommonUsersTable extends AbstractMigration
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
        $table = $this->table('common_users');

        $table
            ->addColumn('external_id', 'string', ['null' => false])
            ->addColumn('namespace', 'string', ['null' => false])
            ->addColumn('expected_input', 'string', ['null' => false, 'default' => ''])
            ->addColumn('current_group_id', 'string', ['null' => false, 'default' => ''])

            ->addIndex(['namespace', 'external_id'])

            ->create();
    }
}
