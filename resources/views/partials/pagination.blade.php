### 第二步
### 创建一个新的分页Blade模板
#
# 方式2：自定义标记并输出所有页码
#
# app/views/partials/pagination.blade.php
#

@if ($paginator->getLastPage() > 1)

    <div class="ui pagination menu">
        <li>
            <a href="{{ $paginator->getUrl(1) }}" class="item{{ ($paginator->getCurrentPage() == 1) ? ' disabled' : '' }}">
                <i class="left arrow icon"></i>
                首页
            </a>
        </li>
        @for ($i = 1; $i <= $paginator->getLastPage(); $i++)
            <a href="{{ $paginator->getUrl($i) }}" class="item{{ ($paginator->getCurrentPage() == $i) ? ' active' : '' }}">
                {{ $i }}
            </a>
        @endfor
        <li>
            <a href="{{ $paginator->getUrl($paginator->getLastPage()) }}" class="item{{ ($paginator->getCurrentPage() == $paginator->getLastPage()) ? ' disabled' : '' }}">
                末页
                <i class="right arrow icon"></i>
            </a>
        </li>
    </div>

@endif