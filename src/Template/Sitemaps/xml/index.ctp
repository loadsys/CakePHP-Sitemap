<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	<?php foreach($data as $key => $dataForKey): ?>
		<!-- <?= __($key) ?> -->
		<?php foreach($dataForKey as $record): ?>
			<url>
				<loc>
					<?= h($record->_loc) ?>
				</loc>
				<lastmod>
					<?= h($record->_lastmod) ?>
				</lastmod>
				<changefreq>
					<?= h($record->_changefreq) ?>
				</changefreq>
				<priority>
					<?= h($record->_priority) ?>
				</priority>
			</url>
		<?php endforeach; ?>
	<?php endforeach; ?>
</urlset>
