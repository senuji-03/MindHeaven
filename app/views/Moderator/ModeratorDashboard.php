<?php require BASE_PATH . '/app/views/layouts/header.php'; ?>

<style>
	/* ── MODERATOR DASHBOARD UNIFIED STYLES ── */
	.mod-hero {
		background: var(--bg-deep);
		border-radius: var(--radius-lg);
		padding: 56px 40px;
		margin-bottom: 40px;
		color: #fff;
		position: relative;
		overflow: hidden;
		box-shadow: var(--shadow-lg);
	}

	.mod-hero::after {
		content: '';
		position: absolute;
		top: -50%;
		right: -10%;
		width: 450px;
		height: 450px;
		background: radial-gradient(circle, rgba(61, 139, 110, 0.25) 0%, transparent 70%);
		pointer-events: none;
	}

	.mod-hero h1 {
		font-size: 2.4rem;
		font-weight: 700;
		margin: 0 0 12px;
		letter-spacing: -0.7px;
	}

	.mod-hero p {
		font-size: 1.1rem;
		opacity: 0.85;
		max-width: 600px;
		line-height: 1.7;
		margin: 0 0 40px;
	}

	/* ── STATS CARDS ── */
	.mod-stats {
		display: grid;
		grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
		gap: 24px;
	}

	.mod-stat-card {
		background: rgba(255, 255, 255, 0.08);
		backdrop-filter: blur(12px);
		border: 1px solid rgba(255, 255, 255, 0.12);
		border-radius: var(--radius-md);
		padding: 24px;
		transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
		display: flex;
		flex-direction: column;
		gap: 8px;
	}

	.mod-stat-card:hover {
		transform: translateY(-5px);
		background: rgba(255, 255, 255, 0.12);
		border-color: rgba(255, 255, 255, 0.3);
		box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
	}

	.mod-stat-card .number {
		display: block;
		font-size: 2.5rem;
		font-weight: 800;
		line-height: 1;
		color: #fff;
	}

	.mod-stat-card .label {
		font-size: 0.78rem;
		font-weight: 700;
		text-transform: uppercase;
		letter-spacing: 1.2px;
		color: var(--primary-light);
	}

	/* ── SECTION HEADERS ── */
	.mod-section-title {
		font-size: 1.6rem;
		font-weight: 700;
		color: var(--text-primary);
		margin: 0 0 8px;
		letter-spacing: -0.3px;
	}

	.mod-section-subtitle {
		font-size: 1rem;
		color: var(--text-secondary);
		margin: 0 0 40px;
	}

	/* ── QUICK ACCESS GRID ── */
	.mod-action-grid {
		display: grid;
		grid-template-columns: 1fr;
		gap: 24px;
		margin: 0 auto 60px; /* Centered with auto margins */
		max-width: 800px;
	}

	.mod-action-card {
		background: var(--surface);
		border: 1px solid var(--border);
		border-radius: var(--radius-lg);
		padding: 32px;
		text-decoration: none;
		color: inherit;
		transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
		display: flex;
		align-items: flex-start;
		gap: 24px;
		box-shadow: var(--shadow-sm);
	}

	.mod-action-card:hover {
		border-color: var(--primary-light);
		box-shadow: var(--shadow-lg);
		transform: translateY(-8px);
	}

	.mod-action-icon {
		width: 64px;
		height: 64px;
		flex-shrink: 0;
		background: var(--bg-mid);
		color: var(--primary);
		border-radius: var(--radius-md);
		display: flex;
		align-items: center;
		justify-content: center;
		font-size: 1.8rem;
		transition: all 0.3s ease;
	}

	.mod-action-card:hover .mod-action-icon {
		background: var(--primary);
		color: #fff;
		transform: rotate(-8deg) scale(1.1);
	}

	.mod-action-card .content h3 {
		font-size: 1.35rem;
		font-weight: 700;
		color: var(--text-primary);
		margin: 0 0 10px;
	}

	.mod-action-card .content p {
		font-size: 0.98rem;
		color: var(--text-secondary);
		line-height: 1.6;
		margin: 0;
	}

	/* ── MODAL MODERNIZATION ── */
	.modal-content {
		border-radius: var(--radius-lg) !important;
		box-shadow: var(--shadow-xl) !important;
		border: none !important;
		padding: 48px !important;
	}

	.modal-header h2 {
		font-size: 1.8rem;
		font-weight: 700;
		margin-bottom: 24px;
		color: var(--text-primary);
		letter-spacing: -0.5px;
	}

	.modal-textarea {
		width: 100%;
		border: 1.8px solid var(--border);
		border-radius: var(--radius-md);
		padding: 20px;
		font-family: inherit;
		font-size: 1rem;
		line-height: 1.6;
		margin-bottom: 32px;
		transition: all 0.25s ease;
		background: var(--bg-mid);
	}

	.modal-textarea:focus {
		outline: none;
		border-color: var(--primary);
		background: #fff;
		box-shadow: 0 0 0 5px rgba(61, 139, 110, 0.12);
	}
</style>

<div class="main-content">


	<!-- Resource Management -->
	<section class="mod-sections">
		<h2 class="mod-section-title">Resource Moderation</h2>
		<p class="mod-section-subtitle">Core tools for managing educational content and community engagement.</p>

		<div class="mod-action-grid">
			<a href="<?= BASE_URL ?>/AddResource" class="mod-action-card">
				<div class="mod-action-icon"><i class="fas fa-plus-circle"></i></div>
				<div class="content">
					<h3>Add Resource</h3>
					<p>Create and publish new educational articles, videos, or audio wellness materials.</p>
				</div>
			</a>
			<a href="<?= BASE_URL ?>/EditPosts" class="mod-action-card">
				<div class="mod-action-icon"><i class="fas fa-pen-to-square"></i></div>
				<div class="content">
					<h3>Edit Resources</h3>
					<p>Review, correct, or enhance existing content library to maintain high standards.</p>
				</div>
			</a>
			<a href="<?= BASE_URL ?>/Moderator/reported-resources" class="mod-action-card">
				<div class="mod-action-icon" style="color:var(--crisis); box-shadow: 0 4px 12px rgba(214, 79, 79, 0.1);"><i class="fas fa-triangle-exclamation"></i></div>
				<div class="content">
					<h3>Reported Content</h3>
					<p>Swiftly address items flagged by our community for review, safety, or accuracy checks.</p>
				</div>
			</a>
		</div>
	</section>
</div>

<!-- Edit Content Modal -->
<div id="editModal" class="modal"
	style="display:none; position:fixed; z-index:1000; left:0; top:0; width:100%; height:100%; overflow:auto; background-color:rgba(30, 58, 52, 0.5); backdrop-filter: blur(8px);">
	<div class="modal-content" style="background-color:#fff; margin:8% auto; width:560px; max-width: 90%;">
		<div class="modal-header">
			<span class="close" onclick="closeEditModal()" style="color:var(--text-secondary); float:right; font-size:28px; cursor:pointer; margin-top: -10px;">&times;</span>
			<h2>Edit Reported Content</h2>
		</div>
		<form action="<?= BASE_URL ?>/moderator/edit-reported-content" method="POST">
			<input type="hidden" name="report_id" id="editReportId">
			<input type="hidden" name="post_id" id="editPostId">

			<div style="margin-bottom: 24px;">
				<label for="editContent" style="display:block; margin-bottom:12px; font-weight:700; font-size: 0.8rem; color: var(--primary); text-transform: uppercase; letter-spacing: 1px;">Full Content Preview</label>
				<textarea name="content" id="editContent" rows="10" class="modal-textarea"></textarea>
			</div>

			<div style="display: flex; gap: 16px; justify-content: flex-end;">
				<button type="button" class="btn btn-outline" style="border-radius: var(--radius-full); padding: 12px 24px;" onclick="closeEditModal()">Cancel</button>
				<button type="submit" class="btn btn-primary" style="border-radius: var(--radius-full); padding: 12px 32px; box-shadow: var(--shadow-md);">Save Changes</button>
			</div>
		</form>
	</div>
</div>

<script>
	const editModal = document.getElementById('editModal');

	function openEditModal(report) {
		document.getElementById('editReportId').value = report.id;
		document.getElementById('editPostId').value = report.content_id;

		const txt = document.createElement("textarea");
		txt.innerHTML = report.full_content || report.content;

		document.getElementById('editContent').value = txt.value;

		editModal.style.display = "block";
	}

	function closeEditModal() {
		editModal.style.display = "none";
	}

	window.onclick = function (event) {
		if (event.target == editModal) {
			closeEditModal();
		}
	}
</script>

<?php require BASE_PATH . '/app/views/layouts/footer.php'; ?>
</script>
</body>

</html>