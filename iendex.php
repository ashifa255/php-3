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
