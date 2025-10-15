<?php include 'app/views/layouts/header.php'; ?>

<h2>Upload University Image</h2>
<form action="UniversityRepresentativeControl/handleUpload" method="POST" enctype="multipart/form-data">
  <label>Select Image:</label>
  <input type="file" name="image" required>
  <button type="submit">Upload</button>
</form>

<?php include 'app/views/layouts/footer.php'; ?>
