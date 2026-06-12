<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MasterIcd10Table;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MasterIcd10Table Test Case
 */
class MasterIcd10TableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MasterIcd10Table
     */
    protected $MasterIcd10;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.MasterIcd10',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('MasterIcd10') ? [] : ['className' => MasterIcd10Table::class];
        $this->MasterIcd10 = $this->getTableLocator()->get('MasterIcd10', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->MasterIcd10);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\MasterIcd10Table::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\MasterIcd10Table::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
