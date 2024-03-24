<?php

if (!function_exists('item_sort_link')) {
    /**
     * ソート用のヘッダリンクを生成する
     *
     * @param string $column ソートする列名
     * @param string $title 表示するテキスト
     * @return string HTMLリンクタグ
     */
    function item_sort_link($column, $title) {
        $currentParams = request()->all();
        $direction = request('sort') === $column && request('direction', 'asc') === 'asc' ? 'desc' : 'asc';
        $icon = request('sort') === $column ? (request('direction', 'asc') === 'asc' ? 'fa-chevron-up' : 'fa-chevron-down') : '';
        
        $linkParams = array_merge($currentParams, ['sort' => $column, 'direction' => $direction]);
        $link = request()->routeIs('items.favorite_items') ? route('items.favorite_items', $linkParams) : route('items.index', $linkParams);

        return "<a href=\"{$link}\">{$title} <i class=\"fas {$icon}\"></i></a>";
    }
}