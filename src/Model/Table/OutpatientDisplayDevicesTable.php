<?php
declare(strict_types=1);
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;
class OutpatientDisplayDevicesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('outpatient_display_devices');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
    }
    public function validationDefault(Validator $validator): Validator
    {
        return $validator->requirePresence('device_code')->notEmptyString('device_code')->requirePresence('polyclinic_name')->notEmptyString('polyclinic_name');
    }
}
