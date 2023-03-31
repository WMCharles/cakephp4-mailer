<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\PayrollCode> $payrollCodes
 */
?>
<div class="payrollCodes index content">
    <?= $this->Html->link(__('New Payroll Code'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Payroll Codes') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('code') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($payrollCodes as $payrollCode): ?>
                <tr>
                    <td><?= $this->Number->format($payrollCode->id) ?></td>
                    <td><?= h($payrollCode->name) ?></td>
                    <td><?= h($payrollCode->code) ?></td>
                    <td><?= h($payrollCode->created) ?></td>
                    <td><?= h($payrollCode->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $payrollCode->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $payrollCode->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $payrollCode->id], ['confirm' => __('Are you sure you want to delete # {0}?', $payrollCode->id)]) ?>
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
