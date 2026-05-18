<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MedicineGroupsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MedicineGroupsTable Test Case
 */
class MedicineGroupsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MedicineGroupsTable
     */
    protected $MedicineGroups;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.MedicineGroups',
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
        $config = $this->getTableLocator()->exists('MedicineGroups') ? [] : ['className' => MedicineGroupsTable::class];
        $this->MedicineGroups = $this->getTableLocator()->get('MedicineGroups', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->MedicineGroups);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\MedicineGroupsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\MedicineGroupsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
