<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\PatientHistoriesController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\PatientHistoriesController Test Case
 *
 * @uses \App\Controller\PatientHistoriesController
 */
class PatientHistoriesControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.PatientHistories',
        'app.Registrations',
        'app.PatientHistoryDocuments',
        'app.PatientHistoryExaminations',
        'app.PatientHistoryIcares',
        'app.PatientHistoryIntegrations',
        'app.PatientHistoryLaboratories',
        'app.PatientHistoryPrescriptions',
        'app.PatientHistoryRadiologies',
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\PatientHistoriesController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\PatientHistoriesController::view()
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\PatientHistoriesController::add()
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\PatientHistoriesController::edit()
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\PatientHistoriesController::delete()
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
