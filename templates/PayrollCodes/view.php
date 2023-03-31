<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PayrollCode $payrollCode
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Payroll Code'), ['action' => 'edit', $payrollCode->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Payroll Code'), ['action' => 'delete', $payrollCode->id], ['confirm' => __('Are you sure you want to delete # {0}?', $payrollCode->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Payroll Codes'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Payroll Code'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="payrollCodes view content">
            <h3><?= h($payrollCode->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($payrollCode->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Code') ?></th>
                    <td><?= h($payrollCode->code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($payrollCode->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($payrollCode->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($payrollCode->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related User Payroll Details') ?></h4>
                <?php if (!empty($payrollCode->user_payroll_details)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Payroll Code Id') ?></th>
                            <th><?= __('Amount') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($payrollCode->user_payroll_details as $userPayrollDetails) : ?>
                        <tr>
                            <td><?= h($userPayrollDetails->id) ?></td>
                            <td><?= h($userPayrollDetails->user_id) ?></td>
                            <td><?= h($userPayrollDetails->payroll_code_id) ?></td>
                            <td><?= h($userPayrollDetails->amount) ?></td>
                            <td><?= h($userPayrollDetails->created) ?></td>
                            <td><?= h($userPayrollDetails->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'UserPayrollDetails', 'action' => 'view', $userPayrollDetails->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'UserPayrollDetails', 'action' => 'edit', $userPayrollDetails->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'UserPayrollDetails', 'action' => 'delete', $userPayrollDetails->id], ['confirm' => __('Are you sure you want to delete # {0}?', $userPayrollDetails->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
