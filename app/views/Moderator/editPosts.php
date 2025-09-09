<?php
class Forum extends Model {
    
    // Get all flagged posts
    public function getFlaggedPosts() {
        $stmt = $this->db->query("SELECT * FROM forum_posts WHERE status='flagged'");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get all pending posts (optional, for approval queue)
    public function getPendingPosts() {
        $stmt = $this->db->query("SELECT * FROM forum_posts WHERE status='pending'");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Approve a post
    public function approvePost($id) {
        $stmt = $this->db->prepare("UPDATE forum_posts SET status='approved' WHERE id=?");
        return $stmt->execute([$id]);
    }

    // Delete a post
    public function deletePost($id) {
        $stmt = $this->db->prepare("UPDATE forum_posts SET status='deleted' WHERE id=?");
        return $stmt->execute([$id]);
    }

    // Edit a post (Moderator edits content)
    public function editPost($id, $newContent) {
        $stmt = $this->db->prepare("UPDATE forum_posts SET content=?, status='approved' WHERE id=?");
        return $stmt->execute([$newContent, $id]);
    }

    // Get all posts (for dashboard overview)
    public function getAllPosts() {
        $stmt = $this->db->query("SELECT * FROM forum_posts ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

