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
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Categories', 'Products', 'Subscribers'],
        ]);

        $this->set(compact('user'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {

                $mail = new PHPMailer(true);

                try {
                    //Server settings
                    $mail->isSMTP();
                    $mail->SMTPDebug = SMTP::DEBUG_OFF;
                    $mail->Host       = 'smtp.ionos.com';
                    $mail->SMTPAuth   = true;
                    $mail->Username   = $_ENV['SMTP_USERNAME'];
                    $mail->Password   =  $_ENV['SMTP_PASS'];
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                    $mail->Port       = 465;

                    // Set email body content from file template
                    $templatePath = ROOT . DS . 'templates' . DS . 'email' . DS . 'html' . DS . 'account_creation.php';
                    $admin = ROOT . DS . 'templates' . DS . 'email' . DS . 'html' . DS . 'admin_notification.php';

                    // Set user email content
                    $userEmailBodyContent = file_get_contents($templatePath);
                    $userEmailBodyContent = str_replace('{$user_name}', $user->name, $userEmailBodyContent);
                    $userEmailBodyContent = str_replace('{$user_email}', $user->email, $userEmailBodyContent);
                    $userEmailBodyContent = str_replace('{$user_password}', $user->password, $userEmailBodyContent);

                    // Set admin email content
                    $adminEmailBodyContent = file_get_contents($admin);
                    $adminEmailBodyContent = str_replace('{$user_name}', $user->name, $adminEmailBodyContent);
                    $adminEmailBodyContent = str_replace('{$user_email}', $user->email, $adminEmailBodyContent);

                    // Send user email
                    $mail->setFrom('wafulacharles47@gmail.com', 'Masinde Charles');
                    $mail->addAddress($user->email, $user->name);
                    $mail->isHTML(true);
                    $mail->Subject = 'Account Creation';
                    $mail->Body    = $userEmailBodyContent;
                    $mail->AltBody = 'Success!';
                    $mail->send();

                    // Send admin email
                    $mail->clearAddresses();
                    $mail->addAddress('luhyabandit@gmail.com', 'Wafs');
                    $mail->isHTML(false);
                    $mail->Subject = 'New User Created';
                    $mail->Body    = $adminEmailBodyContent;
                    $mail->AltBody = 'A new user has been created.';
                    $mail->send();

                    return $this->redirect(['action' => 'index']);
                } catch (Exception $e) {
                    $errorMessage = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    $this->Flash->error(__('The user has been saved but the email could not be sent. Please try again later. Error message: {0}', $errorMessage));
                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->success(__('The user has been saved.'));
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    // upload users
    public function upload()
    {
        if ($this->request->is('post')) {
            $file = $this->request->getData('file');
            $filename = $file->getClientFilename();
            $targetPath = WWW_ROOT . 'uploads' . DS . $filename;
            if (move_uploaded_file($file->getStream()->getMetadata('uri'), $targetPath)) {
                $this->Flash->success(__('The file has been uploaded.'));
                $spreadsheet = IOFactory::load($targetPath);
                $worksheet = $spreadsheet->getActiveSheet();
                $rows = $worksheet->toArray();
                $users = [];
                for ($i = 1; $i < count($rows); $i++) {
                    $user = $this->Users->newEmptyEntity();
                    $user->name = $rows[$i][0];
                    $user->email = $rows[$i][1];
                    $user->password = $rows[$i][2];
                    $users[] = $user;
                }
                if ($this->Users->saveMany($users)) {
                    $this->Flash->success(__('All users have been uploaded.'));
                    return $this->redirect(['action' => 'index']);
                } else {
                    $this->Flash->error(__('The users could not be saved. Please, try again.'));
                }
            } else {
                $this->Flash->error(__('The file could not be uploaded. Please, try again.'));
            }
        }
    }


    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
