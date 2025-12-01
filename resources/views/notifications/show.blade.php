@extends('layouts.dashboard')

@section('title', __('messages.notification_details'))

@section('header')
    <h1 class="ml-4 text-2xl font-semibold text-gray-900">{{ __('messages.notification_details') }}</h1>
@endsection

@section('content')
<div class="py-6">
    <div class="px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto">
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900">{{ __('messages.details') }}</h3>
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('notifications.index') }}"
                           class="text-sm text-blue-600 hover:text-blue-800">
                            {{ __('messages.back_to_list') }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="{{ $notification->icon }} text-2xl"></i>
                    </div>
                    <div class="ml-4 flex-1">
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="text-lg font-medium text-gray-900">
                                {{ $notification->title }}
                                @if(!$notification->is_read)
                                    <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ __('messages.new_notification') }}
                                    </span>
                                @endif
                            </h4>
                            <span class="text-sm text-gray-500">
                                {{ $notification->created_at->format('d/m/Y H:i') }}
                            </span>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-4 mb-4">
                            <p class="text-gray-700">
                                {{ $notification->message }}
                            </p>
                        </div>

                        <div class="flex items-center justify-between mb-4">
                            <div class="text-sm text-gray-500">
                                {{ __('messages.type') }}: <span class="font-medium">{{ ucfirst($notification->type) }}</span>
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ __('messages.status') }}:
                                @if($notification->is_read)
                                    <span class="text-green-600 font-medium">{{ __('messages.read') }}</span>
                                @else
                                    <span class="text-blue-600 font-medium">{{ __('messages.unread') }}</span>
                                @endif
                            </div>
                        </div>

                        @if($notification->related)
                            <div class="border-t border-gray-200 pt-4">
                                <h5 class="text-sm font-medium text-gray-900 mb-2">{{ __('messages.related_item') }}</h5>
                                <a href="{{ getNotificationLink($notification) }}"
                                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    {{ __('messages.view_details') }} →
                                </a>
                            </div>
                        @endif

                        @if($notification->data && !empty($notification->data))
                            <div class="border-t border-gray-200 pt-4 mt-4">
                                <h5 class="text-sm font-medium text-gray-900 mb-2">{{ __('messages.additional_information') }}</h5>
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <pre class="text-xs text-gray-600 overflow-x-auto">{{ json_encode($notification->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-500">
                        ID: {{ $notification->id }}
                    </div>
                    <div class="flex items-center space-x-2">
                        @if(!$notification->is_read)
                            <form method="POST" action="{{ route('notifications.read', $notification->id) }}" class="inline">
                                @csrf
                                <button type="submit"
                                        class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    {{ __('messages.mark_as_read') }}
                                </button>
                            </form>
                        @endif
                        <form method="POST" action="{{ route('notifications.destroy', $notification->id) }}"
                              class="inline"
                              onsubmit="return confirm('{{ __('messages.confirm_delete_notification') }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                {{ __('messages.delete') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
