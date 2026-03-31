<?php
$r = ['id'=>21, 'title'=>'yyyy', 'content'=>'yyyy', 'content_type'=>'article', 'file_path'=>'uploads/resources/1774690423_WhatsApp_Image_2025-10-20 at 12.05.33.jpeg', 'file_name'=>'WhatsApp Image 2025-10-20 at 12.05.33.jpeg', 'summary'=>'yyyy', 'created_at'=>'2026-03-28 15:00:00'];
echo '<div class="resource-card" onclick="openResourceModal(' . htmlspecialchars(json_encode($r)) . ')">';
