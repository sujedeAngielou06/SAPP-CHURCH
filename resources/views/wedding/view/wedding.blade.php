@extends('layouts.adminDashboard')

@section('title', 'Wedding — ' . config('app.name', 'SAPP Church'))

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/christening/applicationOfChristening.css') }}">
    <link rel="stylesheet" href="{{ asset('css/wedding/marriageApplicationKasal.css') }}">
@endpush

@section('content')
    <div class="sappc-registry-page">
    <h1 class="sappc-page-title">
        <i class="fa-solid fa-file-lines" aria-hidden="true"></i>
        WEDDING
    </h1>
    <p class="sappc-page-breadcrumb mb-0">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <span class="sappc-page-breadcrumb_sep" aria-hidden="true">|</span>
        <span>Wedding</span>
    </p>

    <div class="sappc-registry-toolbar" role="toolbar" aria-label="Wedding record actions">
        <span class="sappc-registry-toolbar_record">RECORD</span>
        <div class="sappc-registry-toolbar_actions">
            <button type="button" class="sappc-registry-toolbar_btn sappc-registry-toolbar_btn--reload" id="weddingReloadBtn" title="Reload" aria-label="Reload table">
                <i class="fa-solid fa-rotate-right" aria-hidden="true"></i>
                Reload
            </button>
            <button type="button" class="sappc-registry-toolbar_btn sappc-registry-toolbar_btn--cta"
                id="weddingScheduleRequestBtn"
                data-schedule-save-url="{{ route('admin.wedding.schedule-request') }}"
                data-schedule-reserved-url="{{ route('admin.wedding.schedule-reserved-dates') }}" title="Schedule request"
                aria-label="Open schedule request" aria-expanded="false" aria-controls="weddingScheduleRequestModal"
                data-bs-toggle="modal" data-bs-target="#weddingScheduleRequestModal">
                <i class="fa-solid fa-calendar-days" aria-hidden="true"></i>
                Schedule Request
            </button>
            <button type="button" class="sappc-registry-toolbar_btn sappc-registry-toolbar_btn--outline"
                id="weddingCertificationBtn" title="Wedding certification"
                aria-label="Open wedding certification form" aria-expanded="false"
                aria-controls="weddingCertificationModal">
                <i class="fa-solid fa-certificate" aria-hidden="true"></i>
                Certification
            </button>
            <button type="button" class="sappc-registry-toolbar_btn sappc-registry-toolbar_btn--outline"
                id="weddingPaymentFeeBtn" title="Payment fee" aria-label="Open payment fee" aria-expanded="false"
                aria-controls="weddingPaymentFeeModal">
                <i class="fa-solid fa-money-bill-wave" aria-hidden="true"></i>
                Payment Fee
            </button>
            <button type="button" class="sappc-registry-toolbar_btn sappc-registry-toolbar_btn--app"
                id="weddingApplicationFormBtn" title="Marriage application form" aria-label="Open marriage application form"
                aria-expanded="false" aria-controls="weddingMarriageApplicationModal"
                data-marriage-application-details-url="{{ route('admin.wedding.marriage-application-details') }}"
                data-marriage-application-save-url="{{ route('admin.wedding.marriage-application-save') }}">
                <i class="fa-solid fa-file-lines" aria-hidden="true"></i>
                Application Form
            </button>
        </div>
    </div>

    <div class="sappcPaymentFeeModal">
        <div class="modal fade" id="weddingPaymentFeeModal" tabindex="-1"
            aria-labelledby="weddingPaymentFeeModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered sappcPaymentFeeModalDialog">
                <div class="modal-content sappcPaymentFeeModalSurface">
                    <div class="modal-header flex-wrap gap-2 border-bottom-0 pb-0 align-items-center">
                        <h2 class="modal-title h6 mb-0 text-muted fw-normal visually-hidden"
                            id="weddingPaymentFeeModalTitle">Payment fee record</h2>
                        <div class="d-flex flex-wrap gap-2 align-items-center ms-auto">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                    </div>
                    <div class="modal-body pt-0">
                        <form class="sappcPaymentFeeModalForm" id="weddingPaymentFeeForm" action="#"
                            method="post" autocomplete="off"
                            data-save-url="{{ route('admin.wedding.payment-save') }}"
                            data-default-fee-rows='@json($defaultPaymentFeeRows ?? [
                                ["label" => "Church / venue (Arancel)", "paid" => false, "date_paid" => null],
                                ["label" => "Marriage license / permit", "paid" => false, "date_paid" => null],
                                ["label" => "Music / choir", "paid" => false, "date_paid" => null],
                                ["label" => "Flowers / decorations", "paid" => false, "date_paid" => null],
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
                                        <label class="sappcPaymentFeeModalLabel" for="wdPaymentRefCode">Reference
                                            Code</label>
                                        <input type="text" class="sappcPaymentFeeModalInput" id="wdPaymentRefCode"
                                            name="reference_code" value="" readonly
                                            title="System-generated; use when creating a new record">
                                    </div>
                                    <div class="sappcPaymentFeeModalField">
                                        <label class="sappcPaymentFeeModalLabel" for="wdPaymentClient">Client</label>
                                        <input type="text" class="sappcPaymentFeeModalInput" id="wdPaymentClient"
                                            name="client" value="">
                                    </div>
                                    <div class="sappcPaymentFeeModalField">
                                        <label class="sappcPaymentFeeModalLabel" for="wdPaymentContact">Contact
                                            Number</label>
                                        <input type="text" class="sappcPaymentFeeModalInput" id="wdPaymentContact"
                                            name="contact_number" value="" inputmode="tel">
                                    </div>
                                    <div class="sappcPaymentFeeModalField">
                                        <label class="sappcPaymentFeeModalLabel" for="wdPaymentAddress">Address</label>
                                        <input type="text" class="sappcPaymentFeeModalInput" id="wdPaymentAddress"
                                            name="address" value="">
                                    </div>
                                </div>

                                <h3 class="sappcPaymentFeeModalFeeHeading">Arancel kang kasal</h3>

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
                                        <tbody id="weddingPaymentFeeItemsBody">
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
                                        id="weddingPaymentFeeAddItemBtn">
                                        <i class="fa-solid fa-plus" aria-hidden="true"></i>
                                        Add item
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer sappcPaymentFeeModalFooter sappcChristeningAppModalFooter">
                        <button type="submit" form="weddingPaymentFeeForm"
                            class="sappcChristeningAppModalBtn sappcChristeningAppModalBtnSave"
                            id="weddingPaymentFeeSaveBtn">
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

    @include('wedding.partials.marriageApplicationModal')

    <section
        class="sappc-table-panel"
        id="weddingRecordsPanel"
        data-records-url="{{ route('admin.dashboard.records') }}"
        data-registry-type="wedding"
        data-payment-details-url="{{ route('admin.wedding.payment-details') }}"
        data-payment-save-url="{{ route('admin.wedding.payment-save') }}"
        data-marriage-application-details-url="{{ route('admin.wedding.marriage-application-details') }}"
        data-marriage-application-save-url="{{ route('admin.wedding.marriage-application-save') }}"
        data-certification-save-url="{{ route('admin.wedding.certification-form') }}"
        data-certification-details-url="{{ route('admin.wedding.certification-details') }}"
        data-wedding-delete-url="{{ route('admin.wedding.record-delete') }}"
        data-schedule-details-url="{{ route('admin.wedding.schedule-details') }}"
        aria-label="Wedding records"
    >
        <div class="sappc-table-toolbar">
            <div class="sappc-table-toolbar_row sappc-table-toolbar_row--primary">
                <div class="sappc-table-toolbar_entries">
                    <label class="visually-hidden" for="weddingEntries">Entries per page</label>
                    <select id="weddingEntries" class="form-select form-select-sm sappc-table-toolbar_select" aria-label="Entries per page">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                <div class="sappc-toolbar-date-strip" role="group" aria-label="Filter by date range">
                    <span class="sappc-toolbar-date-strip_label">From:</span>
                    <input type="date" id="weddingDateFrom" class="sappc-toolbar-date-strip_input" name="date_from" aria-label="From date">
                    <span class="sappc-toolbar-date-strip_label">To:</span>
                    <input type="date" id="weddingDateTo" class="sappc-toolbar-date-strip_input" name="date_to" aria-label="To date">
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
                    <label class="sappc-table-toolbar_search-heading" for="weddingSearch">Search:</label>
                    <div class="sappc-table-toolbar_search-wrap">
                        <input type="search" id="weddingSearch" class="form-control form-control-sm sappc-table-toolbar_search-input" placeholder="" autocomplete="off" aria-label="Search wedding records" aria-controls="weddingTableBody">
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
                <tbody id="weddingTableBody" aria-live="polite" aria-relevant="additions text">
                    <tr class="sappc-table-loading">
                        <td colspan="7" class="text-center text-muted py-4">Loading...</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="sappc-table-footer">
            <p class="sappc-table-footer_info mb-0" id="weddingTableFooterInfo">Showing 0 entries</p>
            <nav class="sappc-pagination" id="weddingPagination" aria-label="Table pagination"></nav>
        </div>
    </section>

        @include('wedding.partials.scheduleRequestModal', ['generatedReferenceCode' => $generatedReferenceCode ?? ''])

        @include('wedding.partials.certificationModal', ['generatedReferenceCode' => $generatedReferenceCode ?? ''])

    @include('wedding.partials.marriageCertificatePrintable')
    @include('partials.sappcCertificatePreviewModal')
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @include('wedding.js.weddingScript');
@endpush
