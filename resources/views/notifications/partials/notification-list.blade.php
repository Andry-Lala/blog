@if($notifications->count() > 0)
    @foreach($notifications as $notification)
        <div class="notification-item {{ $notification->is_read ? 'opacity-75' : '' }}"
             data-id="{{ $notification->id }}"
             onclick="showNotificationDetails({{ $notification->id }})"
             class="px-6 py-4 hover:bg-gray-50 cursor-pointer transition-colors">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <i class="{{ $notification->icon }}"></i>
                </div>
                <div class="ml-3 flex-1">
                    <div class="flex items-center justify-between">
                        <h4 class="text-sm font-medium text-gray-900">
                            {{ $notification->title }}
                            @if(!$notification->is_read)
                                <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ __('messages.new_notification') }}
                                    </span>
                            @endif
                        </h4>
                        <div class="flex items-center space-x-2">
                            <span class="text-xs text-gray-500">
                                {{ $notification->created_at->diffForHumans() }}
                            </span>
                            <button onclick="event.stopPropagation(); deleteNotification({{ $notification->id }})"
                                    class="text-red-600 hover:text-red-800">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <p class="mt-1 text-sm text-gray-600">
                        {{ $notification->message }}
                    </p>
                    @if($notification->related)
                        <div class="mt-2">
                            <a href="{{ getNotificationLink($notification) }}"
                               class="text-sm text-blue-600 hover:text-blue-800"
                               onclick="event.stopPropagation()">
                                {{ __('messages.view_details') }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
@else
    <div class="px-6 py-12 text-center">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900">{{ __('messages.no_notifications') }}</h3>
        <p class="mt-1 text-sm text-gray-500">{{ __('messages.no_notifications_currently') }}</p>
    </div>
@endif
