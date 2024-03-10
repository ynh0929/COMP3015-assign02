<?php
function image(string $filename): string {
    return "/images/$filename";
}

function validTitle(string $title): bool {
    return !empty($title) && strlen($title) > 3;
}

function validURL(string $url): bool {
    return !empty($url) && filter_var($url, FILTER_VALIDATE_URL) !== false;
}

// Helper function to safely output data in views
function h(string $data): string
{
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}
