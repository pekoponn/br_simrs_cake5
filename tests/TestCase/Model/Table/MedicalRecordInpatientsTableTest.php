<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MedicalRecordInpatientsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MedicalRecordInpatientsTable Test Case
 */
class MedicalRecordInpatientsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MedicalRecordInpatientsTable
     */
    protected $MedicalRecordInpatients;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.MedicalRecordInpatients',
        'app.MedicalRecords',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('MedicalRecordInpatients') ? [] : ['className' => MedicalRecordInpatientsTable::class];
        $this->MedicalRecordInpatients = $this->getTableLocator()->get('MedicalRecordInpatients', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->MedicalRecordInpatients);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\MedicalRecordInpatientsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\MedicalRecordInpatientsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
