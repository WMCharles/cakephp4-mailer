<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\UserPayrollDetail $userPayrollDetail
 * @var string[]|\Cake\Collection\CollectionInterface $users
 * @var string[]|\Cake\Collection\CollectionInterface $payrollCodes
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $userPayrollDetail->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $userPayrollDetail->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List User Payroll Details'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="userPayrollDetails form content">
            <?= $this->Form->create($userPayrollDetail) ?>
            <fieldset>
                <legend><?= __('Edit User Payroll Detail') ?></legend>
                <?php
                    echo $this->Form->control('user_id', ['options' => $users]);
                    echo $this->Form->control('payroll_code_id', ['options' => $payrollCodes]);
                    echo $this->Form->control('amount');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
