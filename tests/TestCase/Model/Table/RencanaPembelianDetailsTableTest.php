<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RencanaPembelianDetailsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RencanaPembelianDetailsTable Test Case
 */
class RencanaPembelianDetailsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RencanaPembelianDetailsTable
     */
    protected $RencanaPembelianDetails;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.RencanaPembelianDetails',
        'app.RencanaPembelians',
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
        $config = $this->getTableLocator()->exists('RencanaPembelianDetails') ? [] : ['className' => RencanaPembelianDetailsTable::class];
        $this->RencanaPembelianDetails = $this->getTableLocator()->get('RencanaPembelianDetails', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->RencanaPembelianDetails);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\RencanaPembelianDetailsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\RencanaPembelianDetailsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
