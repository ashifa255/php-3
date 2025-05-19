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

<!-- UI -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do App</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.min.css">

    <style>
        body {
            margin-top: 20px;
        }
        .task-card {
            border: 1px solid #ececec; 
            padding: 20px;
            border-radius: 5px;
            background: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); 
        }
        .task{
            color: #888;
        }
        .task-done {
            text-decoration: line-through;
            color: #888;
        }
        .task-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        ul {
            padding-left: 20px;
        }
        button {
            cursor: pointer;
        }
    </style>
</head>
