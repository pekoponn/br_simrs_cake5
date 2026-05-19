<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DaerahKecamatansTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DaerahKecamatansTable Test Case
 */
class DaerahKecamatansTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DaerahKecamatansTable
     */
    protected $DaerahKecamatans;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.DaerahKecamatans',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('DaerahKecamatans') ? [] : ['className' => DaerahKecamatansTable::class];
        $this->DaerahKecamatans = $this->getTableLocator()->get('DaerahKecamatans', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->DaerahKecamatans);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\DaerahKecamatansTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
