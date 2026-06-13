<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OutpatientVisitsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OutpatientVisitsTable Test Case
 */
class OutpatientVisitsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\OutpatientVisitsTable
     */
    protected $OutpatientVisits;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.OutpatientVisits',
        'app.Registrations',
        'app.Patients',
        'app.Doctors',
        'app.OutpatientActions',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('OutpatientVisits') ? [] : ['className' => OutpatientVisitsTable::class];
        $this->OutpatientVisits = $this->getTableLocator()->get('OutpatientVisits', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->OutpatientVisits);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\OutpatientVisitsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\OutpatientVisitsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
