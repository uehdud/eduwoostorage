<?php

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Checking folders data...\n";
echo "Total folders: " . \App\Models\Folder::count() . "\n\n";

$folders = \App\Models\Folder::all();
foreach ($folders as $folder) {
    echo "ID: {$folder->id}, Name: {$folder->name}, Parent: {$folder->parent_id}, User: {$folder->user_id}\n";
}

echo "\nChecking for circular references...\n";
foreach ($folders as $folder) {
    $visited = [];
    $current = $folder;
    $depth = 0;
    while ($current && $current->parent_id && $depth < 100) {
        if (in_array($current->id, $visited)) {
            echo "CIRCULAR REFERENCE FOUND: Folder {$folder->id} ({$folder->name})\n";
            break;
        }
        $visited[] = $current->id;
        $current = $current->parent;
        $depth++;
    }
    if ($depth >= 100) {
        echo "DEEP NESTING DETECTED: Folder {$folder->id} ({$folder->name}) has more than 100 levels\n";
    }
}

echo "Check completed.\n";
