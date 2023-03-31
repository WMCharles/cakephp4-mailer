<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\UserPayrollDetail> $userPayrollDetails
 */
?>
<div class="userPayrollDetails index content">
    <?= $this->Html->link(__('New User Payroll Detail'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('User Payroll Details') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('payroll_code_id') ?></th>
                    <th><?= $this->Paginator->sort('amount') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($userPayrollDetails as $userPayrollDetail): ?>
                <tr>
                    <td><?= $this->Number->format($userPayrollDetail->id) ?></td>
                    <td><?= $userPayrollDetail->has('user') ? $this->Html->link($userPayrollDetail->user->name, ['controller' => 'Users', 'action' => 'view', $userPayrollDetail->user->id]) : '' ?></td>
                    <td><?= $userPayrollDetail->has('payroll_code') ? $this->Html->link($userPayrollDetail->payroll_code->name, ['controller' => 'PayrollCodes', 'action' => 'view', $userPayrollDetail->payroll_code->id]) : '' ?></td>
                    <td><?= $this->Number->format($userPayrollDetail->amount) ?></td>
                    <td><?= h($userPayrollDetail->created) ?></td>
                    <td><?= h($userPayrollDetail->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $userPayrollDetail->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $userPayrollDetail->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $userPayrollDetail->id], ['confirm' => __('Are you sure you want to delete # {0}?', $userPayrollDetail->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
