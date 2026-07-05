    <div class="modal fade" id="christeningScheduleRequestModal" tabindex="-1"
        aria-labelledby="christeningScheduleRequestModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content sappcScheduleRequestModal">
                <div class="modal-body">
                    <div class="sappcScheduleRequestLayout">
                        <section class="sappcScheduleCalendarCard" aria-label="Calendar">
                            <div class="sappcScheduleCalendarHead sappcScheduleCalendarHead--interactive">
                                <button type="button" class="sappcScheduleCalNav" id="chCalPrev"
                                    aria-label="Previous month"><i class="fa-solid fa-chevron-left" aria-hidden="true"></i></button>
                                <span class="sappcScheduleCalendarMonthNo" id="chCalMonthNum">3</span>
                                <select class="sappcScheduleCalendarMonth" id="chCalMonth" aria-label="Month"></select>
                                <select class="sappcScheduleCalendarYear" id="chCalYear" aria-label="Year"></select>
                                <button type="button" class="sappcScheduleCalNav" id="chCalNext"
                                    aria-label="Next month"><i class="fa-solid fa-chevron-right" aria-hidden="true"></i></button>
                            </div>

                            <div class="sappcScheduleCalendarGrid" role="grid" aria-label="Select baptism date"
                                id="chCalGrid">
                                <div class="sappcScheduleCalendarWeekday sunday">SUN</div>
                                <div class="sappcScheduleCalendarWeekday">MON</div>
                                <div class="sappcScheduleCalendarWeekday">TUE</div>
                                <div class="sappcScheduleCalendarWeekday">WED</div>
                                <div class="sappcScheduleCalendarWeekday">THU</div>
                                <div class="sappcScheduleCalendarWeekday">FRI</div>
                                <div class="sappcScheduleCalendarWeekday saturday">SAT</div>
                                <div id="chCalDayCells"></div>
                            </div>
                        </section>

                        <section class="sappcScheduleFormCard">
                            <header class="sappcScheduleFormHeader sappcModalHeaderPanel sappcModalHeaderPanel--centered">
                                <button type="button" class="btn-close sappcScheduleRequestModalClose" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                                <img src="{{ asset('assets/landingPage/SAPPC-transparent.png') }}" alt="Parish logo"
                                    class="sappcScheduleFormLogo">
                                <h2 id="christeningScheduleRequestModalTitle">Baptism Schedule Request Form</h2>
                            </header>

                            <hr class="sappcScheduleFormDivider" aria-hidden="true">

                            <form id="christeningScheduleRequestForm" method="post" autocomplete="off"
                                data-schedule-save-url="{{ route('admin.christening.schedule-request') }}"
                                data-schedule-reserved-url="{{ route('admin.christening.schedule-reserved-dates') }}"
                                data-default-reference-code="{{ $generatedReferenceCode ?? '' }}">
                                @csrf
                                <div class="sappcScheduleFormField">
                                    <input type="hidden" name="christening_id" id="chScheduleChristeningId" value="">
                                    <input type="hidden" name="sex" id="chScheduleSex" value="">
                                    <label for="chScheduleRefCode">Reference Code:</label>
                                    <input type="text" name="reference_code" id="chScheduleRefCode"
                                        value="{{ $generatedReferenceCode ?? '' }}"
                                        placeholder="System default; edit or pick a table row"
                                        title="Generated on page load. Click a row to use that record's code.">
                                </div>
                                <div class="sappcScheduleFormField">
                                    <label for="chScheduleContact">Contact Number:</label>
                                    <input type="text" name="contact_number" id="chScheduleContact" value="">
                                </div>
                                <div class="sappcScheduleFormField">
                                    <label for="chScheduleClient">Client:</label>
                                    <input type="text" name="client" id="chScheduleClient" value="">
                                </div>
                                <div class="sappcScheduleFormField">
                                    <label for="chScheduleAddress">Address:</label>
                                    <input type="text" name="address" id="chScheduleAddress" value="">
                                </div>
                                <div class="sappcScheduleFormField">
                                    <label for="chScheduleDate">Day / Date:</label>
                                    <div class="sappcScheduleInputIconWrap">
                                        <input type="date" name="schedule_date" id="chScheduleDate" required
                                            class="sappcScheduleNativeInput">
                                        <i class="fa-regular fa-calendar" aria-hidden="true"></i>
                                    </div>
                                </div>
                                <div class="sappcScheduleFormField">
                                    <label for="chScheduleTime24">Time:</label>
                                    <div class="sappcScheduleInputIconWrap">
                                        <input type="time" name="schedule_time" id="chScheduleTime24" required
                                            step="60" class="sappcScheduleNativeInput" value="10:00">
                                        <i class="fa-regular fa-clock" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </form>

                            <hr class="sappcScheduleFormDivider" aria-hidden="true">

                            <div class="sappcScheduleFormActions">
                                <button type="submit" form="christeningScheduleRequestForm"
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
