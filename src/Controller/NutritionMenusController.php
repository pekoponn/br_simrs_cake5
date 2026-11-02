<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * NutritionMenus Controller
 *
 * @property \App\Model\Table\NutritionMenusTable $NutritionMenus
 * @method \App\Model\Entity\NutritionMenu[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class NutritionMenusController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();

        $this->NutritionMenus = $this->fetchTable('NutritionMenus');
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $nutritionMenus = $this->paginate($this->NutritionMenus);

        $this->set(compact('nutritionMenus'));
    }

    /**
     * View method
     *
     * @param string|null $id Nutrition Menu id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $nutritionMenu = $this->NutritionMenus->get($id, contain: []);

        $this->set(compact('nutritionMenu'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $nutritionMenu = $this->NutritionMenus->newEmptyEntity();
        if ($this->request->is('post')) {
            $nutritionMenu = $this->NutritionMenus->patchEntity($nutritionMenu, $this->request->getData());
            if ($this->NutritionMenus->save($nutritionMenu)) {
                $this->Flash->success(__('The nutrition menu has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The nutrition menu could not be saved. Please, try again.'));
        }
        $this->set(compact('nutritionMenu'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Nutrition Menu id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $nutritionMenu = $this->NutritionMenus->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $nutritionMenu = $this->NutritionMenus->patchEntity($nutritionMenu, $this->request->getData());
            if ($this->NutritionMenus->save($nutritionMenu)) {
                $this->Flash->success(__('The nutrition menu has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The nutrition menu could not be saved. Please, try again.'));
        }
        $this->set(compact('nutritionMenu'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Nutrition Menu id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $nutritionMenu = $this->NutritionMenus->get($id);
        if ($this->NutritionMenus->delete($nutritionMenu)) {
            $this->Flash->success(__('The nutrition menu has been deleted.'));
        } else {
            $this->Flash->error(__('The nutrition menu could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
