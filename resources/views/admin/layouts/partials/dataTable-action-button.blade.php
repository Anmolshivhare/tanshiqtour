<ul class="justify-start gap-3 data-table-list list-group list-group-horizontal">

    @if (!empty($viewRoute))
        <li class="p-0 bg-transparent border-0 data-table-list-item list-group-item">
            <a class="gap-2 view d-flex align-items-center text-green" href="{{ $viewRoute }}" target="{{ $target ?? '_self' }}">
                <i class="fa-solid fa-eye"></i>
                <span>{{ __('buttons.view') }}</span>
            </a>
        </li>
    @endif

    @if (!empty($editRoute))
        <li class="p-0 bg-transparent border-0 data-table-list-item list-group-item">
            <a class="gap-2 edit d-flex align-items-center text-info" href="{{ $editRoute }}">
                <i class="fa-solid fa-pen-to-square"></i>
                <span>{{ __('buttons.edit') }}</span>
            </a>
        </li>
    @endif


    @if (!empty($restoreRoute))
        <li class="data-table-list-item list-group-item border-0 p-0 bg-transparent">
            <form action="{{ $restoreRoute }}" method="PUT" onsubmit="return confirm('Are you want to restore ?');"
                style="display: inline-block;">
                <input type="hidden" name="_method" value="PUT">
                <button type="submit" class="p-0 border-0 bg-transparent">
                    <i class="fa-solid fa-rotate-left" title="Restore"></i>
                </button>
            </form>
        </li>
    @endif

    @if (!empty($deleteRoute))
        <li class="p-0 bg-transparent border-0 data-table-list-item list-group-item">
            <form action="{{ $deleteRoute }}" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline-block;" class="delete-form m-0">
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <button type="submit" class="gap-2 p-0 bg-transparent border-0 d-flex align-items-center text-dark-pink delete-btn">
                    <i class="fa-solid fa-trash"></i>
                    <span>{{ __('buttons.delete') }}</span>
                </button>
            </form>
        </li>
    @endif
</ul>
