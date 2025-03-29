<?php
use Migrations\AbstractMigration;

class AddTelColumnForUsers extends AbstractMigration
{

    public function up()
    {

        $this->table('users')
            ->addColumn('tel', 'string', [
                'after' => 'email',
                'default' => null,
                'length' => 20,
                'null' => false,
            ])
            ->update();
    }

    public function down()
    {

        $this->table('users')
            ->removeColumn('tel')
            ->update();
    }
}

