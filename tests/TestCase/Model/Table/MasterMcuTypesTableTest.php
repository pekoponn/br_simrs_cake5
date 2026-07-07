<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MasterMcuTypesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MasterMcuTypesTable Test Case
 */
class MasterMcuTypesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MasterMcuTypesTable
     */
    protected $MasterMcuTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.MasterMcuTypes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('MasterMcuTypes') ? [] : ['className' => MasterMcuTypesTable::class];
        $this->MasterMcuTypes = $this->getTableLocator()->get('MasterMcuTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->MasterMcuTypes);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\MasterMcuTypesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
