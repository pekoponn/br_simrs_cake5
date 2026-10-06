<?php

declare(strict_types=1);

namespace App\Controller\Hr;

use App\Controller\AppController;

/**
 * HrgaHolidays Controller
 *
 * @property \App\Model\Table\HrgaHolidaysTable $HrgaHolidays
 * @method \App\Model\Entity\HrgaHoliday[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class HrgaHolidaysController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $holiday = $this->HrgaHolidays->find('all');
        $key = $this->request->getQuery('key');
        if ($key) {
            $queries = $holiday->where(['OR' => ['HrgaHolidays.description like' => '%' . $key . '%']]);
        } else {
            $queries = $holiday;
        }
        $dataRow = $queries->order(['HrgaHolidays.date' => 'DESC']);
        $this->set('holiday', $this->paginate($dataRow, ['limit' => '10']));
    }

    /**
     * View method
     *
     * @param string|null $id Hrga Holiday id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $hrgaHoliday = $this->HrgaHolidays->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('hrgaHoliday'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $date = $this->request->getData('date');
        $desc = $this->request->getData('desc');
        $user = $this->request->getData('user');

        $hrgaHoliday = $this->HrgaHolidays->newEmptyEntity();
        if ($this->request->is('post')) {

            $isUser = $user;
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N',  $isUser, "Hrga Holidays add");
            $hrgaHoliday = $this->HrgaHolidays->patchEntity($hrgaHoliday, ['is_create' => $user, 'is_log' => $auditLog, 'date' => $date, 'description' => $desc]);

            if ($this->HrgaHolidays->save($hrgaHoliday)) {
                $response = array('status' => 'success');
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            } else {
                $response = array('status' => 'error');
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }
        }

        $list = $this->HrgaHolidays->find('all')->toList();

        $data = array();
        foreach ($list as $index => $value) {
           $data[$index]['title'] = $value->description;
           $data[$index]['start'] = $value->date;           
        }
       $this->set(['data' => json_encode($data)]);
    }

    /**
     * Edit method
     *
     * @param string|null $id Hrga Holiday id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {                
        $desc = $this->request->getData('desc');
        $user = $this->request->getData('user');

        $hrgaHoliday = $this->HrgaHolidays->get($id, [
            'contain' => [],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {

            $isUser = $user;
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), $id,  $isUser, "Hrga Holidays edit");
            $hrgaHoliday = $this->HrgaHolidays->patchEntity($hrgaHoliday, ['is_update' => $user, 'is_log' => $auditLog, 'description' => $desc]);            
            if ($this->HrgaHolidays->save($hrgaHoliday)) {
                $response = array('status' => 'success');
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            } else {
                $response = array('status' => 'error');
                return $this->response->withType("application/json")->withStringBody(json_encode($response));
            }
        }

        $list = $this->HrgaHolidays->find('all')->toList();

        $data = array();
        foreach ($list as $index => $value) {
           $data[$index]['title'] = $value->description;
           $data[$index]['start'] = $value->date;           
        }
       $this->set(['data' => json_encode($data), 'hrgaHoliday' => $hrgaHoliday]);
      
      

        //     $dataRow = $this->request->getData();
        //     $isUser = $dataRow['is_update'];
        //     $auditLog = $this->Krs->auditLog("Hrga Holidays", 'N', $this->request->getParam('controller'),  $isUser, "Hrga Holidays edit");
        //     $dataAuditLog = array('is_log' => $auditLog);
        //     $date1 = array('date' => $this->Krs->dateTo($dataRow['date']));

        //     $hrgaHoliday = $this->HrgaHolidays->patchEntity($hrgaHoliday, array_merge($dataRow, $dataAuditLog, $date1));
        //     if ($this->HrgaHolidays->save($hrgaHoliday)) {
        //         $this->Flash->success(__('The hrga holiday has been saved.'));

        //         return $this->redirect(['action' => 'index']);
        //     }
        //     $this->Flash->error(__('The hrga holiday could not be saved. Please, try again.'));
        // }
        // $this->set(compact('hrgaHoliday'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Hrga Holiday id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $hrgaHoliday = $this->HrgaHolidays->get($id);
        if ($this->HrgaHolidays->delete($hrgaHoliday)) {
            $this->Flash->success(__('The hrga holiday has been deleted.'));
        } else {
            $this->Flash->error(__('The hrga holiday could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
