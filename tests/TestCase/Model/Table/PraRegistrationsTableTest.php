<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PraRegistrationsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PraRegistrationsTable Test Case
 */
class PraRegistrationsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PraRegistrationsTable
     */
    protected $PraRegistrations;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.PraRegistrations',
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
        $config = $this->getTableLocator()->exists('PraRegistrations') ? [] : ['className' => PraRegistrationsTable::class];
        $this->PraRegistrations = $this->getTableLocator()->get('PraRegistrations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->PraRegistrations);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\PraRegistrationsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\PraRegistrationsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
