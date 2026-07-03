<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MasterPatientReferrersTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MasterPatientReferrersTable Test Case
 */
class MasterPatientReferrersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MasterPatientReferrersTable
     */
    protected $MasterPatientReferrers;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.MasterPatientReferrers',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('MasterPatientReferrers') ? [] : ['className' => MasterPatientReferrersTable::class];
        $this->MasterPatientReferrers = $this->getTableLocator()->get('MasterPatientReferrers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->MasterPatientReferrers);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\MasterPatientReferrersTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
