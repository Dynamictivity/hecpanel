<div class="row">
	<div class="container">
		<h2><?php echo __('Please Select a Game'); ?></h2>
	</div>
</div>
<?php foreach ($games as $gameId => $gameName) : ?>
	<div class="row">
		<div class="container">
			<span>
				<?php echo $this->Html->link('<button type="button" class="btn btn-primary select-button">' . $gameName . '</button>', array('action' => 'add', $gameId), array('escape' => false, 'title' => $gameName)); ?>
			</span>
		</div>
	</div>
<?php endforeach; ?>