<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LoginHistory Entity
 *
 * @property int $id
 * @property int $user_id
 * @property \Cake\I18n\FrozenTime|null $login_time
 * @property \Cake\I18n\FrozenTime|null $logout_time
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property string|null $created_user
 * @property string|null $modified_user
 *
 * @property \App\Model\Entity\User $user
 */
class LoginHistory extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'user_id' => true,
        'login_time' => true,
        'logout_time' => true,
        'created' => true,
        'modified' => true,
        'created_user' => true,
        'modified_user' => true,
        'user' => true,
    ];
}
