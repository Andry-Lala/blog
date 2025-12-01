@extends('layouts.dashboard')

@section('title', __('messages.my_information'))

@section('header')
    <div class="ml-4 flex items-center">
        <h1 class="text-2xl font-semibold text-gray-900">{{ __('messages.my_information') }}</h1>
    </div>
@endsection

@section('content')
<div class="py-6">
    <div class="px-4 sm:px-6 lg:px-8">
        <!-- Welcome section -->
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-900">
                {{ __('messages.welcome_back') }}, {{ $user->prenom }} {{ $user->nom }}!
            </h2>
            <p class="mt-1 text-sm text-gray-600">
                {{ __('messages.consult_manage_info') }}
            </p>
        </div>

        <!-- Actions Header -->
        <div class="mb-6 flex items-center justify-between">
            <h3 class="text-lg font-medium text-gray-900">{{ __('messages.details_information') }}</h3>
            <div class="flex space-x-3">
                <a href="{{ route('dashboard') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    {{ __('messages.back') }}
                </a>
                <a href="{{ route('clients.show', $user) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    {{ __('messages.edit') }}
                </a>
            </div>
        </div>

        <!-- User Information Card -->
        <div class="mb-8 bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">{{ __('messages.your_information') }}</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Basic Information -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-900 mb-4">{{ __('messages.basic_information') }}</h4>
                        <dl class="space-y-3">
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-600">{{ __('messages.client_code') }}</dt>
                                <dd class="text-sm font-medium text-gray-900">{{ $user->code_utilisateur }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-600">{{ __('messages.username') }}</dt>
                                <dd class="text-sm font-medium text-gray-900">{{ $user->username }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-600">{{ __('messages.email') }}</dt>
                                <dd class="text-sm font-medium text-gray-900">{{ $user->email }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-600">{{ __('messages.phone') }}</dt>
                                <dd class="text-sm font-medium text-gray-900">{{ $user->telephone ?? '-' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-600">{{ __('messages.status') }}</dt>
                                <dd>
                                    @if($user->statut)
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-50 text-green-600">{{ __('messages.verified') }}</span>
                                    @else
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-50 text-yellow-600">{{ __('messages.pending_validation') }}</span>
                                    @endif
                                </dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Personal Information -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-900 mb-4">{{ __('messages.personal_information') }}</h4>
                        <dl class="space-y-3">
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-600">{{ __('messages.birth_date') }}</dt>
                                <dd class="text-sm font-medium text-gray-900">{{ $user->date_naissance ? $user->date_naissance->format('d/m/Y') : '-' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-600">{{ __('messages.birth_place') }}</dt>
                                <dd class="text-sm font-medium text-gray-900">{{ $user->lieu_naissance ?? '-' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-600">{{ __('messages.nationality') }}</dt>
                                <dd class="text-sm font-medium text-gray-900">{{ $user->nationalite ?? '-' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-600">{{ __('messages.profession') }}</dt>
                                <dd class="text-sm font-medium text-gray-900">{{ $user->profession ?? '-' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-600">{{ __('messages.address') }}</dt>
                                <dd class="text-sm font-medium text-gray-900 text-xs">{{ $user->adresse ?? '-' }}</dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Identity Information -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-900 mb-4">{{ __('messages.identity_document') }}</h4>
                        <dl class="space-y-3">
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-600">{{ __('messages.id_document_type') }}</dt>
                                <dd class="text-sm font-medium text-gray-900">{{ $user->piece_identite ?? '-' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-600">{{ __('messages.id_document_number') }}</dt>
                                <dd class="text-sm font-medium text-gray-900">{{ $user->numero_piece ?? '-' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-600">{{ __('messages.id_issue_date') }}</dt>
                                <dd class="text-sm font-medium text-gray-900">{{ $user->date_delivrance ? $user->date_delivrance->format('d/m/Y') : '-' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-600">{{ __('messages.id_issue_place') }}</dt>
                                <dd class="text-sm font-medium text-gray-900">{{ $user->lieu_delivrance ?? '-' }}</dd>
                            </div>
                            @if($user->date_validation)
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-600">{{ __('messages.validated_on') }}</dt>
                                    <dd class="text-sm font-medium text-gray-900">{{ $user->date_validation->format('d/m/Y H:i') }}</dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                </div>

                @if($user->notes)
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">{{ __('messages.notes') }}</h4>
                        <p class="text-sm text-gray-700">{{ $user->notes }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
