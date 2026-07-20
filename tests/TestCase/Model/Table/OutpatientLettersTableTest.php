<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OutpatientLettersTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OutpatientLettersTable Test Case
 */
class OutpatientLettersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\OutpatientLettersTable
     */
    protected $OutpatientLetters;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.OutpatientLetters',
        'app.OutpatientVisits',
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
        $config = $this->getTableLocator()->exists('OutpatientLetters') ? [] : ['className' => OutpatientLettersTable::class];
        $this->OutpatientLetters = $this->getTableLocator()->get('OutpatientLetters', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->OutpatientLetters);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\OutpatientLettersTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\OutpatientLettersTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
