<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\UserPayrollDetail $userPayrollDetail
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit User Payroll Detail'), ['action' => 'edit', $userPayrollDetail->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete User Payroll Detail'), ['action' => 'delete', $userPayrollDetail->id], ['confirm' => __('Are you sure you want to delete # {0}?', $userPayrollDetail->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List User Payroll Details'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New User Payroll Detail'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="userPayrollDetails view content">
            <h3><?= h($userPayrollDetail->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $userPayrollDetail->has('user') ? $this->Html->link($userPayrollDetail->user->name, ['controller' => 'Users', 'action' => 'view', $userPayrollDetail->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Payroll Code') ?></th>
                    <td><?= $userPayrollDetail->has('payroll_code') ? $this->Html->link($userPayrollDetail->payroll_code->name, ['controller' => 'PayrollCodes', 'action' => 'view', $userPayrollDetail->payroll_code->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($userPayrollDetail->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Amount') ?></th>
                    <td><?= $this->Number->format($userPayrollDetail->amount) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($userPayrollDetail->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($userPayrollDetail->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
