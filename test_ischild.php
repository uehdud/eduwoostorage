<?php

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Testing isChildOf function...\n";

// Create test folders with hierarchy
try {
    $user = \App\Models\User::first();
    if (!$user) {
        echo "No user found, creating test user...\n";
        $user = \App\Models\User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);
    }

    // Create test folder hierarchy: Root -> Folder1 -> Folder2
    $folder1 = \App\Models\Folder::create([
        'name' => 'Test Folder 1',
        'user_id' => $user->id,
        'parent_id' => null,
    ]);

    $folder2 = \App\Models\Folder::create([
        'name' => 'Test Folder 2',
        'user_id' => $user->id,
        'parent_id' => $folder1->id,
    ]);

    echo "Created test folders:\n";
    echo "Folder1 ID: {$folder1->id}\n";
    echo "Folder2 ID: {$folder2->id} (parent: {$folder2->parent_id})\n";

    // Test the function logic manually
    echo "\nTesting hierarchy check...\n";

    // Test 1: folder2 should be child of folder1
    $isChild = checkIsChildOf($folder2->id, $folder1->id, $user->id);
    echo "Is Folder2 child of Folder1? " . ($isChild ? "YES" : "NO") . "\n";

    // Test 2: folder1 should NOT be child of folder2
    $isChild = checkIsChildOf($folder1->id, $folder2->id, $user->id);
    echo "Is Folder1 child of Folder2? " . ($isChild ? "YES" : "NO") . "\n";

    // Clean up
    $folder2->delete();
    $folder1->delete();

    echo "\nTest completed successfully!\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

function checkIsChildOf($childId, $parentId, $userId)
{
    if (!$childId || !$parentId || $childId == $parentId) {
        return false;
    }

    try {
        $child = \App\Models\Folder::where('id', $childId)
            ->where('user_id', $userId)
            ->with('parent')
            ->first();

        if (!$child) {
            return false;
        }

        $visited = [];
        $depth = 0;
        $maxDepth = 50;

        while ($child && $child->parent_id && $depth < $maxDepth) {
            if (in_array($child->id, $visited)) {
                echo "Circular reference detected!\n";
                break;
            }

            if ($child->parent_id == $parentId) {
                return true;
            }

            $visited[] = $child->id;
            $child = $child->parent;
            $depth++;
        }

        return false;
    } catch (Exception $e) {
        echo "Error in checkIsChildOf: " . $e->getMessage() . "\n";
        return false;
    }
}
