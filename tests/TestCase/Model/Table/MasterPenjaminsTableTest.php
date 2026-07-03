<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MasterPenjaminsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MasterPenjaminsTable Test Case
 */
class MasterPenjaminsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MasterPenjaminsTable
     */
    protected $MasterPenjamins;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.MasterPenjamins',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('MasterPenjamins') ? [] : ['className' => MasterPenjaminsTable::class];
        $this->MasterPenjamins = $this->getTableLocator()->get('MasterPenjamins', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->MasterPenjamins);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\MasterPenjaminsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
