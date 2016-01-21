<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	<url>
		<loc><?php echo Router::url('/', TRUE); ?></loc>
		<changefreq>daily</changefreq>
		<priority>1.0</priority>
	</url>
	<?php foreach($sitemapData as $model => $modelSitemap): ?>
		<!-- <?php echo $model; ?> -->
		<?php foreach($modelSitemap as $singleSitemap): ?>
			<url>
				<loc><?php echo Router::url($singleSitemap['loc'], TRUE); ?></loc>
				<?php if(!empty($singleSitemap['lastmod'])): ?>
					<lastmod><?php echo $this->Time->toAtom($singleSitemap['lastmod']); ?></lastmod>
				<?php endif; ?>
				<?php if(!empty($singleSitemap['priority'])): ?>
					<priority><?php echo $singleSitemap['priority']; ?></priority>
				<?php endif; ?>
				<?php if(!empty($singleSitemap['changefreq'])): ?>
					<changefreq><?php echo $singleSitemap['changefreq']; ?></changefreq>
				<?php endif; ?>
			</url>
		<?php endforeach; ?>
	<?php endforeach; ?>
</urlset>