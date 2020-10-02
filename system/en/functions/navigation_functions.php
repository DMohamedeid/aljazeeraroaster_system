<?php


function navigationHomee($aTotal, $aStart, $aNum, $aUrl, $aItemsPerPage = 3, $aLinksPerPage = 5) {
    global $Lang;
    if ($aTotal && $aTotal > $aItemsPerPage) {

        $num_pages = ceil($aTotal / $aItemsPerPage);
        $current_page = (int) $_GET['page'];
        $current_page = ($current_page < 1) ? 1 : ($current_page > $num_pages ? $num_pages : $current_page);

        $left_offset = ceil($aLinksPerPage / 2) - 1;
        $first = $current_page - $left_offset;
        $first = ($first < 1) ? 1 : $first;

        $last = $first + $aLinksPerPage - 1;
        $last = ($last > $num_pages) ? $num_pages : $last;

        $first = $last - $aLinksPerPage + 1;
        $first = ($first < 1) ? 1 : $first;

        $pages = range($first, $last);

        $out = '<div class="item-list pagination pull-left" style="margin: 0;">    <ul class="pager">';

        $delim = ('.php' == strtolower(substr($aUrl, -4))) ? '?' : '&amp;';

// Previous, First links
        if ($current_page > 1) {
            $prev = $current_page - 1;
            $out .= "<li ><a href=\"{$aUrl}{$delim}page={$prev}{$delim}items=" . (INT) $_GET['items'] . "\">&raquo;</a></li>";
        } else {
            $out .= '<li class="disabled"><a >&raquo;</a></li>';
        }

        foreach ($pages as $page) {
            if ($current_page == $page) {
                $out .= " <li class=\"active\"><a>{$page}</a></li>";
            } else {
                $out .= "<li><a href=\"{$aUrl}{$delim}page={$page}{$delim}items=" . (INT) $_GET['items'] . "\"> {$page}</a> </li>";
            }
        }

        if ($current_page < $num_pages) {

            $next = $current_page + 1;
            $out .= "<li ><a href=\"{$aUrl}{$delim}page={$next}{$delim}items=" . (INT) $_GET['items'] . "\">&laquo;</a></li>";
        } else {
            $out .= '<li class="disabled"><a >&laquo;</a></li>';
        }

        $out .= '</div>';
    }

    return $out;
}


?>