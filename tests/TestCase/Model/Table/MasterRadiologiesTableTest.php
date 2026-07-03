<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MasterRadiologiesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MasterRadiologiesTable Test Case
 */
class MasterRadiologiesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MasterRadiologiesTable
     */
    protected $MasterRadiologies;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.MasterRadiologies',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('MasterRadiologies') ? [] : ['className' => MasterRadiologiesTable::class];
        $this->MasterRadiologies = $this->getTableLocator()->get('MasterRadiologies', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->MasterRadiologies);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\MasterRadiologiesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
