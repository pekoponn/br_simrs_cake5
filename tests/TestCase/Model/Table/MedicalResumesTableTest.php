<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MedicalResumesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MedicalResumesTable Test Case
 */
class MedicalResumesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MedicalResumesTable
     */
    protected $MedicalResumes;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.MedicalResumes',
        'app.OutpatientVisits',
        'app.Registrations',
        'app.Patients',
        'app.Doctor1s',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('MedicalResumes') ? [] : ['className' => MedicalResumesTable::class];
        $this->MedicalResumes = $this->getTableLocator()->get('MedicalResumes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->MedicalResumes);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\MedicalResumesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\MedicalResumesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
