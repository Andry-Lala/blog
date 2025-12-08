@extends('layouts.dashboard')

@section('title', __('messages.manage_exchange_rates'))

@section('header')
    <div class="ml-4 flex items-center justify-between w-full">
        <div class="flex-1 min-w-0">
            <h1 class="text-xl sm:text-2xl font-semibold text-gray-900 truncate">
                {{ __('messages.manage_exchange_rates') }}
            </h1>
        </div>
    </div>
@endsection

@section('content')
<div class="py-6">
    <div class="px-4 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-4 bg-green-50 border border-green-200 text-green-600 px-4 py-3 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-300" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 00016zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l2-2z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-600">{{ session('success') }}</p>
                    </div>
                    <div class="ml-auto pl-3">
                        <div class="-mx-1.5 -my-1.5">
                            <button type="button" class="inline-flex bg-green-50 rounded-md p-1.5 text-green-400 hover:bg-green-100 transition-colors">
                                <span class="sr-only">Dismiss</span>
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-300" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 00016zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-red-600">{{ session('error') }}</p>
                    </div>
                    <div class="ml-auto pl-3">
                        <div class="-mx-1.5 -my-1.5">
                            <button type="button" class="inline-flex bg-red-50 rounded-md p-1.5 text-red-400 hover:bg-red-100 transition-colors">
                                <span class="sr-only">Dismiss</span>
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Taux de change actuel -->
        <div class="bg-white shadow rounded-lg mb-6">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">{{ __('messages.current_exchange_rate') }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <div class="text-3xl font-bold text-blue-500">
                            1 USD = {{ number_format($currentRate ?? 4484, 2, ',', ' ') }} MGA
                        </div>
                        <div class="text-sm text-gray-400 mt-1">
                            {{ __('messages.last_update') }} : {{ $exchangeRates->first()?->effective_date?->format('d/m/Y') ?? __('messages.not_defined') }}
                        </div>
                    </div>
                    <div>
                        <form action="{{ route('admin.exchange-rates.update-rate') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label for="rate" class="block text-sm font-medium text-gray-600">{{ __('messages.new_rate_usd_to_mga') }}</label>
                                <input type="number" id="rate" name="rate" step="0.0001" min="0.0001" max="99999.9999" required
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
                                       placeholder="4484">
                            </div>
                            <div>
                                <label for="notes" class="block text-sm font-medium text-gray-600">{{ __('messages.optional_notes') }}</label>
                                <textarea id="notes" name="notes" rows="2"
                                          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
                                          placeholder="{{ __('messages.modification_reason') }}"></textarea>
                            </div>
                            <button type="submit"
                                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-400">
                                Mettre à jour le taux
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Types d'investissement -->
        <div class="bg-white shadow rounded-lg mb-6">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">{{ __('messages.investment_types') }}</h3>
                    <button type="button" onclick="document.getElementById('addTypeModal').classList.remove('hidden')"
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-green-500 hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-400">
                        <svg class="-ml-0.5 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Ajouter un type
                    </button>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">{{ __('messages.name') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Min USD</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Max USD</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Min Ariary</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Max Ariary</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">{{ __('messages.status') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">{{ __('messages.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($investmentTypes as $type)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $type->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($type->min_amount_usd, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $type->max_amount_usd ? number_format($type->max_amount_usd, 2) : __('messages.unlimited') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($type->min_amount_usd * ($currentRate ?? 4484), 0, ',', ' ') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $type->max_amount_usd ? number_format($type->max_amount_usd * ($currentRate ?? 4484), 0, ',', ' ') : __('messages.unlimited') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($type->is_active)
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-50 text-green-600">{{ __('messages.active') }}</span>
                                        @else
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-50 text-gray-600">{{ __('messages.inactive') }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button type="button" onclick="editType({{ $type->id }})"
                                                class="text-blue-500 hover:text-blue-600 mr-3">
                                            Modifier
                                        </button>
                                        @if($type->investments()->count() === 0)
                                            <form action="{{ route('admin.exchange-rates.destroy-type', $type) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-600"
                                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce type d\'investissement ?')">
                                                    Supprimer
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Historique des taux de change -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">{{ __('messages.exchange_rate_history') }}</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">{{ __('messages.effective_date') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">{{ __('messages.rate') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">{{ __('messages.modified_by') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">{{ __('messages.notes') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">{{ __('messages.status') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($exchangeRates as $rate)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $rate->effective_date->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($rate->rate, 2, ',', ' ') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $rate->user?->name ?? __('messages.system') }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $rate->notes ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($rate->is_active)
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-50 text-green-600">{{ __('messages.active') }}</span>
                                        @else
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-50 text-gray-600">{{ __('messages.inactive') }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour ajouter un type d'investissement -->
<div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden" id="addTypeModal">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ __('messages.add_investment_type') }}</h3>
        </div>
        <form action="{{ route('admin.exchange-rates.store-type') }}" method="POST" class="mt-5">
            @csrf
            <div class="px-7 space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-600">{{ __('messages.name') }}</label>
                    <input type="text" id="name" name="name" required
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
                </div>
                <div>
                    <label for="slug" class="block text-sm font-medium text-gray-600">{{ __('messages.slug') }}</label>
                    <input type="text" id="slug" name="slug" required
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
                </div>
                <div>
                    <label for="min_amount_usd" class="block text-sm font-medium text-gray-600">{{ __('messages.min_amount_usd') }}</label>
                    <input type="number" id="min_amount_usd" name="min_amount_usd" step="0.01" min="0.01" required
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
                </div>
                <div>
                    <label for="max_amount_usd" class="block text-sm font-medium text-gray-600">{{ __('messages.max_amount_usd') }}</label>
                    <input type="number" id="max_amount_usd" name="max_amount_usd" step="0.01" min="0.01"
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
                </div>
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-600">{{ __('messages.description') }}</label>
                    <textarea id="description" name="description" rows="3"
                              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-400"></textarea>
                </div>
                <div>
                    <label for="sort_order" class="block text-sm font-medium text-gray-600">{{ __('messages.display_order') }}</label>
                    <input type="number" id="sort_order" name="sort_order" min="0" value="0"
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
                </div>
                <div class="flex items-center">
                    <input type="checkbox" id="is_active" name="is_active" value="1" checked
                           class="h-4 w-4 text-blue-500 focus:ring-blue-400 border-gray-300 rounded">
                    <label for="is_active" class="ml-2 block text-sm text-gray-800">{{ __('messages.active') }}</label>
                </div>
            </div>
            <div class="px-7 py-3 bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse rounded-b-lg">
                <button type="button" onclick="document.getElementById('addTypeModal').classList.add('hidden')"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-gray-500 text-base font-medium text-white hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 sm:ml-3 sm:w-auto sm:text-sm">
                    Annuler
                </button>
                <button type="submit"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-500 text-base font-medium text-white hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-400 sm:ml-3 sm:w-auto sm:text-sm">
                    Ajouter
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal pour modifier un type d'investissement -->
<div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden" id="editTypeModal">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ __('messages.edit_investment_type') }}</h3>
        </div>
        <form id="editTypeForm" method="POST" class="mt-5">
            @csrf
            @method('PUT')
            <div class="px-7 space-y-4">
                <div>
                    <label for="edit_name" class="block text-sm font-medium text-gray-600">{{ __('messages.name') }}</label>
                    <input type="text" id="edit_name" name="name" required
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
                </div>
                <div>
                    <label for="edit_min_amount_usd" class="block text-sm font-medium text-gray-600">{{ __('messages.min_amount_usd') }}</label>
                    <input type="number" id="edit_min_amount_usd" name="min_amount_usd" step="0.01" min="0.01" required
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
                </div>
                <div>
                    <label for="edit_max_amount_usd" class="block text-sm font-medium text-gray-600">{{ __('messages.max_amount_usd') }}</label>
                    <input type="number" id="edit_max_amount_usd" name="max_amount_usd" step="0.01" min="0.01"
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
                </div>
                <div>
                    <label for="edit_description" class="block text-sm font-medium text-gray-600">{{ __('messages.description') }}</label>
                    <textarea id="edit_description" name="description" rows="3"
                              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-400"></textarea>
                </div>
                <div>
                    <label for="edit_sort_order" class="block text-sm font-medium text-gray-600">{{ __('messages.display_order') }}</label>
                    <input type="number" id="edit_sort_order" name="sort_order" min="0"
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
                </div>
                <div class="flex items-center">
                    <input type="checkbox" id="edit_is_active" name="is_active" value="1"
                           class="h-4 w-4 text-blue-500 focus:ring-blue-400 border-gray-300 rounded">
                    <label for="edit_is_active" class="ml-2 block text-sm text-gray-800">{{ __('messages.active') }}</label>
                </div>
            </div>
            <div class="px-7 py-3 bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse rounded-b-lg">
                <button type="button" onclick="document.getElementById('editTypeModal').classList.add('hidden')"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-gray-500 text-base font-medium text-white hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 sm:ml-3 sm:w-auto sm:text-sm">
                    Annuler
                </button>
                <button type="submit"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-500 text-base font-medium text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-400 sm:ml-3 sm:w-auto sm:text-sm">
                    Modifier
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
const investmentTypes = @json($investmentTypes);

function editType(typeId) {
    const type = investmentTypes.find(t => t.id === typeId);
    if (!type) return;

    document.getElementById('edit_name').value = type.name;
    document.getElementById('edit_min_amount_usd').value = type.min_amount_usd;
    document.getElementById('edit_max_amount_usd').value = type.max_amount_usd || '';
    document.getElementById('edit_description').value = type.description || '';
    document.getElementById('edit_sort_order').value = type.sort_order;
    document.getElementById('edit_is_active').checked = type.is_active;

    const form = document.getElementById('editTypeForm');
    form.action = `{{ route('admin.exchange-rates.update-type', ':id') }}`.replace(':id', typeId);

    document.getElementById('editTypeModal').classList.remove('hidden');
}

// Auto-refresh des montants en Ariary toutes les 30 secondes
setInterval(() => {
    fetch('{{ route("admin.exchange-rates.current") }}')
        .then(response => response.json())
        .then(data => {
            // Mettre à jour l'affichage du taux actuel
            const locale = app()->getLocale() === 'fr' ? 'fr-FR' : 'en-US';
            document.querySelector('.text-3xl.font-bold').innerHTML =
                `1 USD = ${parseFloat(data.current_rate).toLocaleString(locale, {minimumFractionDigits: 2, maximumFractionDigits: 2})} MGA`;

            // Mettre à jour les montants en Ariary dans le tableau
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach((row, index) => {
                if (index < investmentTypes.length) {
                    const type = investmentTypes[index];
                    const minAriary = data.rates[type.name]?.min_ariary || 0;
                    const maxAriary = data.rates[type.name]?.max_ariary;

                    const locale = app()->getLocale() === 'fr' ? 'fr-FR' : 'en-US';
                    row.cells[3].textContent = parseFloat(minAriary).toLocaleString(locale);
                    row.cells[4].textContent = maxAriary ? parseFloat(maxAriary).toLocaleString(locale) : (app()->getLocale() === 'fr' ? 'Illimité' : 'Unlimited');
                }
            });
        })
        .catch(error => console.error('Error fetching exchange rates:', error));
}, 30000);
</script>
@endpush
@endsection
