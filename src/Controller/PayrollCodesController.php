<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * PayrollCodes Controller
 *
 * @property \App\Model\Table\PayrollCodesTable $PayrollCodes
 * @method \App\Model\Entity\PayrollCode[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PayrollCodesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $payrollCodes = $this->paginate($this->PayrollCodes);

        $this->set(compact('payrollCodes'));
    }

    /**
     * View method
     *
     * @param string|null $id Payroll Code id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $payrollCode = $this->PayrollCodes->get($id, [
            'contain' => ['UserPayrollDetails'],
        ]);

        $this->set(compact('payrollCode'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $payrollCode = $this->PayrollCodes->newEmptyEntity();
        if ($this->request->is('post')) {
            $payrollCode = $this->PayrollCodes->patchEntity($payrollCode, $this->request->getData());
            if ($this->PayrollCodes->save($payrollCode)) {
                $this->Flash->success(__('The payroll code has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The payroll code could not be saved. Please, try again.'));
        }
        $this->set(compact('payrollCode'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Payroll Code id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $payrollCode = $this->PayrollCodes->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $payrollCode = $this->PayrollCodes->patchEntity($payrollCode, $this->request->getData());
            if ($this->PayrollCodes->save($payrollCode)) {
                $this->Flash->success(__('The payroll code has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The payroll code could not be saved. Please, try again.'));
        }
        $this->set(compact('payrollCode'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Payroll Code id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $payrollCode = $this->PayrollCodes->get($id);
        if ($this->PayrollCodes->delete($payrollCode)) {
            $this->Flash->success(__('The payroll code has been deleted.'));
        } else {
            $this->Flash->error(__('The payroll code could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
