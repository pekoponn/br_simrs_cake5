<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\OutpatientLettersController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\OutpatientLettersController Test Case
 *
 * @uses \App\Controller\OutpatientLettersController
 */
class OutpatientLettersControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.OutpatientLetters',
        'app.OutpatientVisits',
        'app.Registrations',
        'app.Patients',
        'app.Doctors',
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\OutpatientLettersController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\OutpatientLettersController::view()
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\OutpatientLettersController::add()
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\OutpatientLettersController::edit()
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\OutpatientLettersController::delete()
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
