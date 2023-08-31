<?php

function getLogo() {
    $settings = \Fieroo\Bootstrapper\Models\Setting::take(1)->first();
    return $settings->logo_path;
}

function formatDataForEmail($data_for_email, $body_email) {
    $pattern = '/\[(\w+)]/';
    $replacement = function ($matches) use ($data_for_email) {
        $key = $matches[1];
        return isset($data_for_email[$key]) ? $data_for_email[$key] : $matches[0];
    };
    $body_email = preg_replace_callback($pattern, $replacement, $body_email);
    return $body_email;
}