<h1>
	<?= __('Sitemap') ?>
</h1>

<?php foreach($data as $key => $dataForKey): ?>
	<h2><?= __($key) ?></h2>
	<table>
		<thead>
			<tr>
				<th>
					<?= __('Location') ?>
				</th>
				<th>
					<?= __('Priority') ?>
				</th>
				<th>
					<?= __('Change Frequency') ?>
				</th>
				<th>
					<?= __('Last Modified') ?>
				</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($dataForKey as $record): ?>
				<tr>
					<td>
						<?= h($record->_loc) ?>
					</td>
					<td>
						<?= h($record->_priority) ?>
					</td>
					<td>
						<?= h($record->_changefreq) ?>
					</td>
					<td>
						<?= h($record->_lastmod) ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
<?php endforeach; ?>
