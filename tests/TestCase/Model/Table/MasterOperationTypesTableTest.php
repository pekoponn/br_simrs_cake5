<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MasterOperationTypesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MasterOperationTypesTable Test Case
 */
class MasterOperationTypesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MasterOperationTypesTable
     */
    protected $MasterOperationTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.MasterOperationTypes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('MasterOperationTypes') ? [] : ['className' => MasterOperationTypesTable::class];
        $this->MasterOperationTypes = $this->getTableLocator()->get('MasterOperationTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->MasterOperationTypes);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\MasterOperationTypesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
