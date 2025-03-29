<?php

use Migrations\AbstractMigration;

class AddPrefecturesTable extends AbstractMigration
{

    public $autoId = false;

    public function up()
    {

        $this->table('prefectures')
            ->addColumn('id', 'biginteger', [
                'autoIncrement' => true,
                'comment' => '管理ID',
                'default' => null,
                'limit' => 20,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('name', 'string', [
                'comment' => '都道府県名',
                'default' => null,
                'limit' => 60,
                'null' => false,
            ])
            ->addColumn('jis_code', 'string', [
                'comment' => 'JISコード',
                'default' => null,
                'limit' => 2,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'comment' => '作成日',
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'datetime', [
                'comment' => '更新日',
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->create();
    }

    public function down()
    {

        $this->table('prefectures')->drop()->save();
    }
}
