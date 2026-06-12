<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MasterIcd9Table;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MasterIcd9Table Test Case
 */
class MasterIcd9TableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MasterIcd9Table
     */
    protected $MasterIcd9;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.MasterIcd9',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('MasterIcd9') ? [] : ['className' => MasterIcd9Table::class];
        $this->MasterIcd9 = $this->getTableLocator()->get('MasterIcd9', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->MasterIcd9);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\MasterIcd9Table::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\MasterIcd9Table::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
