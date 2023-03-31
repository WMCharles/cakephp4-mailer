<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * UserPayrollDetail Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $payroll_code_id
 * @property string $amount
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\PayrollCode $payroll_code
 */
class UserPayrollDetail extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'user_id' => true,
        'payroll_code_id' => true,
        'amount' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
        'payroll_code' => true,
    ];
}
