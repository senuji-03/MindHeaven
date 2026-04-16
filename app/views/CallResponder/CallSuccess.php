<?php
$TITLE = 'Call Responder — Call Success & Logs';
$CURRENT_PAGE = 'success';
require BASE_PATH . '/app/views/layouts/header.php';
?>

<style>
	/* ═══ CALL LOGS PAGE ═══════════════════════════════════════ */
	.logs-page {
		max-width: 1200px;
		margin: 0 auto;
		padding: 32px 24px 80px;
	}

	.logs-page-header {
		margin-bottom: 32px;
		border-bottom: 1px solid var(--border);
		padding-bottom: 20px;
	}

	.logs-page-header h1 {
		font-size: 1.75rem;
		font-weight: 700;
		color: var(--text-primary);
		margin: 0 0 8px;
		display: flex;
		align-items: center;
		gap: 12px;
	}

	.logs-page-header h1 i {
		color: var(--success, #4CAF82);
	}

	.logs-page-header p {
		font-size: 0.95rem;
		color: #000;
		margin: 0;
	}

	/* ═══ LOG CARDS ════════════════════════════════════════════ */
	.logs-grid {
		display: grid;
		grid-template-columns: 1fr;
		gap: 20px;
	}

	.log-card {
		background: var(--surface);
		border: 1px solid var(--border);
		border-radius: var(--radius-lg);
		padding: 24px;
		box-shadow: var(--shadow-sm);
		display: flex;
		flex-direction: column;
		gap: 16px;
	}

	.log-card-header {
		display: flex;
		justify-content: space-between;
		align-items: center;
		flex-wrap: wrap;
		gap: 12px;
	}

	.log-caller {
		font-size: 1.1rem;
		font-weight: 700;
		color: var(--text-primary);
		display: flex;
		align-items: center;
		gap: 10px;
	}

	.log-caller i {
		color: var(--primary);
	}

	.log-meta {
		display: flex;
		align-items: center;
		gap: 16px;
		font-size: 0.85rem;
		color: #000;
	}

	.log-badge {
		display: inline-block;
		padding: 4px 10px;
		border-radius: 99px;
		font-size: 0.75rem;
		font-weight: 700;
		text-transform: uppercase;
		letter-spacing: 0.5px;
	}

	.log-badge--completed {
		background: rgba(76, 175, 130, 0.15);
		color: var(--success);
	}

	.log-badge--escalated {
		background: rgba(214, 79, 79, 0.15);
		color: var(--crisis);
	}

	.log-notes-section {
		background: var(--bg-mid);
		border-radius: var(--radius-md);
		padding: 16px;
		border: 1px solid var(--border);
		cursor: pointer;
		transition: background 0.2s;
	}

	.log-notes-section:hover {
		background: #f0f4f4;
	}

	.log-notes-label {
		font-size: 0.82rem;
		font-weight: 700;
		text-transform: uppercase;
		color: #000;
		margin-bottom: 8px;
		display: flex;
		align-items: center;
		justify-content: space-between;
		gap: 6px;
	}

	.log-notes-content {
		font-size: 0.95rem;
		color: #000;
		line-height: 1.6;
		margin: 0;
		white-space: pre-wrap;
		max-height: 100px;
		overflow: hidden;
		transition: max-height 0.3s ease;
	}

	.log-notes-section.expanded .log-notes-content {
		max-height: 2000px;
	}

	/* ═══ EMPTY STATE ══════════════════════════════════════════ */
	.logs-empty {
		text-align: center;
		padding: 60px 20px;
		background: var(--surface);
		border: 2px dashed var(--border);
		border-radius: var(--radius-lg);
		color: var(--text-secondary);
	}

	.logs-empty i {
		font-size: 3rem;
		color: var(--border);
		margin-bottom: 16px;
	}

	.logs-empty h3 {
		font-size: 1.25rem;
		color: var(--text-primary);
		margin-bottom: 8px;
	}
</style>

<div class="logs-page">
	<div class="logs-page-header">
		<h1><i class="fas fa-check-circle"></i> Call Logs & Sucess</h1>
		<p>Review the history and intervention notes from your completed crisis calls.</p>
	</div>

	<?php if (empty($callLogs)): ?>
		<div class="logs-empty">
			<i class="fas fa-folder-open"></i>
			<h3>No call records found</h3>
			<p>You haven't completed any crisis calls yet. When you do, they will appear here.</p>
		</div>
	<?php else: ?>
		<div class="logs-grid">
			<?php foreach ($callLogs as $log): ?>
				<?php
				$dateStr = date('M j, Y - g:i A', strtotime($log['updated_at']));
				$statusClass = $log['status'] === 'escalated' ? 'log-badge--escalated' : 'log-badge--completed';
				$notes = !empty($log['notes']) ? htmlspecialchars($log['notes']) : 'No notes recorded for this session.';
				?>
				<div class="log-card">
					<div class="log-card-header">
						<div class="log-caller">
							<i class="fas fa-user-circle"></i>
							<?= htmlspecialchars($log['caller_name']) ?>
						</div>
						<div class="log-meta">
							<span><i class="far fa-calendar-alt"></i> <?= $dateStr ?></span>
							<span class="log-badge <?= $statusClass ?>"><?= htmlspecialchars($log['status']) ?></span>
						</div>
					</div>

					<div class="log-notes-section" onclick="this.classList.toggle('expanded')">
						<div class="log-notes-label">
							<span><i class="fas fa-file-medical"></i> Responder Intervention Notes</span>
							<span style="font-size:0.7rem; color:var(--primary); font-weight:bold;">Click to
								Expand/Collapse</span>
						</div>
						<div class="log-notes-content"><?= $notes ?></div>
					</div>

					<?php if (!empty($log['counselor_followup_notes'])): ?>
						<div class="log-notes-section" style="border-top: 2px solid #D64F4F; margin-top: 8px;"
							onclick="this.classList.toggle('expanded')">
							<div class="log-notes-label" style="color:#D64F4F;">
								<span><i class="fas fa-user-md"></i> Counselor Follow-up</span>
							</div>
							<div class="log-notes-content"><?= htmlspecialchars($log['counselor_followup_notes']) ?></div>
						</div>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>

<?php require BASE_PATH . '/app/views/layouts/footer.php'; ?>