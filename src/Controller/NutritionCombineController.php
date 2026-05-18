<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * NutritionCombine Controller
 *
 * @property \App\Model\Table\NutritionCombineTable $NutritionCombine
 * @method \App\Model\Entity\NutritionCombine[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class NutritionCombineController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();

        $this->loadModel('NutritionCombine');
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $nutritionCombine = $this->paginate($this->NutritionCombine);

        $this->set(compact('nutritionCombine'));
    }

    /**
     * View method
     *
     * @param string|null $id Nutrition Combine id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $nutritionCombine = $this->NutritionCombine->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('nutritionCombine'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $nutritionCombine = $this->NutritionCombine->newEmptyEntity();
        if ($this->request->is('post')) {
            $nutritionCombine = $this->NutritionCombine->patchEntity($nutritionCombine, $this->request->getData());
            if ($this->NutritionCombine->save($nutritionCombine)) {
                $this->Flash->success(__('The nutrition combine has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The nutrition combine could not be saved. Please, try again.'));
        }
        $this->set(compact('nutritionCombine'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Nutrition Combine id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $nutritionCombine = $this->NutritionCombine->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $nutritionCombine = $this->NutritionCombine->patchEntity($nutritionCombine, $this->request->getData());
            if ($this->NutritionCombine->save($nutritionCombine)) {
                $this->Flash->success(__('The nutrition combine has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The nutrition combine could not be saved. Please, try again.'));
        }
        $this->set(compact('nutritionCombine'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Nutrition Combine id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $nutritionCombine = $this->NutritionCombine->get($id);
        if ($this->NutritionCombine->delete($nutritionCombine)) {
            $this->Flash->success(__('The nutrition combine has been deleted.'));
        } else {
            $this->Flash->error(__('The nutrition combine could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
