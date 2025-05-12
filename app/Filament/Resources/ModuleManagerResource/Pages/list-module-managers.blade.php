<x-filament::page>
    <x-filament::card>
        <h2 class="text-xl font-bold mb-4">מודולים קיימים בפרויקט</h2>

        <table class="min-w-full text-sm">
            <thead>
                <tr class="bg-gray-100 text-right">
                    <th class="p-2">שם המחלקה</th>
                    <th class="p-2">נתיב</th>
                    <th class="p-2">סוג</th>
                    <th class="p-2">זמין</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($manualModules as $module)
                    <tr class="border-b">
                        <td class="p-2 font-mono text-blue-700">{{ $module['class'] }}</td>
                        <td class="p-2 text-gray-600">{{ $module['path'] }}</td>
                        <td class="p-2">{{ $module['source'] }}</td>
                        <td class="p-2">
                            @if ($module['exists'])
                                <span class="text-green-600 font-semibold">כן</span>
                            @else
                                <span class="text-red-600 font-semibold">לא</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </x-filament::card>
</x-filament::page>
