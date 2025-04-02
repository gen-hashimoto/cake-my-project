<?php
use Migrations\AbstractMigration;

class Initilal extends AbstractMigration
{

    public $autoId = false;

    public function up()
    {

        $this->table('login_historys')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('user_id', 'integer', [
                'comment' => 'ユーザーID',
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('login_time', 'timestamp', [
                'comment' => 'ログイン日時',
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('logout_time', 'timestamp', [
                'comment' => 'ログアウト日時',
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('created', 'timestamp', [
                'comment' => '作成日',
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'timestamp', [
                'comment' => '更新日',
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('created_user', 'string', [
                'comment' => '作成者',
                'default' => null,
                'limit' => 45,
                'null' => true,
            ])
            ->addColumn('modified_user', 'string', [
                'comment' => '更新者',
                'default' => null,
                'limit' => 45,
                'null' => true,
            ])
            ->create();

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

        $this->table('user_change_logs')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'comment' => 'ID',
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('action', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => false,
            ])
            ->addColumn('before_value', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('after_value', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified_user', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => true,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('created_user', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => true,
            ])
            ->create();

        $this->table('users')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('account', 'string', [
                'comment' => 'ログインID',
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('password', 'string', [
                'comment' => 'パスワード',
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('name', 'string', [
                'comment' => '名前',
                'default' => '',
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('email', 'string', [
                'comment' => 'E-Mail',
                'default' => '',
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('tel', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('deleted', 'datetime', [
                'comment' => '削除フラグ',
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('created', 'timestamp', [
                'comment' => '作成日',
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'timestamp', [
                'comment' => '更新日',
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('created_user', 'string', [
                'comment' => '作成者',
                'default' => null,
                'limit' => 45,
                'null' => true,
            ])
            ->addColumn('modified_user', 'string', [
                'comment' => '更新者',
                'default' => null,
                'limit' => 45,
                'null' => true,
            ])
            ->create();
    }

    public function down()
    {
        $this->table('login_historys')->drop()->save();
        $this->table('prefectures')->drop()->save();
        $this->table('user_change_logs')->drop()->save();
        $this->table('users')->drop()->save();
    }
}
