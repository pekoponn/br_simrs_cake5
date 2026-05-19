<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BedsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BedsTable Test Case
 */
class BedsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\BedsTable
     */
    protected $Beds;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Beds',
        'app.Rooms',
        'app.Registrations',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Beds') ? [] : ['className' => BedsTable::class];
        $this->Beds = $this->getTableLocator()->get('Beds', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Beds);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\BedsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\BedsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
