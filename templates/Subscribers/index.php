<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Subscriber> $subscribers
 */
?>
<div class="subscribers index content">
    <?= $this->Html->link(__('New Subscriber'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Subscribers') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($subscribers as $subscriber): ?>
                <tr>
                    <td><?= $this->Number->format($subscriber->id) ?></td>
                    <td><?= h($subscriber->name) ?></td>
                    <td><?= h($subscriber->email) ?></td>
                    <td><?= $subscriber->has('user') ? $this->Html->link($subscriber->user->name, ['controller' => 'Users', 'action' => 'view', $subscriber->user->id]) : '' ?></td>
                    <td><?= h($subscriber->created) ?></td>
                    <td><?= h($subscriber->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $subscriber->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $subscriber->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $subscriber->id], ['confirm' => __('Are you sure you want to delete # {0}?', $subscriber->id)]) ?>
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
