<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DoctorScheduleQuotaHistoriesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DoctorScheduleQuotaHistoriesTable Test Case
 */
class DoctorScheduleQuotaHistoriesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DoctorScheduleQuotaHistoriesTable
     */
    protected $DoctorScheduleQuotaHistories;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.DoctorScheduleQuotaHistories',
        'app.DoctorSchedules',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('DoctorScheduleQuotaHistories') ? [] : ['className' => DoctorScheduleQuotaHistoriesTable::class];
        $this->DoctorScheduleQuotaHistories = $this->getTableLocator()->get('DoctorScheduleQuotaHistories', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->DoctorScheduleQuotaHistories);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\DoctorScheduleQuotaHistoriesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\DoctorScheduleQuotaHistoriesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
