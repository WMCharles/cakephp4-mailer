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
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $payrollCode->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $payrollCode->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Payroll Codes'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="payrollCodes form content">
            <?= $this->Form->create($payrollCode) ?>
            <fieldset>
                <legend><?= __('Edit Payroll Code') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo $this->Form->control('code');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
