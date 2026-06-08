<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BedHistoriesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BedHistoriesTable Test Case
 */
class BedHistoriesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\BedHistoriesTable
     */
    protected $BedHistories;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.BedHistories',
        'app.Beds',
        'app.Rooms',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('BedHistories') ? [] : ['className' => BedHistoriesTable::class];
        $this->BedHistories = $this->getTableLocator()->get('BedHistories', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->BedHistories);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\BedHistoriesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\BedHistoriesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
