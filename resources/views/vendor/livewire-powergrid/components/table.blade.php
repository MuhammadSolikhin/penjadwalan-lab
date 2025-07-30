<x-livewire-powergrid::table-base :$readyToLoad :$tableName :$theme :lazy="!is_null(data_get($setUp, 'lazy'))">
    <x-slot:header>
        @include('livewire-powergrid::components.table.tr')

        <div class="row mb-3">
            <div class="col">
                {{-- Overrride search bar --}}
                @if (data_get($setUp, 'header.searchInput'))
                    <div class="input-group w-100">
                        <span class="input-group-text">
                            <svg width="16" height="16" fill="currentColor"
                                class="{{ theme_style($theme, 'searchBox.iconSearch') }}" viewBox="0 0 16 16">
                                <path
                                    d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z">
                                </path>
                            </svg>
                        </span>
                        <input wire:model.live.debounce.600ms="search" type="text"
                            class="{{ theme_style($theme, 'searchBox.input') }}" placeholder="Pencarian...">
                    </div>
                @endif
            </div>

            <div class="col">
                {{-- Override show per page --}}
                @if (filled(data_get($setUp, 'footer.perPage')) && count(data_get($setUp, 'footer.perPageValues')) > 1)
                    <label class="w-auto">
                        <select wire:model.live="setUp.footer.perPage"
                            class="form-select {{ theme_style($theme, 'footer.select') }}">
                            @foreach (data_get($setUp, 'footer.perPageValues') as $value)
                                <option value="{{ $value }}">
                                    @if ($value == 0)
                                        {{ trans('livewire-powergrid::datatable.labels.all') }}
                                    @else
                                        {{ $value }}
                                    @endif
                                </option>
                            @endforeach
                        </select>
                    </label>
                @endif
            </div>

            <div class="col-1">
                {{-- Get Parent Route --}}
                @php
                    $parentRoute = explode('.', $currentRoute)[0];
                @endphp

                {{-- Exclude some pages --}}
                @if (
                    $parentRoute != 'unit' &&
                        $parentRoute != 'booking' &&
                        $parentRoute != 'livewire' &&
                        $parentRoute != 'kategori-barang' &&
                        $parentRoute != 'proses-pengajuan')
                    <a href="{{ route($parentRoute . '.create') }}">
                        <button class="mybtn mybtn-primary text-light ms-2 p-2 mb-2">
                            <i data-feather="plus" x-init="feather.replace()"></i>
                        </button>
                    </a>

                    {{-- If Unit page --}}
                @elseif ($parentRoute == 'unit')
                    <button type="button" class="mybtn mybtn-primary text-light ms-2 p-2 mb-2" data-bs-toggle="modal"
                        data-bs-target="#formModalStore" id="{{ $parentRoute . 'Store' }}">
                        <i data-feather="plus" x-init="feather.replace()"></i>
                    </button>
                @endif

            </div>
        </div>
    </x-slot:header>

    <x-slot:loading>
        @include('livewire-powergrid::components.table.tr', ['loading' => true])
    </x-slot:loading>

    <x-slot:body>
        @includeWhen($this->hasColumnFilters, 'livewire-powergrid::components.inline-filters')

        @if (is_null($data) || count($data) === 0)
            @include('livewire-powergrid::components.table.th-empty')
        @else
            @includeWhen($headerTotalColumn, 'livewire-powergrid::components.table-header')

            @if (empty(data_get($setUp, 'lazy')))

                @if (isset($setUp['detail']))
                    @foreach ($data as $row)
                        @php
                            $rowId = data_get($row, $this->realPrimaryKey);
                            $class = theme_style($theme, 'table.body.tr');
                        @endphp

                        <tbody wire:key="tbody-{{ substr($rowId, 0, 6) }}" class="{{ $class }}">
                            @include('livewire-powergrid::components.row', [
                                'rowIndex' => $loop->index + 1,
                            ])
                            @if (data_get($setUp, 'detail.state.' . $rowId))
                                <tr class="{{ $class }}">
                                    @include('livewire-powergrid::components.table.detail')
                                </tr>
                            @endif
                        </tbody>

                        @includeWhen(isset($setUp['responsive']),
                            'livewire-powergrid::components.expand-container')
                    @endforeach
                @else
                    @foreach ($data as $row)
                        @php
                            $rowId = data_get($row, $this->realPrimaryKey);
                            $class = theme_style($theme, 'table.body.tr');
                        @endphp

                        <tr wire:replace.self x-data="pgRowAttributes({ rowId: @js($rowId), defaultClasses: @js($class), rules: @js($row->__powergrid_rules) })" x-bind="getAttributes">
                            @include('livewire-powergrid::components.row', [
                                'rowIndex' => $loop->index + 1,
                            ])
                        </tr>

                        @includeWhen(isset($setUp['responsive']),
                            'livewire-powergrid::components.expand-container')
                    @endforeach
                @endif
            @else
                <div>
                    @foreach (range(0, data_get($setUp, 'lazy.items')) as $item)
                        @php
                            $skip = $item * data_get($setUp, 'lazy.rowsPerChildren');
                            $take = data_get($setUp, 'lazy.rowsPerChildren');
                        @endphp

                        <livewire:lazy-child key="{{ $this->getLazyKeys }}" :parentId="$this->getId()" :child-index="$item"
                            :primary-key="$primaryKey" real-primary-key="{{ $this->realPrimaryKey }}" :$radio :$radioAttribute
                            :$checkbox :$checkboxAttribute :theme="$theme" :$setUp :$tableName :parentName="$this->getName()"
                            :columns="$this->visibleColumns" :data="\PowerComponents\LivewirePowerGrid\DataSource\Processors\DataSourceBase::transform(
                                $data->skip($skip)->take($take),
                                $this,
                                true,
                            )" />
                    @endforeach
                </div>
            @endif

            @includeWhen($footerTotalColumn, 'livewire-powergrid::components.table-footer')
        @endif

    </x-slot:body>
</x-livewire-powergrid::table-base>
