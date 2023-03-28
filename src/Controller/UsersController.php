<?php

declare(strict_types=1);

namespace App\Controller;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

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
    // public function add()
    // {
    //     $user = $this->Users->newEmptyEntity();
    //     if ($this->request->is('post')) {
    //         $user = $this->Users->patchEntity($user, $this->request->getData());
    //         if ($this->Users->save($user)) {

    //             $mail = new PHPMailer(true);

    //             try {
    //                 //Server settings
    //                 $mail->isSMTP();                                            //Send using SMTP
    //                 $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    //                 $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    //                 $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    //                 $mail->Username   = 'wafulacharles47@gmail.com';                     //SMTP username
    //                 $mail->Password   = 'totnzlfqpbyehmyo';                               //SMTP password
    //                 $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    //                 $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //                 //Recipients
    //                 $mail->setFrom('wafulacharles47@gmail.com', 'Masinde Charles');
    //                 $mail->addAddress($user->email, $user->name);     //Add a recipient
    //                 // $mail->addAddress('ellen@example.com');               //Name is optional
    //                 // $mail->addReplyTo('info@example.com', 'Information');
    //                 // $mail->addCC('cc@example.com');
    //                 // $mail->addBCC('bcc@example.com');

    //                 //Attachments
    //                 // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    //                 // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //                 //Content
    //                 $mail->isHTML(true);                                  //Set email format to HTML
    //                 $mail->Subject = 'Account Creation';
    //                 $mail->Body    = 'Your account has successfully been created. Your email is: ' . $user->email . 'and password is: ' . $users->password;
    //                 $mail->AltBody = 'Success!';

    //                 $mail->send();
    //                 $this->Flash->success(__('The user has been saved.'));
    //                 return $this->redirect(['action' => 'index']);
    //             } catch (Exception $e) {
    //                 $errorMessage = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    //                 $this->Flash->error(__('The user has been saved but the email could not be sent. Please try again later. Error message: {0}', $errorMessage));
    //                 return $this->redirect(['action' => 'index']);
    //             }
    //         }
    //         $this->Flash->error(__('The user could not be saved. Please, try again.'));
    //     }
    //     $this->set(compact('user'));
    // }
    public function add()
    {
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {

                $mail = new PHPMailer(true);

                try {
                    //Server settings
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    $mail->Username   = 'wafulacharles47@gmail.com';                     //SMTP username
                    $mail->Password   = 'totnzlfqpbyehmyo';                               //SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                    //Recipients
                    $mail->setFrom('wafulacharles47@gmail.com', 'Masinde Charles');
                    $mail->addAddress($user->email, $user->name);     //Add a recipient

                    // Set email body content from file template
                    $templatePath = ROOT . DS . 'templates' . DS . 'email' . DS . 'html' . DS . 'account_creation.php';

                    $emailBodyContent = file_get_contents($templatePath);
                    $emailBodyContent = str_replace('{$user_name}', $user->name, $emailBodyContent);
                    $emailBodyContent = str_replace('{$user_email}', $user->email, $emailBodyContent);
                    $emailBodyContent = str_replace('{$user_password}', $user->password, $emailBodyContent);

                    // Set email properties
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'Account Creation';
                    $mail->Body    = $emailBodyContent;
                    $mail->AltBody = 'Success!';

                    // Send email
                    $mail->send();
                    $this->Flash->success(__('The user has been saved.'));
                    return $this->redirect(['action' => 'index']);
                } catch (Exception $e) {
                    $errorMessage = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    $this->Flash->error(__('The user has been saved but the email could not be sent. Please try again later. Error message: {0}', $errorMessage));
                    return $this->redirect(['action' => 'index']);
                }
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
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
