<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MedicineMerksTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MedicineMerksTable Test Case
 */
class MedicineMerksTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MedicineMerksTable
     */
    protected $MedicineMerks;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.MedicineMerks',
        'app.Branches',
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
        $config = $this->getTableLocator()->exists('MedicineMerks') ? [] : ['className' => MedicineMerksTable::class];
        $this->MedicineMerks = $this->getTableLocator()->get('MedicineMerks', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->MedicineMerks);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\MedicineMerksTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\MedicineMerksTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
