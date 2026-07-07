<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MasterSurgeryOperatorsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MasterSurgeryOperatorsTable Test Case
 */
class MasterSurgeryOperatorsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MasterSurgeryOperatorsTable
     */
    protected $MasterSurgeryOperators;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.MasterSurgeryOperators',
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
        $config = $this->getTableLocator()->exists('MasterSurgeryOperators') ? [] : ['className' => MasterSurgeryOperatorsTable::class];
        $this->MasterSurgeryOperators = $this->getTableLocator()->get('MasterSurgeryOperators', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->MasterSurgeryOperators);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\MasterSurgeryOperatorsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\MasterSurgeryOperatorsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
