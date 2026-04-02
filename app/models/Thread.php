<?php

class Thread
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    /**
     * Create a new thread
     */
    public function create($data)
    {
        $sql = "INSERT INTO forum_threads (user_id, title, description, category, is_anonymous, allow_transparency) 
                VALUES (?, ?, ?, ?, ?, ?)";

        try {
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute([
                $data['user_id'],
                $data['title'],
                $data['description'],
                $data['category'],
                $data['is_anonymous'] ?? 0,
                $data['allow_transparency'] ?? 0
            ]);

            if (!$result) {
                $errorInfo = $stmt->errorInfo();
                error_log("Thread Create Execution Error: " . print_r($errorInfo, true));
                throw new Exception("Database Execution Failed: " . $errorInfo[2]);
            }

            $id = $this->pdo->lastInsertId();
            error_log("Thread Created Successfully. ID: " . $id);
            return $id;
        } catch (PDOException $e) {
            error_log("Thread Create PDO Error: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Get all threads
     */
    public function getAll($limit = 10, $offset = 0)
    {
        $sql = "SELECT t.*, u.username, u.role, 
                (SELECT COUNT(*) FROM forum_posts WHERE thread_id = t.id) as reply_count 
                FROM forum_threads t
                JOIN users u ON t.user_id = u.id
                ORDER BY t.created_at DESC
                LIMIT ? OFFSET ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, (int) $limit, PDO::PARAM_INT);
        $stmt->bindValue(2, (int) $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get thread by ID
     */
    public function getById($id)
    {
        $sql = "SELECT t.*, u.username, u.role
                FROM forum_threads t
                JOIN users u ON t.user_id = u.id
                WHERE t.id = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getPostById($id)
    {
        $sql = "SELECT * FROM forum_posts WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getPosts($threadId, $currentUserId = null)
    {
        // 1. Fetch all posts for the thread
        $sql = "SELECT p.*, u.username, u.role,
                (SELECT COUNT(*) FROM forum_post_likes WHERE post_id = p.id AND user_id = ?) as is_liked
                FROM forum_posts p
                JOIN users u ON p.user_id = u.id
                WHERE p.thread_id = ?
                ORDER BY p.like_count DESC, p.created_at ASC"; // Initial sort by likes

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$currentUserId, $threadId]);
        $allPosts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // 2. Separate Roots and Children
        $roots = [];
        $childrenObj = []; // Keyed by parent_reply_id

        foreach ($allPosts as $post) {
            if (empty($post['parent_reply_id'])) {
                $roots[] = $post;
            } else {
                $childrenObj[$post['parent_reply_id']][] = $post;
            }
        }

        // 3. Build flattened list
        $flattened = [];
        foreach ($roots as $root) {
            $flattened[] = $root;
            if (isset($childrenObj[$root['id']])) {
                // Children are already somewhat sorted by SQL (likes DESC), but let's ensure strict order if needed
                // Since the original query sorts by like_count DESC, the subset $childrenObj[$root['id']] is also sorted by like_count DESC
                foreach ($childrenObj[$root['id']] as $child) {
                    $child['is_reply'] = true; // Flag for UI styling
                    $child['parent_username'] = ($root['is_anonymous'])
                        ? 'Anonymous' . str_pad($root['user_id'], 3, '0', STR_PAD_LEFT)
                        : $root['username']; // For @username
                    $flattened[] = $child;
                }
            }
        }

        return $flattened;
    }

    public function createPost($data)
    {
        $sql = "INSERT INTO forum_posts (thread_id, user_id, content, parent_reply_id, is_anonymous) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        if (
            $stmt->execute([
                $data['thread_id'],
                $data['user_id'],
                $data['content'],
                $data['parent_reply_id'] ?? null,
                $data['is_anonymous'] ?? 0
            ])
        ) {
            return $this->pdo->lastInsertId();
        }
        return false;
    }

    /**
     * Increment the view count for a specific thread
     */
    public function incrementViews($id)
    {
        $sql = "UPDATE forum_threads SET view_count = view_count + 1 WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }

    /**
     * Toggle like on a forum post
     * Returns new like count and like status
     */
    public function toggleLike($postId, $userId)
    {
        try {
            $this->pdo->beginTransaction();

            // Check if already liked
            $stmt = $this->pdo->prepare("SELECT id FROM forum_post_likes WHERE user_id = ? AND post_id = ?");
            $stmt->execute([$userId, $postId]);
            $exists = $stmt->fetch();

            if ($exists) {
                // Unlike
                $stmt = $this->pdo->prepare("DELETE FROM forum_post_likes WHERE user_id = ? AND post_id = ?");
                $stmt->execute([$userId, $postId]);

                $stmt = $this->pdo->prepare("UPDATE forum_posts SET like_count = like_count - 1 WHERE id = ?");
                $stmt->execute([$postId]);

                $liked = false;
            } else {
                // Like
                $stmt = $this->pdo->prepare("INSERT INTO forum_post_likes (user_id, post_id) VALUES (?, ?)");
                $stmt->execute([$userId, $postId]);

                $stmt = $this->pdo->prepare("UPDATE forum_posts SET like_count = like_count + 1 WHERE id = ?");
                $stmt->execute([$postId]);

                $liked = true;
            }

            // Get new count
            $stmt = $this->pdo->prepare("SELECT like_count FROM forum_posts WHERE id = ?");
            $stmt->execute([$postId]);
            $count = $stmt->fetchColumn();

            $this->pdo->commit();

            return ['success' => true, 'new_count' => $count, 'liked' => $liked];

        } catch (Exception $e) {
            $this->pdo->rollBack();
            error_log("Toggle Like Error: " . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Delete a thread
     */
    public function delete($id)
    {
        $sql = "DELETE FROM forum_threads WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }

    /**
     * Delete a post
     */
    public function deletePost($id)
    {
        $sql = "DELETE FROM forum_posts WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
    /**
     * Update a post content and set edited status
     */
    public function updatePost($postId, $content, $editorRole = null)
    {
        $sql = "UPDATE forum_posts SET content = ?, is_edited = 1, edited_by_role = ?, updated_at = NOW() WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$content, $editorRole, $postId]);
    }

    /**
     * Get overall forum statistics
     */
    public function getForumStats()
    {
        $stats = [
            'active_threads' => 0,
            'total_posts' => 0,
            'online_now' => 0
        ];

        try {
            // Count active threads
            $stmt = $this->pdo->query("SELECT COUNT(*) FROM forum_threads WHERE status = 'active'");
            $stats['active_threads'] = $stmt->fetchColumn() ?: 0;

            // Count total posts (including replies)
            $stmt = $this->pdo->query("SELECT COUNT(*) FROM forum_posts");
            $stats['total_posts'] = $stmt->fetchColumn() ?: 0;

            // Count active users in the last 15 minutes
            $stmt = $this->pdo->query("SELECT COUNT(*) FROM users WHERE last_login >= NOW() - INTERVAL 15 MINUTE");
            $stats['online_now'] = $stmt->fetchColumn() ?: 0;

        } catch (PDOException $e) {
            error_log("Get Forum Stats Error: " . $e->getMessage());
        }

        return $stats;
    }

    /**
     * Get recent forum activity feed
     */
    public function getRecentActivity($limit = 5)
    {
        $activities = [];

        try {
            // Get latest threads
            $sqlThreads = "SELECT id as target_id, title, created_at, 'thread' as type 
                           FROM forum_threads 
                           ORDER BY created_at DESC LIMIT ?";
            $stmtThreads = $this->pdo->prepare($sqlThreads);
            $stmtThreads->bindValue(1, (int) $limit, PDO::PARAM_INT);
            $stmtThreads->execute();
            $recentThreads = $stmtThreads->fetchAll(PDO::FETCH_ASSOC);

            // Get latest posts/replies
            $sqlPosts = "SELECT p.thread_id as target_id, t.title, p.created_at, 'reply' as type 
                         FROM forum_posts p
                         JOIN forum_threads t ON p.thread_id = t.id
                         ORDER BY p.created_at DESC LIMIT ?";
            $stmtPosts = $this->pdo->prepare($sqlPosts);
            $stmtPosts->bindValue(1, (int) $limit, PDO::PARAM_INT);
            $stmtPosts->execute();
            $recentPosts = $stmtPosts->fetchAll(PDO::FETCH_ASSOC);

            // Combine and sort by date
            $allActivity = array_merge($recentThreads, $recentPosts);
            usort($allActivity, function ($a, $b) {
                return strtotime($b['created_at']) <=> strtotime($a['created_at']);
            });

            // Keep only the top $limit items
            $activities = array_slice($allActivity, 0, $limit);

        } catch (PDOException $e) {
            error_log("Get Recent Activity Error: " . $e->getMessage());
        }

        return $activities;
    }
    /**
     * Get all active forum categories (thread categories, not report categories)
     */
    public function getCategories()
    {
        $stmt = $this->pdo->query(
            "SELECT name, description FROM forum_categories WHERE is_active = 1 ORDER BY sort_order ASC"
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
