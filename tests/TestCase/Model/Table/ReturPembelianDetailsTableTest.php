<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ReturPembelianDetailsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ReturPembelianDetailsTable Test Case
 */
class ReturPembelianDetailsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ReturPembelianDetailsTable
     */
    protected $ReturPembelianDetails;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.ReturPembelianDetails',
        'app.ReturPembelians',
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
        $config = $this->getTableLocator()->exists('ReturPembelianDetails') ? [] : ['className' => ReturPembelianDetailsTable::class];
        $this->ReturPembelianDetails = $this->getTableLocator()->get('ReturPembelianDetails', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->ReturPembelianDetails);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ReturPembelianDetailsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\ReturPembelianDetailsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
