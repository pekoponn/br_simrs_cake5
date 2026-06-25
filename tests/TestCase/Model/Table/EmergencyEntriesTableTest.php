<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EmergencyEntriesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EmergencyEntriesTable Test Case
 */
class EmergencyEntriesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EmergencyEntriesTable
     */
    protected $EmergencyEntries;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.EmergencyEntries',
        'app.Registrations',
        'app.Patients',
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
        $config = $this->getTableLocator()->exists('EmergencyEntries') ? [] : ['className' => EmergencyEntriesTable::class];
        $this->EmergencyEntries = $this->getTableLocator()->get('EmergencyEntries', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->EmergencyEntries);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\EmergencyEntriesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\EmergencyEntriesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
