<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PolyclinicQueuesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PolyclinicQueuesTable Test Case
 */
class PolyclinicQueuesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PolyclinicQueuesTable
     */
    protected $PolyclinicQueues;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.PolyclinicQueues',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('PolyclinicQueues') ? [] : ['className' => PolyclinicQueuesTable::class];
        $this->PolyclinicQueues = $this->getTableLocator()->get('PolyclinicQueues', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->PolyclinicQueues);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\PolyclinicQueuesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
