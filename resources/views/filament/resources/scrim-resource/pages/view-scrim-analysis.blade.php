<x-filament-panels::page>
    
    <x-filament-widgets::widgets
        :widgets="$this->getVisibleHeaderWidgets()"
        :columns="$this->getColumns()"
    />

    <x-filament-widgets::widgets
        :widgets="$this->getVisibleFooterWidgets()"
        :columns="$this->getColumns()"
    />

    </x-filament-panels::page>