<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Authentication\PasswordHasher\DefaultPasswordHasher; // Add this line, tambahan untuk auth
use Authentication\IdentityInterface;

/**
 * User Entity
 *
 * @property int $id
 * @property string $branch_id
 * @property string|null $code
 * @property string|null $staff
 * @property string|null $name
 * @property string|null $password
 * @property string|null $help_hint_pwd
 * @property string|null $telp
 * @property string|null $email
 * @property string|null $devision
 * @property string|null $position
 * @property string|null $marketing_code
 * @property string|null $approved
 * @property string|null $approved_ceo
 * @property string|null $payment
 * @property string|null $pettycash_full_access
 * @property string|null $hris_approved
 * @property string|null $hris_knowing
 * @property string|null $hris_full_access
 * @property string|null $rule
 * @property string|null $rules
 * @property string|null $rule_acc
 * @property string|null $jurnal_type_acc
 * @property string|null $change_password
 * @property \Cake\I18n\FrozenTime|null $change_password_date
 * @property int|null $reset
 * @property \Cake\I18n\FrozenTime|null $reset_date
 * @property string|null $is_create
 * @property string|null $is_update
 * @property string|null $is_delete
 * @property \Cake\I18n\FrozenTime|null $deleted
 * @property string|null $is_active
 * @property string|null $is_log
 * @property string|null $who_create
 * @property \Cake\I18n\FrozenTime|null $created
 * @property string|null $who_update
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property \Cake\I18n\FrozenTime|null $last_login
 * @property string|null $status
 * @property string|null $level
 * @property int|null $visited
 *
 * @property \App\Model\Entity\Branch $branch
 * @property \App\Model\Entity\Creditor[] $creditors
 * @property \App\Model\Entity\Customer[] $customers
 * @property \App\Model\Entity\CustomersOri[] $customers_ori
 * @property \App\Model\Entity\Log[] $logs
 * @property \App\Model\Entity\Supplier[] $suppliers
 * @property \App\Model\Entity\Transporter[] $transporters
 */
class User extends Entity
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
        'branch_id' => true,
        'hrga_employee_id' => true,
        'user_team' => true,
        'radius_id' => true,
        'telegram_chat_id' => true,
        'zona' => true,
        'working_hours' => true,
        'face' => true,
        'code' => true,
        'staff' => true,
        'name' => true,
        'password_new' => true,
        'password' => true,
        'help_hint_pwd' => true,
        'telp' => true,
        'email' => true,
        'devision' => true,
        'position' => true,
        'project' => true,
        'ubs' => true,
        'marketing_code' => true,
        'project_status' => true,
        'approved' => true,
        'approved_ceo' => true,
        'payment' => true,
        'pettycash_full_access' => true,
        'hris_approved' => true,
        'hris_knowing' => true,
        'hris_full_access' => true,
        'rule' => true,
        'rules' => true,
        'rule_acc' => true,
        'jurnal_type_acc' => true,
        'change_password' => true,
        'change_password_date' => true,
        'reset' => true,
        'reset_date' => true,
        'is_create' => true,
        'is_update' => true,
        'is_delete' => true,
        'deleted' => true,
        'is_active' => true,
        'is_log' => true,
        'who_create' => true,
        'created' => true,
        'who_update' => true,
        'modified' => true,
        'last_login' => true,
        'status' => true,
        'level' => true,
        'visited' => true,
        'branch' => true,
        'creditors' => true,
        'customers' => true,
        'customers_ori' => true,
        'logs' => true,
        'suppliers' => true,
        'transporters' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password_new',
    ];
    //'password',
    // Add this method, untuk seting password
    protected function _setPassword(string $password) : ?string
    {
        if (strlen($password) > 0) {
            return (new DefaultPasswordHasher())->hash($password);
        }
    }
}
