<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Contact Form Submissions') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ showModal: false, selected: null }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{-- FIX: Scrollable Wrapper --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left font-medium uppercase whitespace-nowrap">Status</th>
                                    <th class="px-6 py-3 text-left font-medium uppercase whitespace-nowrap">Name</th>
                                    <th class="px-6 py-3 text-left font-medium uppercase whitespace-nowrap">Email</th>
                                    <th class="px-6 py-3 text-left font-medium uppercase min-w-[150px]">Subject</th>
                                    <th class="px-6 py-3 text-left font-medium uppercase whitespace-nowrap">Date</th>
                                    <th class="px-6 py-3 text-right font-medium uppercase whitespace-nowrap">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($submissions as $submission)
                                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer transition-colors"
                                        @click="selected = {{ $submission->toJson() }}; showModal = true">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($submission->is_seen)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Seen</span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">New</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $submission->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $submission->email }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ Str::limit($submission->subject, 30) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $submission->created_at->format('M d, Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right font-medium">
                                            <button type="button" class="text-blue-600 hover:text-blue-900 font-bold" @click.stop="selected = {{ $submission->toJson() }}; showModal = true">
                                                View
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                            No contact submissions found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $submissions->links() }}
                    </div>
                </div>
            </div>
        </div>

                {{-- MODAL --}}
        <div x-show="showModal" 
             style="display: none;"
             class="fixed inset-0 z-50 overflow-y-auto" 
             aria-labelledby="modal-title" role="dialog" aria-modal="true">
             
            {{-- Wrapper --}}
            <div class="flex items-end justify-end min-h-screen text-center">
                
                {{-- Backdrop (Custom Opacity 0.35) --}}
                <div x-show="showModal"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 bg-gray-500 transition-opacity"
                     style="--tw-bg-opacity: 0.35;" 
                     @click="showModal = false"
                     aria-hidden="true"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                {{-- Modal Panel (Gmail Style - Slide Up Animation) --}}
                <div x-show="showModal"
                     x-transition:enter="transform transition ease-out duration-300"
                     x-transition:enter-start="translate-y-full opacity-0"
                     x-transition:enter-end="translate-y-0 opacity-100"
                     x-transition:leave="transform transition ease-in duration-200"
                     x-transition:leave-start="translate-y-0 opacity-100"
                     x-transition:leave-end="translate-y-full opacity-0"
                     class="relative inline-flex flex-col align-bottom bg-white dark:bg-gray-800 rounded-t-lg text-left shadow-2xl mr-4 sm:max-w-2xl w-full border border-gray-200 dark:border-gray-700 h-auto max-h-[85vh]">
                    
                    {{-- Header --}}
                    <div class="bg-gray-900 text-white px-4 py-3 flex justify-between items-center rounded-t-lg cursor-pointer flex-shrink-0" @click="showModal = false">
                        <h3 class="text-sm font-bold tracking-wide">
                            REPLY MESSAGE
                        </h3>
                        <div class="flex items-center space-x-2">
                             {{-- Minimize/Close --}}
                            <button @click.stop="showModal = false" class="text-gray-400 hover:text-white focus:outline-none">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Content Body (Scrollable) --}}
                    <div class="bg-white dark:bg-gray-800 px-6 py-4 overflow-y-auto">
                        
                        {{-- Meta Info --}}

                                <div class="mb-4 text-sm text-gray-600 dark:text-gray-400 border-b border-gray-100 dark:border-gray-700 pb-4">

                                    <div class="flex justify-between mb-1">

                                        <span><strong>From:</strong> <span x-text="selected?.name"></span> &lt;<span x-text="selected?.email"></span>&gt;</span>

                                        <span class="text-xs text-gray-500" x-text="new Date(selected?.created_at).toLocaleString()"></span>

                                    </div>

                                    <div class="mb-2"><strong>Subject:</strong> <span x-text="selected?.subject"></span></div>

                                    <div class="bg-gray-50 dark:bg-gray-900 p-3 rounded text-gray-800 dark:text-gray-200 whitespace-pre-wrap italic border-l-4 border-gray-300 dark:border-gray-600" x-text="selected?.feedback"></div>

                                </div>

        

                                {{-- REPLY FORM --}}

                                <div x-data="{ 

                                        replyBody: '', 

                                        touched: false,

                                        get error() {

                                            if (this.touched && this.replyBody.trim().length === 0) return 'Message cannot be empty.';

                                            if (this.touched && this.replyBody.trim().length < 10) return 'Message is too short (min 10 chars).';

                                            return null;

                                        },

                                        get isValid() {

                                            return this.replyBody.trim().length >= 10;

                                        }

                                     }">

                                    <form :action="`/admin/contact-submissions/${selected?.id}/reply`" method="POST">

                                        @csrf

                                        

                                        <div class="relative">

                                            <textarea 

                                                name="reply_message" 

                                                x-model="replyBody"

                                                @blur="touched = true"

                                                @input="touched = true"

                                                rows="6" 

                                                class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm resize-none p-3" 

                                                :class="{ 'border-red-500 focus:border-red-500 focus:ring-red-500': error }"

                                                placeholder="Type your reply here..." required></textarea>

                                            

                                            {{-- Error Message --}}

                                            <div x-show="error" x-text="error" class="text-red-500 text-xs mt-1 absolute bottom-[-20px] left-0"></div>

                                        </div>

                                        

                                        <div class="mt-8 flex justify-between items-center">

                                            <div class="text-xs text-gray-400">

                                                <span x-show="!selected?.is_seen" class="flex items-center text-blue-500">

                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>

                                                    Will mark as seen

                                                </span>

                                            </div>

        

                                            <div class="flex gap-3">

                                                <button type="button" 

                                                        class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-md text-sm font-medium transition-colors" 

                                                        @click="showModal = false">

                                                    Discard

                                                </button>

                                                <button type="submit" 

                                                        :disabled="!isValid"

                                                        :class="{ 'opacity-50 cursor-not-allowed': !isValid, 'hover:bg-blue-700': isValid }"

                                                        class="px-6 py-2 bg-blue-600 text-white rounded-md text-sm font-medium shadow-sm transition-all flex items-center">

                                                    Send Reply 

                                                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>

                                                </button>

                                            </div>

                                        </div>

                                    </form>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </x-app-layout>

        