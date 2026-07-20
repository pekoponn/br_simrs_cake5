<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\InvoiceDetailsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\InvoiceDetailsTable Test Case
 */
class InvoiceDetailsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\InvoiceDetailsTable
     */
    protected $InvoiceDetails;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.InvoiceDetails',
        'app.Invoices',
        'app.Medicines',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('InvoiceDetails') ? [] : ['className' => InvoiceDetailsTable::class];
        $this->InvoiceDetails = $this->getTableLocator()->get('InvoiceDetails', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->InvoiceDetails);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\InvoiceDetailsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\InvoiceDetailsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
