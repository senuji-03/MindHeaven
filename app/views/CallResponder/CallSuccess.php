<?php
$TITLE = 'Call Responder — Call Success & Logs';
$CURRENT_PAGE = 'success';
require BASE_PATH . '/app/views/layouts/header.php';
?>

<style>
/* ── PAGE LAYOUT ── */
.logs-page {
	max-width: 1200px;
	margin: 0 auto;
	padding: 40px 24px 100px;
}

.logs-page-header {
	margin-bottom: 48px;
}

.logs-page-header h1 {
	font-size: 2.2rem;
	font-weight: 700;
	color: var(--text-primary);
	margin: 0 0 12px;
	letter-spacing: -0.5px;
	display: flex;
	align-items: center;
	gap: 16px;
}

.logs-page-header h1 i {
	color: var(--success);
}

.logs-page-header p {
	font-size: 1rem;
	color: var(--text-secondary);
	max-width: 600px;
	line-height: 1.7;
	margin: 0;
}

/* ── LOG CARDS (Standardized .card) ── */
.logs-grid {
	display: grid;
	grid-template-columns: 1fr;
	gap: 24px;
}

.log-card {
	background: var(--surface);
	border: 1px solid var(--border);
	border-radius: var(--radius-lg);
	padding: 28px 24px;
	box-shadow: var(--shadow-sm);
	display: flex;
	flex-direction: column;
	gap: 20px;
	transition: all 0.3s ease;
}

.log-card:hover {
	transform: translateY(-2px);
	box-shadow: var(--shadow-md);
}

.log-card-header {
	display: flex;
	justify-content: space-between;
	align-items: center;
	flex-wrap: wrap;
	gap: 16px;
	padding-bottom: 4px;
}

.log-caller {
	font-size: 1.15rem;
	font-weight: 700;
	color: var(--text-primary);
	display: flex;
	align-items: center;
	gap: 12px;
}

.log-caller i {
	color: var(--primary);
	font-size: 1.4rem;
}

.log-meta {
	display: flex;
	align-items: center;
	gap: 20px;
	font-size: 0.88rem;
	color: var(--text-secondary);
	font-weight: 500;
}

.log-badge {
	display: inline-flex;
	align-items: center;
	padding: 6px 14px;
	border-radius: var(--radius-full);
	font-size: 0.75rem;
	font-weight: 700;
	text-transform: uppercase;
	letter-spacing: 1px;
}

.log-badge--completed {
	background: var(--bg-mid);
	color: var(--success);
	border: 1px solid rgba(76, 175, 130, 0.2);
}

.log-badge--escalated {
	background: rgba(214, 79, 79, 0.08);
	color: var(--crisis);
	border: 1px solid rgba(214, 79, 79, 0.2);
}

/* ── EXPANDABLE SECTIONS ── */
.log-notes-section {
	background: var(--bg-soft);
	border-radius: var(--radius-md);
	padding: 20px;
	border: 1.5px solid transparent;
	cursor: pointer;
	transition: all 0.25s ease;
}

.log-notes-section:hover {
	background: var(--surface);
	border-color: var(--primary-light);
	box-shadow: var(--shadow-sm);
}

.log-notes-label {
	font-size: 0.82rem;
	font-weight: 700;
	text-transform: uppercase;
	letter-spacing: 1px;
	color: var(--primary);
	margin-bottom: 12px;
	display: flex;
	align-items: center;
	justify-content: space-between;
	gap: 8px;
}

.log-notes-content {
	font-size: 0.95rem;
	color: var(--text-primary);
	line-height: 1.7;
	margin: 0;
	white-space: pre-wrap;
	max-height: 100px;
	overflow: hidden;
	transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.log-notes-section.expanded .log-notes-content {
	max-height: 2000px;
}

.log-notes-section.counselor-notes {
	background: #fffafa;
	border-left: 4px solid var(--crisis);
	margin-top: 8px;
}

.log-notes-section.counselor-notes:hover {
	border-color: var(--crisis);
	background: #fff;
}

/* ── EMPTY STATE ── */
.logs-empty {
	text-align: center;
	padding: 80px 24px;
	background: var(--bg-soft);
	border: 2px dashed var(--border);
	border-radius: var(--radius-lg);
	color: var(--text-secondary);
}

.logs-empty i {
	font-size: 3.5rem;
	color: var(--border);
	margin-bottom: 20px;
	opacity: 0.5;
}

.logs-empty h3 {
	font-size: 1.4rem;
	color: var(--text-primary);
	margin-bottom: 12px;
	font-weight: 700;
}
</style>

<div class="logs-page">
	<div class="logs-page-header">
		<h1><i class="fas fa-check-circle"></i> Call Logs & Success</h1>
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
							<span><i class="far fa-calendar-alt" style="margin-right:6px;"></i> <?= $dateStr ?></span>
							<span class="log-badge <?= $statusClass ?>"><?= htmlspecialchars($log['status']) ?></span>
						</div>
					</div>

					<div class="log-notes-section" onclick="this.classList.toggle('expanded')">
						<div class="log-notes-label">
							<span><i class="fas fa-file-medical"></i> Responder Intervention Notes</span>
							<span style="font-size:0.7rem; color:var(--primary); font-weight:800; text-transform: none;">Click to Expand</span>
						</div>
						<div class="log-notes-content"><?= $notes ?></div>
					</div>

					<?php if (!empty($log['counselor_followup_notes'])): ?>
						<div class="log-notes-section counselor-notes" onclick="this.classList.toggle('expanded')">
							<div class="log-notes-label" style="color:var(--crisis);">
								<span><i class="fas fa-user-md"></i> Counselor Follow-up</span>
								<span style="font-size:0.7rem; font-weight:800; text-transform: none;">Emergency Feedback</span>
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