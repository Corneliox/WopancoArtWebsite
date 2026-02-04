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
             
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                {{-- Backdrop --}}
                <div x-show="showModal"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
                     @click="showModal = false"
                     aria-hidden="true"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                {{-- Modal Panel --}}
                <div x-show="showModal"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                    
                    <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100" id="modal-title">
                                    Message Details
                                </h3>
                                <div class="mt-4 space-y-3 text-sm text-gray-500 dark:text-gray-300">
                                    <p><strong>Status:</strong> <span x-text="selected?.is_seen ? 'Seen' : 'New'" :class="selected?.is_seen ? 'text-green-600' : 'text-yellow-600'"></span></p>
                                    <p><strong>Name:</strong> <span x-text="selected?.name"></span></p>
                                    <p><strong>Email:</strong> <span x-text="selected?.email"></span></p>
                                    <p><strong>Date:</strong> <span x-text="new Date(selected?.created_at).toLocaleDateString()"></span></p>
                                    <hr class="border-gray-200 dark:border-gray-600">
                                    <p><strong>Subject:</strong> <span x-text="selected?.subject"></span></p>
                                    <div class="bg-gray-50 dark:bg-gray-900 p-3 rounded text-gray-800 dark:text-gray-200 whitespace-pre-wrap" x-text="selected?.feedback"></div>
                                </div>

                                {{-- REPLY FORM --}}
                                <div class="mt-6">
                                    <h4 class="font-bold text-gray-900 dark:text-gray-100 mb-2">Reply</h4>
                                    <form :action="`/admin/contact-submissions/${selected?.id}/reply`" method="POST">
                                        @csrf
                                        <textarea name="reply_message" rows="4" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" placeholder="Type your reply here..." required></textarea>
                                        
                                        <div class="mt-4 flex justify-between items-center">
                                            {{-- Mark as Seen Button (if needed separately, but Reply does it) --}}
                                            <div x-show="!selected?.is_seen">
                                                <span class="text-xs text-gray-500">Will be marked as seen upon reply.</span>
                                            </div>

                                            <div class="flex gap-2 justify-end w-full">
                                                <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" @click="showModal = false">
                                                    Close
                                                </button>
                                                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                                                    Send Reply
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
        </div>
    </div>
</x-app-layout>