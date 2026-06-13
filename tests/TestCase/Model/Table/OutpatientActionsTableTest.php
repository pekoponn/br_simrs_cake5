<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OutpatientActionsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OutpatientActionsTable Test Case
 */
class OutpatientActionsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\OutpatientActionsTable
     */
    protected $OutpatientActions;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.OutpatientActions',
        'app.OutpatientVisits',
        'app.MasterTindakan',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('OutpatientActions') ? [] : ['className' => OutpatientActionsTable::class];
        $this->OutpatientActions = $this->getTableLocator()->get('OutpatientActions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->OutpatientActions);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\OutpatientActionsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\OutpatientActionsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
