<?php
$link_limit = 7; // maximum number of links (a little bit inaccurate, but will be ok for now)
?>

@if ($paginator->lastPage() > 1)
    <div class="pagination text-center">
            @if($paginator->currentPage() !== 1)
                <a class="  {{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}"  href="{{ $paginator->url(1) }}">اول</a>
            @endif
            <a class="  {{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}" href="{{ $paginator->url(1) }}">
                <i class="mdi mdi-chevron-double-right"></i>
            </a>
        @for ($i = 1; $i <= $paginator->lastPage(); $i++)
            <?php
            $half_total_links = floor($link_limit / 2);
            $from = $paginator->currentPage() - $half_total_links;
            $to = $paginator->currentPage() + $half_total_links;
            if ($paginator->currentPage() < $half_total_links) {
                $to += $half_total_links - $paginator->currentPage();
            }
            if ($paginator->lastPage() - $paginator->currentPage() < $half_total_links) {
                $from -= $half_total_links - ($paginator->lastPage() - $paginator->currentPage()) - 1;
            }
            ?>
            @if ($from < $i && $i < $to)
                    <a class=" {{ ($paginator->currentPage() == $i) ? ' active-page' : '' }}" href="{{ $paginator->url($i) }}">{{ $i }}</a>
            @endif
        @endfor

            @if($paginator->currentPage() != $paginator->lastPage())
                <a class="  {{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}" href="{{ $paginator->url($paginator->currentPage()+1) }}">
                    <i class="mdi mdi-chevron-double-left"></i>
                </a>
            @endif
            @if($paginator->currentPage() !== $paginator->lastPage())
                <a class="  {{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}"  href="{{ $paginator->url($paginator->lastPage()) }}">آخر</a>
            @endif
    </div>
@endif



