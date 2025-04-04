<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use SoftDelete\Model\Table\SoftDeleteTrait;
// use Cake\Localized\Validation\JpValidation;

/**
 * Users Model
 *
 * @property \App\Model\Table\LoginHistorysTable&\Cake\ORM\Association\HasMany $LoginHistorys
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
{
    use SoftDeleteTrait;
    protected $softDeleteField = 'deleted';
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('users');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('LoginHistorys', [
            'foreignKey' => 'user_id',
        ]);
    }

    /**
     * 直近１時間のユーザーデータ
     */
    public function findLastHour(Query $query, array $options)
    {
        return $query->where(['created >' => new \Cake\I18n\Date('-1 hours')]);
    }

    /**
     * マルオを探せ
     */
    public function findMaruo(Query $query, array $options)
    {
        return $query->where(['name like' => '%マルオ%']);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        // $validator->setProvider('custom', 'App\Model\Validation\CustomValidation');
        // $validator->setProvider('jp', JpValidation::class);

        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('account')
            ->maxLength('account', 20)
            ->requirePresence('account', 'create')
            ->notEmptyString('account')
            ->add('account', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->requirePresence('password', 'create')
            ->notEmptyString('password');

        $validator
            ->scalar('name')
            ->maxLength('name', 20)
            ->notEmptyString('name');

        $validator
            ->email('email')
            ->notEmptyString('email');

        $validator
            ->scalar('tel')
            ->allowEmpty('tel')
            // ->add('tel', 'tel', [
            //     'rule' => 'checkTel',
            //     'provider' => 'custom',
            //     'message' => '電話番号が正しくありません'
            // ]);
            ->add('tel', 'tel', [
                'rule' => 'phone',
                'provider' => 'jp',
                'message' => '電話番号が正しくありません'
            ]);
        // ->add('tel', 'tel', [
        //     // 'rule' => [$this, 'checkTel'],
        //     'rule' => function ($value, $context) {
        //         // \Cake\Log\Log::debug($context);
        //         return (bool) preg_match('/^[0-9][0-9\-]+[0-9]$/', $value);
        //     },
        //     'message' => '電話番号が正しくありません'
        // ]);

        $validator
            ->scalar('created_user')
            ->maxLength('created_user', 45)
            ->allowEmptyString('created_user');

        $validator
            ->scalar('modified_user')
            ->maxLength('modified_user', 45)
            ->allowEmptyString('modified_user');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->isUnique(['account']));

        return $rules;
    }

    // public function checkTel($value, $context)
    // {
    //     // \Cake\Log\Log::debug($context);
    //     return (bool) preg_match('/^[0-9][0-9\-]+[0-9]$/', $value);
    // }
}
