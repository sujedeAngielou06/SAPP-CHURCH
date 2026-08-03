@extends('layouts.adminDashboard')

@section('title', 'Confirmation — ' . config('app.name', 'SAPP Church'))

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/christening/applicationOfChristening.css') }}">
    <link rel="stylesheet" href="{{ asset('css/confirmation/confirmationKompirmaModals.css') }}">
@endpush

@section('content')
    <div class="sappc-registry-page">
    <input type="hidden" id="cnSelectedConfirmationId" value="">

    <h1 class="sappc-page-title">
        <i class="fa-solid fa-file-lines" aria-hidden="true"></i>
        CONFIRMATION
    </h1>
    <p class="sappc-page-breadcrumb mb-0">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <span class="sappc-page-breadcrumb_sep" aria-hidden="true">|</span>
        <span>Confirmation</span>
    </p>

    <div class="sappc-registry-toolbar" role="toolbar" aria-label="Confirmation record actions">
        <span class="sappc-registry-toolbar_record">RECORD</span>
        <div class="sappc-registry-toolbar_actions">
            <button type="button" class="sappc-registry-toolbar_btn sappc-registry-toolbar_btn--reload" id="confirmationReloadBtn" title="Reload" aria-label="Reload table">
                <i class="fa-solid fa-rotate-right" aria-hidden="true"></i>
                Reload
            </button>
            <button type="button" class="sappc-registry-toolbar_btn sappc-registry-toolbar_btn--cta"
                id="confirmationScheduleRequestBtn"
                data-schedule-save-url="{{ route('admin.confirmation.schedule-request') }}"
                data-schedule-reserved-url="{{ route('admin.confirmation.schedule-reserved-dates') }}" title="Schedule request"
                aria-label="Open schedule request" aria-expanded="false" aria-controls="confirmationScheduleRequestModal"
                data-bs-toggle="modal" data-bs-target="#confirmationScheduleRequestModal">
                <i class="fa-solid fa-calendar-days" aria-hidden="true"></i>
                Schedule Request
            </button>
            <button type="button" class="sappc-registry-toolbar_btn sappc-registry-toolbar_btn--outline"
                id="confirmationPaymentFeeBtn" title="Payment fee" aria-label="Open payment fee" aria-expanded="false"
                aria-controls="confirmationPaymentFeeModal">
                <i class="fa-solid fa-money-bill-wave" aria-hidden="true"></i>
                Payment Fee
            </button>
            <button type="button" class="sappc-registry-toolbar_btn sappc-registry-toolbar_btn--app"
                id="confirmationApplicationFormBtn" title="Aplikasyon sa Kompirma"
                aria-label="Open confirmation application" aria-expanded="false"
                aria-controls="confirmationApplicationModal"
                data-confirmation-application-details-url="{{ route('admin.confirmation.application-details') }}"
                data-confirmation-application-save-url="{{ route('admin.confirmation.application-save') }}"
                data-confirmation-arancel-details-url="{{ route('admin.confirmation.arancel-details') }}"
                data-confirmation-arancel-save-url="{{ route('admin.confirmation.arancel-save') }}">
                <i class="fa-solid fa-file-lines" aria-hidden="true"></i>
                Application Form
            </button>
        </div>
    </div>

    <section
        class="sappc-table-panel"
        id="confirmationRecordsPanel"
        data-table-colspan="7"
        data-records-url="{{ route('admin.dashboard.records') }}"
        data-registry-type="confirmation"
        data-section="{{ $activeSection ?? 'application' }}"
        data-next-reference-url="{{ route('admin.confirmation.next-reference-code') }}"
        data-payment-details-url="{{ route('admin.confirmation.payment-details') }}"
        data-payment-save-url="{{ route('admin.confirmation.payment-save') }}"
        data-confirmation-application-details-url="{{ route('admin.confirmation.application-details') }}"
        data-confirmation-application-save-url="{{ route('admin.confirmation.application-save') }}"
        data-confirmation-arancel-details-url="{{ route('admin.confirmation.arancel-details') }}"
        data-confirmation-arancel-save-url="{{ route('admin.confirmation.arancel-save') }}"
        data-confirmation-delete-url="{{ route('admin.confirmation.record-delete') }}"
        data-schedule-details-url="{{ route('admin.confirmation.schedule-details') }}"
        aria-label="Confirmation records"
    >
        <div class="sappc-table-toolbar">
            <div class="sappc-table-toolbar_row sappc-table-toolbar_row--primary">
                <div class="sappc-table-toolbar_entries">
                    <label class="visually-hidden" for="confirmationEntries">Entries per page</label>
                    <select id="confirmationEntries" class="form-select form-select-sm sappc-table-toolbar_select" aria-label="Entries per page">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                <div class="sappc-toolbar-date-strip" role="group" aria-label="Filter by date range">
                    <span class="sappc-toolbar-date-strip_label">From:</span>
                    <input type="date" id="confirmationDateFrom" class="sappc-toolbar-date-strip_input" name="date_from" aria-label="From date">
                    <span class="sappc-toolbar-date-strip_label">To:</span>
                    <input type="date" id="confirmationDateTo" class="sappc-toolbar-date-strip_input" name="date_to" aria-label="To date">
                    <button type="button" class="sappc-toolbar-date-strip_btn">Filter</button>
                </div>
                <div class="sappc-table-toolbar_letters" role="group" aria-label="Filter by first letter of client last name">
                    <span class="visually-hidden">Filter by first letter of last name A through Z; scroll horizontally to see all letters.</span>
                    <div class="sappc-letter-filter_letters">
                        @foreach (range('A', 'Z') as $letter)
                            <button type="button" class="sappc-letter-filter_btn" data-letter="{{ $letter }}">{{ $letter }}</button>
                        @endforeach
                    </div>
                </div>
                <div class="sappc-table-toolbar_search" role="search">
                    <label class="sappc-table-toolbar_search-heading" for="confirmationSearch">Search:</label>
                    <div class="sappc-table-toolbar_search-wrap">
                        <input type="search" id="confirmationSearch" class="form-control form-control-sm sappc-table-toolbar_search-input" placeholder="" autocomplete="off" aria-label="Search confirmation records" aria-controls="confirmationTableBody">
                        <i class="fa-solid fa-magnifying-glass sappc-table-toolbar_search-icon" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive sappc-table-panel_scroll">
            <table class="table table-bordered mb-0 sappc-data-table">
                <thead>
                    <tr>
                        <th scope="col">NO.</th>
                        <th scope="col">REFERENCE CODE</th>
                        <th scope="col">CLIENT</th>
                        <th scope="col">ADDRESS</th>
                        <th scope="col">CONTACT NUMBER</th>
                        <th scope="col">DATE CREATED</th>
                        <th scope="col" class="text-center">ACTION</th>
                    </tr>
                </thead>
                <tbody id="confirmationTableBody" aria-live="polite" aria-relevant="additions text">
                    <tr class="sappc-table-loading">
                        <td colspan="7" class="text-center text-muted py-4">Loading...</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="sappc-table-footer">
            <p class="sappc-table-footer_info mb-0" id="confirmationTableFooterInfo">Showing 0 entries</p>
            <nav class="sappc-pagination" id="confirmationPagination" aria-label="Table pagination"></nav>
        </div>
    </section>
    </div>
@endsection

@push('modals')
    @include('confirmation.partials.paymentFeeModal', ['generatedReferenceCode' => $generatedReferenceCode ?? '', 'defaultPaymentFeeRows' => $defaultPaymentFeeRows ?? []])
    @include('confirmation.partials.applicationModal')
    @include('confirmation.partials.scheduleRequestModal', ['generatedReferenceCode' => $generatedReferenceCode ?? ''])
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @include('confirmation.js.confirmationScript', [
        'initialTablePayload' => $initialTablePayload ?? null,
        'activeSection' => $activeSection ?? 'application',
    ])
@endpush
