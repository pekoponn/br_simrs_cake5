<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DaerahKelurahansTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DaerahKelurahansTable Test Case
 */
class DaerahKelurahansTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DaerahKelurahansTable
     */
    protected $DaerahKelurahans;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.DaerahKelurahans',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('DaerahKelurahans') ? [] : ['className' => DaerahKelurahansTable::class];
        $this->DaerahKelurahans = $this->getTableLocator()->get('DaerahKelurahans', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->DaerahKelurahans);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\DaerahKelurahansTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
