<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MedicalRecordDiagnosesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MedicalRecordDiagnosesTable Test Case
 */
class MedicalRecordDiagnosesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MedicalRecordDiagnosesTable
     */
    protected $MedicalRecordDiagnoses;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.MedicalRecordDiagnoses',
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
        $config = $this->getTableLocator()->exists('MedicalRecordDiagnoses') ? [] : ['className' => MedicalRecordDiagnosesTable::class];
        $this->MedicalRecordDiagnoses = $this->getTableLocator()->get('MedicalRecordDiagnoses', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->MedicalRecordDiagnoses);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\MedicalRecordDiagnosesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\MedicalRecordDiagnosesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
