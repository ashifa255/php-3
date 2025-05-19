<?php


define("PROJECT_FILES", "tasks.json");

function saveData(array $info): void
{
    file_put_contents(PROJECT_FILES, json_encode($info, JSON_PRETTY_PRINT));
}


//DATA Load
function loadData()
{
    if (!file_exists(PROJECT_FILES)) {
        return [];
    }
    $data = file_get_contents(PROJECT_FILES);
    return $data ? json_decode($data, true) : [];
}

$info = loadData();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['task']) && !empty(trim($_POST['task']))) {
        $info[] = [
            'data' => htmlspecialchars($_POST['task']),
            'done' => false
        ];
        saveData($info);
        header('Location:' . $_SERVER['PHP_SELF']);
        exit;
    } elseif (isset($_POST['delete'])) {
        unset($info[$_POST['delete']]);
        saveData($info);
        header('Location:' . $_SERVER['PHP_SELF']);
        exit;
    } elseif (isset($_POST['toggle'])) {
        $info[$_POST['toggle']]['done'] = !$info[$_POST['toggle']]['done'];
        saveData($info);
        header('Location:' . $_SERVER['PHP_SELF']);
        exit;
    }
}
