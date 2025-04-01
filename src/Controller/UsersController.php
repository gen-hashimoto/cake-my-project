<?php

namespace App\Controller;

use App\Controller\AppController;
use Zend\Diactoros\UploadedFile;
use \SplFileObject;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['logout']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        // $query = $this->Users->find('lastHour');
        $query = $this->Users->find();
        $users = $this->paginate($query);

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['LoginHistorys'],
        ]);

        $this->set('user', $user);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        // $this->editOrigin($id);
        // $this->editInTransaction($id);
        $this->editInClosure($id);
    }

    /**
     * トランザクションを処理しないデータ編集
     */
    public function editOrigin($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $result = true;
            // ユーザー変更履歴を生成する
            $this->loadModel('UserChangeLogs');
            $userChangeLog = $this->UserChangeLogs->newEntity();
            $userChangeLog->action = 'edit';
            $userChangeLog->before_value = serialize($user);
            $userChangeLog->modified_user = $this->Auth->user('account');
            $userChangeLog->created_user = $this->Auth->user('account');

            $user = $this->Users->patchEntity($user, $this->request->getData());
            $userChangeLog->after_value = serialize($user);

            // ユーザーデータの保存
            if ($this->Users->save($user)) {
                $this->Flash->success(__('ユーザーを保存しました。'));
            } else {
                $this->Flash->error(__('ユーザーが保存できませんでした。'));
                $result = false;
            }

            //ユーザー変更ログの保存
            if ($this->UserChangeLogs->save($userChangeLog)) {
                $this->Flash->success(__('ユーザー変更ログを保存しました。'));
            } else {
                $this->Flash->error(__('ユーザー変更ログが保存できませんでした。'));
                $result = false;
            }

            // エラーがなければ一覧画面に遷移する
            if ($result) {
                return $this->redirect(['action' => 'index']);
            }
        }
        $this->set(compact('user'));
    }

    /**
     * トランザクションを処理するデータ編集 その１
     */
    public function editInTransaction($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $result = true;
            // ユーザー変更履歴を生成する
            $this->loadModel('UserChangeLogs');
            $userChangeLog = $this->UserChangeLogs->newEntity();
            $userChangeLog->action = 'edit';
            $userChangeLog->before_value = serialize($user);
            $userChangeLog->modified_user = $this->Auth->user('account');
            $userChangeLog->created_user = $this->Auth->user('account');

            $user = $this->Users->patchEntity($user, $this->request->getData());
            $userChangeLog->after_value = serialize($user);

            // トランザクション開始
            $conn = $this->Users->getConnection();
            $conn->begin();

            // ユーザーデータの保存
            if ($this->Users->save($user)) {
                $this->Flash->success(__('ユーザーを保存しました。'));
            } else {
                $this->Flash->error(__('ユーザーが保存できませんでした。'));
                $result = false;
            }

            //ユーザー変更ログの保存
            if ($this->UserChangeLogs->save($userChangeLog)) {
                $this->Flash->success(__('ユーザー変更ログを保存しました。'));
            } else {
                $this->Flash->error(__('ユーザー変更ログが保存できませんでした。'));
                $result = false;
            }

            // エラーがなければ一覧画面に遷移する
            if ($result) {
                // トランザクション、コミット
                $conn->commit();
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('ユーザーとユーザーの変更ログの両方の保存が成功しなかったためロールバックしました。'));
                // トランザクション、ロールバック
                $conn->rollback();
            }
        }
        $this->set(compact('user'));
    }

    /**
     * クロージャーを使ったトランザクション処理
     */
    public function editInClosure($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            //saveを行う処理をクロージャにいれる
            $saveProc = function () use ($user) {
                $saveResult = true;
                // ユーザー変更履歴を生成する
                $this->loadModel('UserChangeLogs');
                $userChangeLog = $this->UserChangeLogs->newEntity();
                $userChangeLog->action = 'edit';
                $userChangeLog->before_value = serialize($user);
                $userChangeLog->modified_user = $this->Auth->user('account');
                $userChangeLog->created_user = $this->Auth->user('account');

                $user = $this->Users->patchEntity($user, $this->request->getData());
                $userChangeLog->after_value = serialize($user);

                // ユーザーデータの保存
                if ($this->Users->save($user)) {
                    $this->Flash->success(__('ユーザーを保存しました。'));
                } else {
                    $this->Flash->error(__('ユーザーが保存できませんでした。'));
                    $saveResult = false;
                }

                //ユーザー変更ログの保存
                if ($this->UserChangeLogs->save($userChangeLog)) {
                    $this->Flash->success(__('ユーザー変更ログを保存しました。'));
                } else {
                    $this->Flash->error(__('ユーザー変更ログが保存できませんでした。'));
                    $saveResult = false;
                }
                return $saveResult;
            };

            //DBのコネクションを取得し、データ保存処理を実行
            $conn = $this->Users->getConnection();
            $result = $conn->transactional($saveProc);

            // エラーがなければ一覧画面に遷移する
            if ($result) {
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('ユーザーとユーザーの変更ログの両方の保存が成功しなかったためロールバックしました。'));
                // トランザクション、ロールバック
                $conn->rollback();
            }
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function login()
    {
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(__('Invalid username or password, try again'));
        }
    }

    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }

    public function upload()
    {
        if ($this->request->is('post')) {
            // ファイルの拡張子がcsvファイル以外の場合はファイル形式エラーとする。
            if (mb_strtolower(pathinfo($_FILES['upload_file']['name'], PATHINFO_EXTENSION)) != 'csv') {
                $this->Flash->error(__('The file format is invalid.'));
                return;
            }

            // ファイル読込み準備
            $uploadFile = $_FILES['upload_file']['tmp_name'];
            file_put_contents($uploadFile, mb_convert_encoding(file_get_contents($uploadFile), 'UTF-8', 'SJIS'));
            $file = new SplFileObject($uploadFile);
            $file->setFlags(SplFileObject::READ_CSV);

            $new_users = array();
            $errors = array();

            foreach ($file as $rowIndex => $line) {
                if ($rowIndex < 1) {
                    // 1行目はヘッダーなので読み飛ばし
                    continue;
                }

                // 項目数が合わない場合は項目数エラーを記録し次の行を処理します
                // 最終行がからの場合はスルーします
                if (count($line) != 5) {
                    if ($file->valid() || ($file->eof() && !empty($line[0]))) {
                        $errors = $this->setError($errors, $rowIndex, __('The number of items is invalid.'));
                    }
                } else {
                    // 取り込んだCSVデータ行からユーザーデータ配列を作成します。
                    $arrUser = $this->createUserArray($line);
                    // ユーザーデータの配列をユーザーエンティティにパッチします。
                    $user = $this->Users->newEntity($arrUser);

                    // Validationでエラーがあった場合、エンティティにエラーがセットされるので
                    // 最後にエラー一覧を表示するため、エラーがある場合は別で保存しておきます。
                    $entityErrors = $user->getErrors();
                    foreach ($entityErrors as $key => $value) {
                        if (is_array($value)) {
                            foreach ($value as $rule => $message) {
                                $errors = $this->setError($errors, $rowIndex, $message);
                            }
                        }
                    }
                    // Validationエラーがなかった場合は、一括保存のため配列に入れておきます。
                    if (empty($errors)) {
                        array_push($new_users, $user);
                    }
                }
            }

            // エラーがなかった場合データを保存し一覧画面に遷移します。
            // エラーがあった場合はファイル選択画面に遷移しエラー内容を表示します。
            if (!$errors) {
                // ユーザーデータを登録する
                if ($this->Users->saveMany($new_users)) {
                    $this->Flash->success(__('The user has been saved.'));
                    return $this->redirect(['action' => 'index']);
                }
                // データセーブのタイミングでユーザーテーブルのbuildRulesメソッドでのチェックが行われます。
                // buildRulesメソッドでエラー場あった場合、もしくはデータベースの保存時にエラーが発生した場合は
                // このメッセージが表示されます。
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            } else {
                // ファイルアップロード画面にエラー内容を渡します。
                $this->Flash->error(__('Contains incorrect data. Please check the message, correct the data and upload again.'));
                $this->set(compact('errors'));
            }
        }
    }

    /**
     * ユーザーデータ取り込みcsvデータの1行から、1件のユーザーデータ配列を作成します。
     * @param [array] $line csvの行データ配列
     * @return ユーザーデータ配列
     */
    private function createUserArray($line)
    {
        $arr = array();
        $arr['account'] = $line[0];
        $arr['password'] = $line[1];
        $arr['name'] = $line[2];
        $arr['email'] = $line[3];
        $arr['tel'] = $line[4];

        return $arr;
    }

    /**
     * エラー情報をエラー蓄積用配列にセットし返します。
     * @param [array] $errors エラー蓄積用配列
     * @param [int] $rowIndex エラー発生行番号(行番号を表示したくない場合は空文字可)
     * @param [array] $description エラーメッセージ
     * @return エラー蓄積用配列
     */
    private function setError($errors, $rowIndex, $description)
    {
        $error = array();
        empty($rowIndex) ? $error['LINE_NO'] = '' : $error['LINE_NO'] = $rowIndex + 1;
        $error['DESCRIPTION'] = $description;
        array_push($errors, $error);

        return $errors;
    }
}
