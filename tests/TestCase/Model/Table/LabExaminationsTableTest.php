<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LabExaminationsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LabExaminationsTable Test Case
 */
class LabExaminationsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LabExaminationsTable
     */
    protected $LabExaminations;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.LabExaminations',
        'app.Registrations',
        'app.Patients',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('LabExaminations') ? [] : ['className' => LabExaminationsTable::class];
        $this->LabExaminations = $this->getTableLocator()->get('LabExaminations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->LabExaminations);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\LabExaminationsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\LabExaminationsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
