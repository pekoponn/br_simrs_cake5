<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OutpatientBillingsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OutpatientBillingsTable Test Case
 */
class OutpatientBillingsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\OutpatientBillingsTable
     */
    protected $OutpatientBillings;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.OutpatientBillings',
        'app.OutpatientVisits',
        'app.Registrations',
        'app.Patients',
        'app.Doctors',
        'app.Cashiers',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('OutpatientBillings') ? [] : ['className' => OutpatientBillingsTable::class];
        $this->OutpatientBillings = $this->getTableLocator()->get('OutpatientBillings', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->OutpatientBillings);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\OutpatientBillingsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\OutpatientBillingsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
