<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MasterSupportsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MasterSupportsTable Test Case
 */
class MasterSupportsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MasterSupportsTable
     */
    protected $MasterSupports;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.MasterSupports',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('MasterSupports') ? [] : ['className' => MasterSupportsTable::class];
        $this->MasterSupports = $this->getTableLocator()->get('MasterSupports', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->MasterSupports);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\MasterSupportsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
