<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OutpatientVisitEmrTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OutpatientVisitEmrTable Test Case
 */
class OutpatientVisitEmrTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\OutpatientVisitEmrTable
     */
    protected $OutpatientVisitEmr;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.OutpatientVisitEmr',
        'app.OutpatientVisits',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('OutpatientVisitEmr') ? [] : ['className' => OutpatientVisitEmrTable::class];
        $this->OutpatientVisitEmr = $this->getTableLocator()->get('OutpatientVisitEmr', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->OutpatientVisitEmr);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\OutpatientVisitEmrTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\OutpatientVisitEmrTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
