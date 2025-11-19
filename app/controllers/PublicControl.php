<?php

class PublicControl {
    
    public function __construct() {
        // No authorization required for public pages
    }
    
    public function resources() {
        try {
            require_once BASE_PATH . '/app/models/ResourceHub.php';
            $resourceHub = new ResourceHub();
            
            // Get all published resources
            $allResources = $resourceHub->getAll('published');
            
            // Group resources by category
            $resourcesByCategory = [];
            foreach ($allResources as $resource) {
                $category = $resource['category'];
                if (!isset($resourcesByCategory[$category])) {
                    $resourcesByCategory[$category] = [];
                }
                $resourcesByCategory[$category][] = $resource;
            }
            
            // Get resource statistics
            $stats = $resourceHub->getStats();
            
            // Add last updated timestamp for debugging
            $lastUpdated = date('Y-m-d H:i:s');
            
            view('layouts/public-resources', [
                'resources' => $allResources,
                'resourcesByCategory' => $resourcesByCategory,
                'stats' => $stats,
                'lastUpdated' => $lastUpdated
            ]);
        } catch (Exception $e) {
            error_log("Public ResourceHub Error: " . $e->getMessage());
            
            // Fallback to static view if database fails
            view('layouts/public-resources', [
                'resources' => [],
                'resourcesByCategory' => [],
                'stats' => ['total_resources' => 0, 'published' => 0],
                'error' => 'Unable to load resources. Please try again later.',
                'lastUpdated' => date('Y-m-d H:i:s')
            ]);
        }
    }
    
    public function forum() {
        view('layouts/public-forum');
    }
    
    public function crisis() {
        // Public crisis support page - no login required
        view('layouts/public-crisis');
    }
}
