<?php $this->pageTitle=Yii::app()->name . ' - '.MessageModule::t("Messages:inbox"); ?>
<?php
	$this->breadcrumbs=array(
		MessageModule::t("Inbox"),
	);
?>

<?php $this->renderPartial(Yii::app()->getModule('message')->viewPath . '/_styles') ?>
<?php $this->renderPartial(Yii::app()->getModule('message')->viewPath . '/_flash') ?>
<div class="row">
	<?php $this->renderPartial(Yii::app()->getModule('message')->viewPath . '/_navigation') ?>
	<div class="span13">
		<h2><?= MessageModule::t('Inbox'); ?></h2>

		<?php if ($messagesAdapter->data): ?>
			<?php $form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
				'id'=>'message-delete-form',
				'enableAjaxValidation'=>true,
				'action' => $this->createUrl('delete/')
			)); ?>

			<table class="bordered-table zebra-striped">
				<tr>
					<th class="from-to">From</th>
					<th>Subject</th>
					<th>Date</th>
				</tr>
				<?php foreach ($messagesAdapter->data as $index => $message): ?>
					<tr class="<?= $message->is_read ? 'read' : 'unread' ?>">
						<td style="width:auto">
							<?= CHtml::checkBox("Message[$index][selected]"); ?>
							<?= $form->hiddenField($message,"[$index]id"); ?>
							<?= $message->getSenderName(); ?>
						</td>
						<td><a href="<?= $this->createUrl('view/', 
						array('message_id' => $message->id)) ?>">
						<?= $message->subject ?></a></td>
						<td><span class="date">
						<?= date(Yii::app()->getModule('message')->dateFormat,
							strtotime($message->created_at)) ?></span></td>
					</tr>
				<?php endforeach ?>
			</table>

			<div>
				<button class="btn btn-danger">
					<i class="icon-white icon-remove"></i>
					<?= MessageModule::t("Delete Selected"); ?>
				</button>
			</div>

		<?php $this->endWidget(); ?>
		<div class="pagination">
			<?php 
				$this->widget('CLinkPager', 
					array('header' => '', 
					'pages' => $messagesAdapter->getPagination(), 
					'htmlOptions' => array('class' => 'pager'))); 
			?>
		</div>
		<?php endif; ?>
	</div>
</div>
