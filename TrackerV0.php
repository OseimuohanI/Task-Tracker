<?php
$tasks = [];
$progress = [];
$nextId = 1;

const DATA_FILE = __DIR__ . DIRECTORY_SEPARATOR . 'Tasks.json';

function loadFromJson(): void {
    global $tasks, $progress, $nextId;
    if (!file_exists(DATA_FILE)) return;
    $json = @file_get_contents(DATA_FILE);
    if ($json === false || trim($json) === '') return;
    $data = json_decode($json, true);
    if (!is_array($data)) return;
    $tasks    = $data['tasks']    ?? [];
    $progress = $data['progress'] ?? [];
    $nextId   = $data['nextId']   ?? 1;
    migrateLegacyDataIfNeeded();
}

function migrateLegacyDataIfNeeded(): void {
    global $tasks, $progress, $nextId;
    if ($tasks === []) return;
    $first = $tasks[array_key_first($tasks)];
    $isLegacy = !is_array($first) || !array_key_exists('id', $first) || !array_key_exists('title', $first);
    if (!$isLegacy) return;

    $newTasks = [];
    $newProgress = [];
    $maxId = max(0, (int)$nextId - 1);

    foreach ($tasks as $i => $t) {
        $title = is_array($t) ? ($t['title'] ?? (string)json_encode($t)) : (string)$t;
        $id = ++$maxId;
        $newTasks[] = ['id' => $id, 'title' => $title];
        $newProgress[$id] = isset($progress[$i]) ? (int)$progress[$i] : 0;
    }

    $tasks = $newTasks;
    $progress = $newProgress;
    $nextId = $maxId + 1;
    saveToJson();
}

function saveToJson(): void {
    global $tasks, $progress, $nextId;
    $payload = json_encode(
        ['tasks'=>$tasks,'progress'=>$progress,'nextId'=>$nextId],
        JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
    );
    $tmp = DATA_FILE . '.tmp';
    file_put_contents($tmp, $payload, LOCK_EX);
    rename($tmp, DATA_FILE);
}

loadFromJson();

function addTask(): void {
    global $tasks, $progress, $nextId;
    $name = readline("Enter task: ");
    if ($name === '') { echo "Empty ignored\n"; return; }
    $id = $nextId++;
    $tasks[] = ['id'=>$id,'title'=>$name];
    $progress[$id] = 0;
    saveToJson();
    echo "Added\n";
}

function listTasks(): void {
    global $tasks, $progress;
    if (!$tasks) { echo "No tasks\n"; return; }
    foreach ($tasks as $i => $t) {
        $id = $t['id'];
        $title = $t['title'];
        $status = ($progress[$id] ?? 0) ? 'Done' : 'In progress';
        printf("[%d] #%d %s - %s\n", $i+1, $id, $title, $status);
    }
}

function toggleTask(): void {
    global $tasks, $progress;
    if (!$tasks) { echo "No tasks\n"; return; }
    listTasks();
    $num = readline("Select number to toggle: ");
    if (!ctype_digit($num)) { echo "Invalid\n"; return; }
    $idx = (int)$num - 1;
    if (!isset($tasks[$idx])) { echo "Out of range\n"; return; }
    $id = $tasks[$idx]['id'];
    $progress[$id] = isset($progress[$id]) && $progress[$id] ? 0 : 1;
    saveToJson();
    echo "Toggled\n";
}

function deleteTask(): void {
    global $tasks, $progress;
    if (!$tasks) { echo "No tasks\n"; return; }
    listTasks();
    $num = readline("Select number to delete: ");
    if (!ctype_digit($num)) { echo "Invalid\n"; return; }
    $idx = (int)$num - 1;
    if (!isset($tasks[$idx])) { echo "Out of range\n"; return; }
    $id = $tasks[$idx]['id'];
    unset($progress[$id]);
    array_splice($tasks, $idx, 1);
    saveToJson();
    echo "Deleted\n";
}

function menu(): void {
    echo "\n1 List\n2 Add\n3 Toggle\n4 Delete\n5 Quit\n";
}

while (true) {
    menu();
    $choice = readline("Choice: ");
    switch ($choice) {
        case '1': listTasks(); break;
        case '2': addTask(); break;
        case '3': toggleTask(); break;
        case '4': deleteTask(); break;
        case '5': echo "Bye\n"; exit;
        default: echo "Retry\n";
    }
}
?>