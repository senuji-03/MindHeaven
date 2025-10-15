<?php
class UniversityRepresentativeControl
{
    // Display dashboard
    public function index()
    {
       require_once __DIR__ . '/../views/UniversityRepresentative/dashboard.php';

    }

    // Page to upload images
    public function uploadImage()
    {
        require_once 'app/views/UniversityRepresentative/upload-image.php';
    }

    // Handle image upload logic
    public function handleUpload()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $targetDir = "public/uploads/university/";
            $fileName = basename($_FILES["image"]["name"]);
            $targetFilePath = $targetDir . $fileName;

            // Create folder if it doesn’t exist
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
                echo "✅ Image uploaded successfully!";
            } else {
                echo "❌ Failed to upload image.";
            }
        }
    }

    // Contact Moderator
    public function contactModerator()
    {
        require_once 'app/views/UniversityRepresentative/contact-moderator.php';
    }
}
?>
