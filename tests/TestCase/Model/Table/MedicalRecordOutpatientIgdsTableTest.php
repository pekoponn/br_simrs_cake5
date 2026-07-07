<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MedicalRecordOutpatientIgdsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MedicalRecordOutpatientIgdsTable Test Case
 */
class MedicalRecordOutpatientIgdsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MedicalRecordOutpatientIgdsTable
     */
    protected $MedicalRecordOutpatientIgds;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.MedicalRecordOutpatientIgds',
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
        $config = $this->getTableLocator()->exists('MedicalRecordOutpatientIgds') ? [] : ['className' => MedicalRecordOutpatientIgdsTable::class];
        $this->MedicalRecordOutpatientIgds = $this->getTableLocator()->get('MedicalRecordOutpatientIgds', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->MedicalRecordOutpatientIgds);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\MedicalRecordOutpatientIgdsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\MedicalRecordOutpatientIgdsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
