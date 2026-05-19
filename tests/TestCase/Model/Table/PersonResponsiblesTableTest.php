<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PersonResponsiblesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PersonResponsiblesTable Test Case
 */
class PersonResponsiblesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PersonResponsiblesTable
     */
    protected $PersonResponsibles;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.PersonResponsibles',
        'app.Registrations',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('PersonResponsibles') ? [] : ['className' => PersonResponsiblesTable::class];
        $this->PersonResponsibles = $this->getTableLocator()->get('PersonResponsibles', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->PersonResponsibles);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\PersonResponsiblesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\PersonResponsiblesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
