<?php

declare(strict_types=1);

namespace App\Controller;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Import the necessary classes from PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;


//Load Composer's autoloader
require 'vendor/autoload.php';

/**
 * UserPayrollDetails Controller
 *
 * @property \App\Model\Table\UserPayrollDetailsTable $UserPayrollDetails
 * @method \App\Model\Entity\UserPayrollDetail[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UserPayrollDetailsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'PayrollCodes'],
        ];
        $userPayrollDetails = $this->paginate($this->UserPayrollDetails);

        $this->set(compact('userPayrollDetails'));
    }

    /**
     * View method
     *
     * @param string|null $id User Payroll Detail id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $userPayrollDetail = $this->UserPayrollDetails->get($id, [
            'contain' => ['Users', 'PayrollCodes'],
        ]);

        $this->set(compact('userPayrollDetail'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $userPayrollDetail = $this->UserPayrollDetails->newEmptyEntity();
        if ($this->request->is('post')) {
            $userPayrollDetail = $this->UserPayrollDetails->patchEntity($userPayrollDetail, $this->request->getData());
            if ($this->UserPayrollDetails->save($userPayrollDetail)) {
                $this->Flash->success(__('The user payroll detail has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user payroll detail could not be saved. Please, try again.'));
        }
        $users = $this->UserPayrollDetails->Users->find('list', ['limit' => 200])->all();
        $payrollCodes = $this->UserPayrollDetails->PayrollCodes->find('list', ['limit' => 200])->all();
        $this->set(compact('userPayrollDetail', 'users', 'payrollCodes'));
    }

    public function upload2()
    {
        if ($this->request->is('post')) {
            $file = $this->request->getData('file');
            $filename = $file->getClientFilename();
            $targetPath = WWW_ROOT . 'uploads' . DS . $filename;
            if (move_uploaded_file($file->getStream()->getMetadata('uri'), $targetPath)) {
                $spreadsheet = IOFactory::load($targetPath);
                $worksheet = $spreadsheet->getActiveSheet();
                $rows = $worksheet->toArray();

                $userPayrollDetails = [];
                for ($i = 1; $i < count($rows); $i++) {
                    $userId = (int) $rows[$i][0];
                    if (!$userId) {
                        // skip rows with invalid user IDs
                        continue;
                    }
                    $basicSalary = (int) $rows[$i][1];
                    $houseAllowance = (int) $rows[$i][2];

                    $existingBasicSalary = $this->UserPayrollDetails->find()
                        ->where(['user_id' => $userId, 'payroll_code_id' => 1])
                        ->first();
                    if ($existingBasicSalary) {
                        $existingBasicSalary->amount = $basicSalary;
                        $userPayrollDetails[] = $existingBasicSalary;
                    } else {
                        $userPayrollDetail = $this->UserPayrollDetails->newEmptyEntity();
                        $userPayrollDetail->user_id = $userId;
                        $userPayrollDetail->payroll_code_id = 1; // ID of the basic salary code
                        $userPayrollDetail->amount = $basicSalary;
                        $userPayrollDetails[] = $userPayrollDetail;
                    }

                    $existingHouseAllowance = $this->UserPayrollDetails->find()
                        ->where(['user_id' => $userId, 'payroll_code_id' => 2])
                        ->first();
                    if ($existingHouseAllowance) {
                        $existingHouseAllowance->amount = $houseAllowance;
                        $userPayrollDetails[] = $existingHouseAllowance;
                    } else {
                        $userPayrollDetail = $this->UserPayrollDetails->newEmptyEntity();
                        $userPayrollDetail->user_id = $userId;
                        $userPayrollDetail->payroll_code_id = 2; // ID of the house allowance code
                        $userPayrollDetail->amount = $houseAllowance;
                        $userPayrollDetails[] = $userPayrollDetail;
                    }
                }

                $saved = $this->UserPayrollDetails->saveMany($userPayrollDetails);
                if ($saved) {
                    $created = 0;
                    $updated = 0;
                    foreach ($saved as $entity) {
                        if ($entity->isNew()) {
                            $created++;
                        } else {
                            $updated++;
                        }
                    }
                    $this->Flash->success(__('All user payroll details have been uploaded. Created: {0}. Updated: {1}.', $created, $updated));
                } else {
                    $this->Flash->error(__('The user payroll details could not be saved. Please, try again.'));
                }
            } else {
                $this->Flash->error(__('The file could not be uploaded. Please, try again.'));
            }
        }
    }

    public function upload()
    {
        if ($this->request->is('post')) {
            $file = $this->request->getData('file');
            $filename = $file->getClientFilename();
            $targetPath = WWW_ROOT . 'uploads' . DS . $filename;
            if (move_uploaded_file($file->getStream()->getMetadata('uri'), $targetPath)) {
                $spreadsheet = IOFactory::load($targetPath);
                $worksheet = $spreadsheet->getActiveSheet();
                $rows = $worksheet->toArray();

                // Extract payroll code names from first row
                $payrollCodeNames = array_slice($rows[0], 1);

                // Find payroll code IDs
                $payrollCodeIds = [];
                foreach ($payrollCodeNames as $payrollCodeName) {
                    $payrollCode = $this->UserPayrollDetails->PayrollCodes->find()
                        ->where(['name' => $payrollCodeName])
                        ->first();
                    if ($payrollCode) {
                        $payrollCodeIds[] = $payrollCode->id;
                    }
                }
                $userPayrollDetails = [];
                for ($i = 1; $i < count($rows); $i++) {
                    $userName = $rows[$i][0];
                    if (!$userName) {
                        // skip rows with invalid user names
                        continue;
                    }
                    // Get user ID
                    $user = $this->UserPayrollDetails->Users->find()
                        ->where(['name' => $userName])
                        ->first();
                    if (!$user) {
                        // skip rows with unknown user names
                        continue;
                    }
                    $userId = $user->id;
                    // Loop through payroll codes and create user payroll details
                    for ($j = 0; $j < count($payrollCodeIds); $j++) {
                        $payrollCodeId = $payrollCodeIds[$j];
                        $amount = (int) $rows[$i][$j + 1];
                        $existingUserPayrollDetail = $this->UserPayrollDetails->find()
                            ->where(['user_id' => $userId, 'payroll_code_id' => $payrollCodeId])
                            ->first();

                        if ($existingUserPayrollDetail) {
                            $existingUserPayrollDetail->amount = $amount;
                            $userPayrollDetails[] = $existingUserPayrollDetail;
                        } else {
                            $userPayrollDetail = $this->UserPayrollDetails->newEmptyEntity();
                            $userPayrollDetail->user_id = $userId;
                            $userPayrollDetail->payroll_code_id = $payrollCodeId;
                            $userPayrollDetail->amount = $amount;
                            $userPayrollDetails[] = $userPayrollDetail;
                        }
                    }
                }

                $saved = $this->UserPayrollDetails->saveMany($userPayrollDetails);
                if ($saved) {
                    $created = 0;
                    $updated = 0;
                    foreach ($saved as $entity) {
                        if ($entity->isNew()) {
                            $created++;
                        } else {
                            $updated++;
                        }
                    }
                    $this->Flash->success(__('All user payroll details have been uploaded. Created: {0}. Updated: {1}.', $created, $updated));
                } else {
                    $this->Flash->error(__('The user payroll details could not be saved. Please, try again.'));
                }
            } else {
                $this->Flash->error(__('The file could not be uploaded. Please, try again.'));
            }
        }
    }











    /**
     * Edit method
     *
     * @param string|null $id User Payroll Detail id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $userPayrollDetail = $this->UserPayrollDetails->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $userPayrollDetail = $this->UserPayrollDetails->patchEntity($userPayrollDetail, $this->request->getData());
            if ($this->UserPayrollDetails->save($userPayrollDetail)) {
                $this->Flash->success(__('The user payroll detail has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user payroll detail could not be saved. Please, try again.'));
        }
        $users = $this->UserPayrollDetails->Users->find('list', ['limit' => 200])->all();
        $payrollCodes = $this->UserPayrollDetails->PayrollCodes->find('list', ['limit' => 200])->all();
        $this->set(compact('userPayrollDetail', 'users', 'payrollCodes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User Payroll Detail id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $userPayrollDetail = $this->UserPayrollDetails->get($id);
        if ($this->UserPayrollDetails->delete($userPayrollDetail)) {
            $this->Flash->success(__('The user payroll detail has been deleted.'));
        } else {
            $this->Flash->error(__('The user payroll detail could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
