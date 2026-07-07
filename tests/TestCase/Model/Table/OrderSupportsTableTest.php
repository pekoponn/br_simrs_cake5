<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OrderSupportsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OrderSupportsTable Test Case
 */
class OrderSupportsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\OrderSupportsTable
     */
    protected $OrderSupports;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.OrderSupports',
        'app.Orders',
        'app.Registrations',
        'app.Patients',
        'app.Doctors',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('OrderSupports') ? [] : ['className' => OrderSupportsTable::class];
        $this->OrderSupports = $this->getTableLocator()->get('OrderSupports', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->OrderSupports);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\OrderSupportsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\OrderSupportsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
