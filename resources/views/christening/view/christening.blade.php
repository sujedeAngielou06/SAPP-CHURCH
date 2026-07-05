@extends('layouts.adminDashboard')

@section('title', 'Christening â€” ' . config('app.name', 'SAPP Church'))
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/christening/applicationOfChristening.css') }}?v={{ filemtime(public_path('css/christening/applicationOfChristening.css')) }}">
@endpush

@section('content')
    <div class="sappc-registry-page">
    <h1 class="sappc-page-title">
        <i class="fa-solid fa-file-lines" aria-hidden="true"></i>
        CHRISTENING
    </h1>
    <p class="sappc-page-breadcrumb mb-0">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <span class="sappc-page-breadcrumb_sep" aria-hidden="true">|</span>
        <span>Christening</span>
    </p>

    <div class="sappc-registry-toolbar" role="toolbar" aria-label="Christening record actions">
        <span class="sappc-registry-toolbar_record">RECORD</span>
        <div class="sappc-registry-toolbar_actions">
            <button type="button" class="sappc-registry-toolbar_btn sappc-registry-toolbar_btn--reload"
                id="christeningReloadBtn" title="Reload" aria-label="Reload table">
                <i class="fa-solid fa-rotate-right" aria-hidden="true"></i>
                Reload
            </button>
            <button type="button" class="sappc-registry-toolbar_btn sappc-registry-toolbar_btn--cta"
                id="christeningScheduleRequestBtn"
                data-schedule-save-url="{{ route('admin.christening.schedule-request') }}"
                data-schedule-reserved-url="{{ route('admin.christening.schedule-reserved-dates') }}" title="Schedule request"
                aria-label="Open schedule request" aria-expanded="false" aria-controls="christeningScheduleRequestModal"
                data-bs-toggle="modal" data-bs-target="#christeningScheduleRequestModal">
                <i class="fa-solid fa-calendar-days" aria-hidden="true"></i>
                Schedule Request
            </button>
            <button type="button" class="sappc-registry-toolbar_btn sappc-registry-toolbar_btn--outline"
                id="christeningCertificationBtn" title="Baptism certification" aria-label="Open baptism certification form"
                aria-expanded="false" aria-controls="christeningCertificationModal">
                <i class="fa-solid fa-certificate" aria-hidden="true"></i>
                Certification
            </button>
            <button type="button" class="sappc-registry-toolbar_btn sappc-registry-toolbar_btn--outline"
                id="christeningPaymentFeeBtn" title="Payment fee" aria-label="Open payment fee" aria-expanded="false"
                aria-controls="christeningPaymentFeeModal">
                <i class="fa-solid fa-money-bill-wave" aria-hidden="true"></i>
                Payment Fee
            </button>
            <button type="button" class="sappc-registry-toolbar_btn sappc-registry-toolbar_btn--app"
                id="christeningApplicationFormBtn" aria-expanded="false" aria-controls="christeningApplicationFormModal">
                <i class="fa-solid fa-file-lines" aria-hidden="true"></i>
                Application Form
            </button>
        </div>
    </div>

    <div class="sappcPaymentFeeModal">
        <div class="modal fade" id="christeningPaymentFeeModal" tabindex="-1"
            aria-labelledby="christeningPaymentFeeModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered sappcPaymentFeeModalDialog">
                <div class="modal-content sappcPaymentFeeModalSurface">
                    <div class="modal-header flex-wrap gap-2 border-bottom-0 pb-0 align-items-center">
                        <h2 class="modal-title h6 mb-0 text-muted fw-normal visually-hidden"
                            id="christeningPaymentFeeModalTitle">Payment fee record</h2>
                        <div class="d-flex flex-wrap gap-2 align-items-center ms-auto">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                    </div>
                    <div class="modal-body pt-0">
                        <form class="sappcPaymentFeeModalForm" id="christeningPaymentFeeForm" action="#"
                            method="post" autocomplete="off"
                            data-save-url="{{ route('admin.christening.payment-save') }}"
                            data-default-fee-rows='@json($defaultPaymentFeeRows ?? [
                                ["label" => "Arancel (For Parents if by Appointment)", "paid" => false, "date_paid" => null],
                                ["label" => "Baptismal Symbols (White Garment, Candle, etc.)", "paid" => false, "date_paid" => null],
                                ["label" => "Godparents", "paid" => false, "date_paid" => null],
                                ["label" => "Parent\'s Seminar (if by Appointment)", "paid" => false, "date_paid" => null],
                                ["label" => "Others:", "paid" => false, "date_paid" => null],
                            ])'>
                            <div class="sappcChOfficial sappcPaymentFeeModalOfficial">
                                <header class="sappcChOfficialHeader">
                                    <div class="sappcChOfficialLogo sappcChOfficialLogoLeft">
                                        <img src="{{ asset('assets/logos/DSA.jpg') }}" width="72" height="72"
                                            alt="Diocese of San Jose de Antique" class="sappcChOfficialLogoImg">
                                    </div>
                                    <div class="sappcChOfficialMasthead">
                                        <p class="sappcChOfficialMastheadLine sappcChOfficialMastheadLineStrong">
                                            The Roman Catholic Parish of St. Anthony of Padua</p>
                                        <p class="sappcChOfficialMastheadLine">Diocese of San Jose de Antique</p>
                                        <p class="sappcChOfficialMastheadLine">Barbaza, 5706, Antique, Philippines</p>
                                    </div>
                                    <div class="sappcChOfficialLogo sappcChOfficialLogoRight sappcChOfficialLogoParishSeal">
                                        <img src="{{ asset('assets/logos/SAPPC.png') }}" width="72" height="72"
                                            alt="Parish of St. Anthony of Padua, Barbaza"
                                            class="sappcChOfficialLogoImg sappcChOfficialLogoImgParishSeal">
                                    </div>
                                </header>

                                <div class="sappcPaymentFeeModalFields">
                                    <div class="sappcPaymentFeeModalField">
                                        <label class="sappcPaymentFeeModalLabel" for="chPaymentRefCode">Reference
                                            Code</label>
                                        <input type="text" class="sappcPaymentFeeModalInput" id="chPaymentRefCode"
                                            name="reference_code" value="" readonly
                                            title="System-generated; use when creating a new record">
                                    </div>
                                    <div class="sappcPaymentFeeModalField">
                                        <label class="sappcPaymentFeeModalLabel" for="chPaymentClient">Client</label>
                                        <input type="text" class="sappcPaymentFeeModalInput" id="chPaymentClient"
                                            name="client" value="">
                                    </div>
                                    <div class="sappcPaymentFeeModalField">
                                        <label class="sappcPaymentFeeModalLabel" for="chPaymentContact">Contact
                                            Number</label>
                                        <input type="text" class="sappcPaymentFeeModalInput" id="chPaymentContact"
                                            name="contact_number" value="" inputmode="tel">
                                    </div>
                                    <div class="sappcPaymentFeeModalField">
                                        <label class="sappcPaymentFeeModalLabel" for="chPaymentAddress">Address</label>
                                        <input type="text" class="sappcPaymentFeeModalInput" id="chPaymentAddress"
                                            name="address" value="">
                                    </div>
                                </div>

                                <h3 class="sappcPaymentFeeModalFeeHeading">Arancel kang bunyag</h3>

                                <div class="table-responsive sappcPaymentFeeModalTableWrap">
                                    <table class="table table-bordered mb-0 sappcPaymentFeeModalTable">
                                        <thead>
                                            <tr>
                                                <th scope="col"
                                                    class="sappcPaymentFeeModalTh sappcPaymentFeeModalThNo">No.</th>
                                                <th scope="col" class="sappcPaymentFeeModalTh">Item</th>
                                                <th scope="col" class="sappcPaymentFeeModalTh">Status Fee</th>
                                                <th scope="col" class="sappcPaymentFeeModalTh">Date of Paid</th>
                                                <th scope="col"
                                                    class="sappcPaymentFeeModalTh sappcPaymentFeeModalThAction text-center">
                                                    Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="christeningPaymentFeeItemsBody">
                                            <tr class="sappcPaymentFeeModalRow" data-fee-row>
                                                <td class="sappcPaymentFeeModalCellNo">1</td>
                                                <td>
                                                    <input type="text" class="sappcPaymentFeeModalItemInput"
                                                        name="fee_items[]" value="" aria-label="Fee item 1">
                                                </td>
                                                <td>
                                                    <span
                                                        class="sappcPaymentFeeModalStatus sappcPaymentFeeModalStatusUnpaid">Unpaid</span>
                                                </td>
                                                <td>
                                                    <span class="sappcPaymentFeeModalDatePaid" data-date-paid="">&#8212;</span>
                                                </td>
                                                <td class="text-center">
                                                    <div class="sappcPaymentFeeModalActions">
                                                        <button type="button"
                                                            class="sappcPaymentFeeModalTogglePaid">Paid</button>
                                                        <button type="button" class="sappcPaymentFeeModalBtnRemove"
                                                            aria-label="Remove row">
                                                            <i class="fa-solid fa-trash-can" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="sappcPaymentFeeModalBelowTable">
                                    <button type="button" class="sappcPaymentFeeModalBtnAddItem"
                                        id="christeningPaymentFeeAddItemBtn">
                                        <i class="fa-solid fa-plus" aria-hidden="true"></i>
                                        Add item
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer sappcPaymentFeeModalFooter sappcChristeningAppModalFooter">
                        <button type="submit" form="christeningPaymentFeeForm"
                            class="sappcChristeningAppModalBtn sappcChristeningAppModalBtnSave"
                            id="christeningPaymentFeeSaveBtn">
                            Save
                        </button>
                        <button type="button" class="sappcChristeningAppModalBtn sappcChristeningAppModalBtnCancel"
                            data-bs-dismiss="modal">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

        @include('christening.partials.scheduleRequestModal', ['generatedReferenceCode' => $generatedReferenceCode ?? ''])


        @include('christening.partials.applicationModal')

        @include('christening.partials.certificationModal', ['generatedReferenceCode' => $generatedReferenceCode ?? ''])

    @include('partials.sappcCertificatePreviewModal')
    @include('christening.partials.baptismCertificationCertificate')

    <section class="sappc-table-panel" id="christeningRecordsPanel"
        data-records-url="{{ route('admin.dashboard.records') }}" data-registry-type="christening"
        data-application-details-url="{{ route('admin.christening.application-details') }}"
        data-payment-details-url="{{ route('admin.christening.payment-details') }}"
        data-payment-save-url="{{ route('admin.christening.payment-save') }}"
        data-certification-save-url="{{ route('admin.christening.certification-form') }}"
        data-certification-details-url="{{ route('admin.christening.certification-details') }}"
        data-christening-delete-url="{{ route('admin.christening.record-delete') }}"
        data-schedule-details-url="{{ route('admin.christening.schedule-details') }}"
        data-per-page-options="{{ json_encode($perPageOptions) }}" aria-label="Christening records">
        <div class="sappc-table-toolbar">
            <div class="sappc-table-toolbar_row sappc-table-toolbar_row--primary">
                <div class="sappc-table-toolbar_entries">
                    <label class="visually-hidden" for="christeningEntries">Entries per page</label>
                    <select id="christeningEntries" class="form-select form-select-sm sappc-table-toolbar_select"
                        aria-label="Entries per page">
                        @foreach ($perPageOptions as $n)
                            <option value="{{ $n }}" @selected($records->perPage() === $n)>{{ $n }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="sappc-toolbar-date-strip" role="group" aria-label="Filter by date range">
                    <span class="sappc-toolbar-date-strip_label">From:</span>
                    <input type="date" id="christeningDateFrom" class="sappc-toolbar-date-strip_input"
                        name="date_from" value="{{ request('date_from') }}" aria-label="From date">
                    <span class="sappc-toolbar-date-strip_label">To:</span>
                    <input type="date" id="christeningDateTo" class="sappc-toolbar-date-strip_input" name="date_to"
                        value="{{ request('date_to') }}" aria-label="To date">
                    <button type="button" class="sappc-toolbar-date-strip_btn">Filter</button>
                </div>
                <div class="sappc-table-toolbar_letters" role="group"
                    aria-label="Filter by first letter of client last name">
                    <span class="visually-hidden">Filter by first letter of last name A through Z; scroll horizontally to
                        see all letters.</span>
                    <div class="sappc-letter-filter_letters">
                        @foreach ($letterOptions as $letter)
                            <button type="button"
                                class="sappc-letter-filter_btn {{ request('letter') === $letter ? 'is-active' : '' }}"
                                data-letter="{{ $letter }}">{{ $letter }}</button>
                        @endforeach
                    </div>
                </div>
                <div class="sappc-table-toolbar_search" role="search">
                    <label class="sappc-table-toolbar_search-heading" for="christeningSearch">Search:</label>
                    <div class="sappc-table-toolbar_search-wrap">
                        <input type="search" id="christeningSearch"
                            class="form-control form-control-sm sappc-table-toolbar_search-input"
                            value="{{ request('search') }}" placeholder="" autocomplete="off"
                            aria-label="Search christening records" aria-controls="christeningTableBody">
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
                <tbody id="christeningTableBody" aria-live="polite" aria-relevant="additions text"></tbody>
            </table>
        </div>

        <div class="sappc-table-footer">
            <p class="sappc-table-footer_info mb-0" id="christeningTableFooterInfo"></p>
            <nav class="sappc-pagination" id="christeningPagination" aria-label="Table pagination"></nav>
        </div>
    </section>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @include('christening.js.christeningScript', ['initialTablePayload' => $initialTablePayload]);
@endpush
