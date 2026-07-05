    <div class="modal fade" id="confirmationScheduleRequestModal" tabindex="-1"
        aria-labelledby="confirmationScheduleRequestModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content sappcScheduleRequestModal">
                <div class="modal-body">
                    <div class="sappcScheduleRequestLayout">
                        <section class="sappcScheduleCalendarCard" aria-label="Calendar">
                            <div class="sappcScheduleCalendarHead sappcScheduleCalendarHead--interactive">
                                <button type="button" class="sappcScheduleCalNav" id="cnCalPrev"
                                    aria-label="Previous month"><i class="fa-solid fa-chevron-left" aria-hidden="true"></i></button>
                                <span class="sappcScheduleCalendarMonthNo" id="cnCalMonthNum">3</span>
                                <select class="sappcScheduleCalendarMonth" id="cnCalMonth" aria-label="Month"></select>
                                <select class="sappcScheduleCalendarYear" id="cnCalYear" aria-label="Year"></select>
                                <button type="button" class="sappcScheduleCalNav" id="cnCalNext"
                                    aria-label="Next month"><i class="fa-solid fa-chevron-right" aria-hidden="true"></i></button>
                            </div>

                            <div class="sappcScheduleCalendarGrid" role="grid" aria-label="Select confirmation date"
                                id="cnCalGrid">
                                <div class="sappcScheduleCalendarWeekday sunday">SUN</div>
                                <div class="sappcScheduleCalendarWeekday">MON</div>
                                <div class="sappcScheduleCalendarWeekday">TUE</div>
                                <div class="sappcScheduleCalendarWeekday">WED</div>
                                <div class="sappcScheduleCalendarWeekday">THU</div>
                                <div class="sappcScheduleCalendarWeekday">FRI</div>
                                <div class="sappcScheduleCalendarWeekday saturday">SAT</div>
                                <div id="cnCalDayCells"></div>
                            </div>
                        </section>

                        <section class="sappcScheduleFormCard">
                            <header class="sappcScheduleFormHeader sappcModalHeaderPanel sappcModalHeaderPanel--centered">
                                <button type="button" class="btn-close sappcScheduleRequestModalClose" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                                <img src="{{ asset('assets/landingPage/SAPPC-transparent.png') }}" alt="Parish logo"
                                    class="sappcScheduleFormLogo">
                                <h2 id="confirmationScheduleRequestModalTitle">Confirmation Schedule Request Form</h2>
                            </header>

                            <hr class="sappcScheduleFormDivider" aria-hidden="true">

                            <form id="confirmationScheduleRequestForm" method="post" autocomplete="off"
                                data-schedule-save-url="{{ route('admin.confirmation.schedule-request') }}"
                                data-schedule-reserved-url="{{ route('admin.confirmation.schedule-reserved-dates') }}"
                                data-default-reference-code="{{ $generatedReferenceCode ?? '' }}">
                                @csrf
                                <div class="sappcScheduleFormField">
                                    <input type="hidden" name="confirmation_id" id="cnScheduleConfirmationId" value="">
                                    <input type="hidden" name="sex" id="cnScheduleSex" value="">
                                    <label for="cnScheduleRefCode">Reference Code:</label>
                                    <input type="text" name="reference_code" id="cnScheduleRefCode"
                                        value="{{ $generatedReferenceCode ?? '' }}"
                                        placeholder="System default; edit or pick a table row"
                                        title="Generated on page load. Click a row to use that record's code.">
                                </div>
                                <div class="sappcScheduleFormField">
                                    <label for="cnScheduleContact">Contact Number:</label>
                                    <input type="text" name="contact_number" id="cnScheduleContact" value="">
                                </div>
                                <div class="sappcScheduleFormField">
                                    <label for="cnScheduleClient">Client:</label>
                                    <input type="text" name="client" id="cnScheduleClient" value="">
                                </div>
                                <div class="sappcScheduleFormField">
                                    <label for="cnScheduleAddress">Address:</label>
                                    <input type="text" name="address" id="cnScheduleAddress" value="">
                                </div>
                                <div class="sappcScheduleFormField">
                                    <label for="cnScheduleDate">Day / Date:</label>
                                    <div class="sappcScheduleInputIconWrap">
                                        <input type="date" name="schedule_date" id="cnScheduleDate" required
                                            class="sappcScheduleNativeInput">
                                        <i class="fa-regular fa-calendar" aria-hidden="true"></i>
                                    </div>
                                </div>
                                <div class="sappcScheduleFormField">
                                    <label for="cnScheduleTime24">Time:</label>
                                    <div class="sappcScheduleInputIconWrap">
                                        <input type="time" name="schedule_time" id="cnScheduleTime24" required
                                            step="60" class="sappcScheduleNativeInput" value="10:00">
                                        <i class="fa-regular fa-clock" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </form>

                            <hr class="sappcScheduleFormDivider" aria-hidden="true">

                            <div class="sappcScheduleFormActions">
                                <button type="submit" form="confirmationScheduleRequestForm"
                                    class="sappcScheduleActionBtn is-reserve">Reserved Schedule</button>
                                <button type="button" class="sappcScheduleActionBtn is-cancel"
                                    data-bs-dismiss="modal">Cancel</button>
                            </div>

                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
