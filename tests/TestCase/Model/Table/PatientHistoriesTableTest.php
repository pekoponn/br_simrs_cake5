<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PatientHistoriesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PatientHistoriesTable Test Case
 */
class PatientHistoriesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PatientHistoriesTable
     */
    protected $PatientHistories;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.PatientHistories',
        'app.Registrations',
        'app.PatientHistoryDocuments',
        'app.PatientHistoryExaminations',
        'app.PatientHistoryIcares',
        'app.PatientHistoryIntegrations',
        'app.PatientHistoryLaboratories',
        'app.PatientHistoryPrescriptions',
        'app.PatientHistoryRadiologies',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('PatientHistories') ? [] : ['className' => PatientHistoriesTable::class];
        $this->PatientHistories = $this->getTableLocator()->get('PatientHistories', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->PatientHistories);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\PatientHistoriesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\PatientHistoriesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
