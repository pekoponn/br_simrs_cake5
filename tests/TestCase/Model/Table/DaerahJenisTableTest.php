<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DaerahJenisTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DaerahJenisTable Test Case
 */
class DaerahJenisTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DaerahJenisTable
     */
    protected $DaerahJenis;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.DaerahJenis',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('DaerahJenis') ? [] : ['className' => DaerahJenisTable::class];
        $this->DaerahJenis = $this->getTableLocator()->get('DaerahJenis', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->DaerahJenis);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\DaerahJenisTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
