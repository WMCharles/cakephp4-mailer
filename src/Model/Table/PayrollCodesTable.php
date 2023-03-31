<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PayrollCodes Model
 *
 * @property \App\Model\Table\UserPayrollDetailsTable&\Cake\ORM\Association\HasMany $UserPayrollDetails
 *
 * @method \App\Model\Entity\PayrollCode newEmptyEntity()
 * @method \App\Model\Entity\PayrollCode newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\PayrollCode[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PayrollCode get($primaryKey, $options = [])
 * @method \App\Model\Entity\PayrollCode findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\PayrollCode patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PayrollCode[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\PayrollCode|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PayrollCode saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PayrollCode[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\PayrollCode[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\PayrollCode[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\PayrollCode[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PayrollCodesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('payroll_codes');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('UserPayrollDetails', [
            'foreignKey' => 'payroll_code_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('name')
            ->maxLength('name', 256)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('code')
            ->maxLength('code', 256)
            ->requirePresence('code', 'create')
            ->notEmptyString('code');

        return $validator;
    }
}
