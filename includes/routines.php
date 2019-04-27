<?php
function fileGetContentsByCurl($url)
{
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => 1, CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_SSL_VERIFYHOST => false, CURLOPT_SSL_VERIFYPEER => false
    ]);
    $content = curl_exec($ch);
    curl_close($ch);

    return $content;
}

function getHtmlTagsWithCount($dm)
{
    static $html_tags = [];
    foreach ($dm->childNodes as $node) {
        if (!property_exists($node, 'tagName')) {
            continue;
        }

        if (!isset($html_tags[$node->tagName])) {
            $html_tags[$node->tagName] = 0;
        }

        $html_tags[$node->tagName] += 1;

        if ($node->hasChildNodes()) {
            getHtmlTagsWithCount($node);
        }
    }

    return $html_tags;
}

function displayNodes($dm)
{
    echo '<ul>';
    foreach ($dm->childNodes as $node) {
        if (!property_exists($node, 'tagName')) continue;

        echo '<li>';
        echo '<a id="#' . $node->tagName . '">' . $node->tagName . '</a>';
        #echo '<pre>' . print_r($node, true) . '</pre>';

        #displayAttributes($node);

        if ($node->hasChildNodes()) {
            displayNodes($node);
        }
        echo '</li>';
    }
    echo '</ul>';
}

function displayAttributes($node)
{
    echo '<ul>';
    foreach ($node->attributes as $attribute) {
        echo '<li><b>' . $attribute->name . '</b> = ' . $attribute->value . '</li>';
        #echo '<pre>' . print_r($attribute, true) . '</pre>';
    }
    echo '</ul>';
}