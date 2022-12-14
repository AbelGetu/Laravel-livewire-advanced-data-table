<div class="py-4 space-y-4">
    <div class="flex justify-between">
        <div class="w-2/4 flex gap-2">
            <x-input.text wire:model="filters.search" placeholder="Search Transactions..."/>

            <x-button.link wire:click="$toggle('showFilters')">@if($showFilters) Hide @endif Advanced Search...</x-button.link>
        </div>

        <div class="space-x-2 flex items-center">

            <x-input.group borderless paddingless for="perPage" label="Per Page">
                <x-input.select wire:model="perPage" id="perPage">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </x-input.select>
            </x-input.group>

            <x-dropdown label="Bulk Actions">

                <x-dropdown.item wire:click="exportSelected" type="button" class="flex items-center space-x-2">
                    <x-icon.download class="text-cool-gray-400" /> <span>Export</span>
                </x-dropdown.item>

                {{-- <x-dropdown.item onclick="confirm('Are you sure?') || event.stopImmediatePropagation()" wire:click="deleteSelected" type="button" class="flex items-center space-x-2">
                    <x-icon.trash class="text-cool-gray-400" /> <span>Delete</span>
                </x-dropdown.item> --}}
                <x-dropdown.item wire:click="$toggle('showDeleteModal')" type="button" class="flex items-center space-x-2">
                    <x-icon.trash class="text-cool-gray-400" /> <span>Delete</span>
                </x-dropdown.item>

            </x-dropdown>

            <livewire:import-transactions />

            <x-button.primary wire:click="create"><x-icon.plus /> New</x-button.primary>
        </div>
    </div>

    <div>
         @if($showFilters)
         <div class="bg-cool-gray-200 p-4 rounded shadow-inner flex relative">
            <div class="w-1/2 pr-2 space-y-4">
                <x-input.group inline for="filter-status" label="Status">
                    <x-input.select wire:model="filters.status" id="filter-status">
                        <option value="" disabled>Select Status...</option>

                        @foreach (App\Models\Transaction::STATUSES as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-input.select>
                </x-input.group>

                <x-input.group inline for="filter-amount-min" label="Minimum Amount">
                    <x-input.money wire:model.lazy="filters.amount-min" id="filter-amount-min" />
                </x-input.group>

                <x-input.group inline for="filter-amount-max" label="Maximum Amount">
                    <x-input.money wire:model.lazy="filters.amount-max" id="filter-amount-max" />
                </x-input.group>
            </div>

            <div class="w-1/2 pl-2 space-y-4">
                <x-input.group inline for="filter-date-min" label="Minimum Date">
                    <x-input.date wire:model="filters.date-min" id="filter-date-min" placeholder="MM/DD/YYYY" />
                </x-input.group>

                <x-input.group inline for="filter-date-max" label="Maximum Date">
                    <x-input.date wire:model="filters.date-max" id="filter-date-max" placeholder="MM/DD/YYYY" />
                </x-input.group>

                <x-button.link wire:click="resetFilters" class="absolute right-0 bottom-0 p-4">Reset Filters</x-button.link>
            </div>
        </div>
         @endif
    </div>
    
    <div class="flex-col space-y-4">
        <x-table>
            <x-slot name="head">  
                <x-table.heading class="pr-0 w-8">
                    <x-input.checkbox wire:model="selectPage" />
                </x-table.heading>            
                <x-table.heading sortable multi-column wire:click="sortBy('title')" :direction="$sorts['title'] ?? null" class="w-full">Title</x-table.heading>            
                <x-table.heading sortable multi-column wire:click="sortBy('amount')" :direction="$sorts['amount'] ?? null" >Amount</x-table.heading>            
                <x-table.heading sortable multi-column wire:click="sortBy('status')" :direction="$sorts['status'] ?? null">Status</x-table.heading>            
                <x-table.heading sortable multi-column wire:click="sortBy('date')" :direction="$sorts['date'] ?? null">Date</x-table.heading>   
                <x-table.heading />         
            </x-slot>
           
            <x-slot name="body"> 
                @if ($selectPage)
                <x-table.row class="bg-cool-gray-300" wire:key="row-message">
                    <x-table.cell colspan="6">  
                        @unless ($selectAll)
                            <div>
                                <span>You have select <strong>{{ $transactions->count() }}</strong> transactions, do you want to select all <strong>{{ $transactions->total() }}</strong>? </span>
                                <x-button.link wire:click="selectAll" class="ml-1 text-blue-600">Select All</x-button.link>
                            </div>                           
                        @else
                            <span>You currently selecting all <strong>{{ $transactions->total() }}</strong> transactions</span>
                        @endif
                    </x-table.cell>                  
                </x-table.row>
                @endif
               

                @forelse ($transactions as $transaction)
                    <x-table.row wire:loading.class.delay="opacity-50" wire:key="row-{{ $transaction->id }}">
                        <x-table.cell class="pr-0">
                            <x-input.checkbox wire:model="selected" value="{{ $transaction->id }}" />
                        </x-table.cell>
                        <x-table.cell class="flex gap-1">
                            <x-icon.cash class="text-gray-500" />
                            <p class="text-gray-600"> {{ $transaction->title }} </p>
                        </x-table.cell>
                        <x-table.cell>
                            <span class="text-gray-900 font-medium">
                                ${{ $transaction->amount }}
                            </span> USD
                        </x-table.cell>
                        <x-table.cell>
                            <span class="bg-{{ $transaction->status_color }}-500 rounded-full font-medium p-2">
                                {{ $transaction->status }}
                            </span>
                        </x-table.cell>
                        <x-table.cell>{{ $transaction->date_for_humans }}</x-table.cell>
                        <x-table.cell>
                            <x-button.link wire:click="edit({{ $transaction->id }})">Edit</x-button.link>
                        </x-table.cell>
                    </x-table.row>
                @empty
                <x-table.row>
                    <x-table.cell colspan="4">
                        <div class="flex justify-center items-center">
                            No transactions found...
                        </div>
                    </x-table.cell>
                </x-table.row>
                @endforelse                              
            </x-slot>
        </x-table>

        <div>
            {{ $transactions->links() }}
        </div>
    </div>

    <form wire:submit.prevent="deleteSelected">
        <x-modal.confirmation wire:model.defer="showDeleteModal">
            <x-slot name="title">Delete Transaction</x-slot>
            <x-slot name="content">
                Are you sure you want to delete this transactions? This action is irreversable.
            </x-slot>
            <x-slot name="footer">
                <x-button.secondary wire:click="$set('showDeleteModal', false)">Cancel</x-button.secondary>
                <x-button.primary type='submit'>Delete</x-button.primary>
            </x-slot>
        </x-modal.confirmati>
    </form>

    <form wire:submit.prevent="save">
        <x-modal.dialog wire:model.defer="showEditModal">
            <x-slot name="title">Edit Transaction</x-slot>
            <x-slot name="content">
                <x-input.group for="title" label="Title" :error="$errors->first('editing.title')">
                    <x-input.text wire:model.lazy="editing.title" id="title" placeholder="Title"/>
                </x-input.group>

                <x-input.group for="amount" label="Amount" :error="$errors->first('editing.amount')">
                    <x-input.money wire:model.lazy="editing.amount" id="amount" />
                </x-input.group>

                <x-input.group for="status" label="Status" :error="$errors->first('editing.status')">
                    <x-input.select wire:model.lazy="editing.status" id="status">
                        @foreach (App\Models\Transaction::STATUSES as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-input.select>
                </x-input.group>

                <x-input.group for="date" label="Date" :error="$errors->first('editing.date')">
                    <x-input.date wire:model.lazy="editing.date" id="date" />
                </x-input.group>
            </x-slot>
            <x-slot name="footer">
                <x-button.secondary wire:click="$set('showEditModal', false)">Cancel</x-button.secondary>
                <x-button.primary type='submit'>Save</x-button.primary>
            </x-slot>
        </x-modal.dialog>
    </form>
  
  
</div>
