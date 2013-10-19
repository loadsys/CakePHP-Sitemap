<?php foreach($sitemapData as $model => $modelSitemap): ?>
	<h2><?php echo $model; ?></h2>
	<?php foreach($modelSitemap as $singleSitemap): ?>
		<dl>
			<dt><?php echo __('Location'); ?>: </dt>
			<dd><?php echo $this->Html->link(Router::url($singleSitemap['loc'], TRUE)); ?></dd>

			<?php if(!empty($singleSitemap['lastmod'])): ?>
				<dt><?php echo __('Last Modified'); ?>: </dt>
				<dd><?php echo $this->Time->toAtom($singleSitemap['lastmod']); ?></dd>
			<?php endif; ?>

			<?php if(!empty($singleSitemap['priority'])): ?>
				<dt><?php echo __('Priority'); ?>: </dt>
				<dd><?php echo $singleSitemap['priority']; ?></dd>
			<?php endif; ?>

			<?php if(!empty($singleSitemap['changefreq'])): ?>
				<dt><?php echo __('Change Frequency'); ?>:</dt>
				<dd><?php echo $singleSitemap['changefreq']; ?></dd>
			<?php endif; ?>

		</dl>
	<?php endforeach; ?>
<?php endforeach; ?>