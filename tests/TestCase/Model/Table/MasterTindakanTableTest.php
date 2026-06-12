<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MasterTindakanTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MasterTindakanTable Test Case
 */
class MasterTindakanTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MasterTindakanTable
     */
    protected $MasterTindakan;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.MasterTindakan',
        'app.OutpatientActions',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('MasterTindakan') ? [] : ['className' => MasterTindakanTable::class];
        $this->MasterTindakan = $this->getTableLocator()->get('MasterTindakan', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->MasterTindakan);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\MasterTindakanTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\MasterTindakanTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
