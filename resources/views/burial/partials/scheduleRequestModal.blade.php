    <div class="modal fade" id="burialScheduleRequestModal" tabindex="-1"
        aria-labelledby="burialScheduleRequestModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content sappcScheduleRequestModal">
                <div class="modal-body">
                    <div class="sappcScheduleRequestLayout">
                        <section class="sappcScheduleCalendarCard" aria-label="Calendar">
                            <div class="sappcScheduleCalendarHead sappcScheduleCalendarHead--interactive">
                                <button type="button" class="sappcScheduleCalNav" id="brCalPrev"
                                    aria-label="Previous month"><i class="fa-solid fa-chevron-left" aria-hidden="true"></i></button>
                                <span class="sappcScheduleCalendarMonthNo" id="brCalMonthNum">3</span>
                                <select class="sappcScheduleCalendarMonth" id="brCalMonth" aria-label="Month"></select>
                                <select class="sappcScheduleCalendarYear" id="brCalYear" aria-label="Year"></select>
                                <button type="button" class="sappcScheduleCalNav" id="brCalNext"
                                    aria-label="Next month"><i class="fa-solid fa-chevron-right" aria-hidden="true"></i></button>
                            </div>

                            <div class="sappcScheduleCalendarGrid" role="grid" aria-label="Select burial date"
                                id="brCalGrid">
                                <div class="sappcScheduleCalendarWeekday sunday">SUN</div>
                                <div class="sappcScheduleCalendarWeekday">MON</div>
                                <div class="sappcScheduleCalendarWeekday">TUE</div>
                                <div class="sappcScheduleCalendarWeekday">WED</div>
                                <div class="sappcScheduleCalendarWeekday">THU</div>
                                <div class="sappcScheduleCalendarWeekday">FRI</div>
                                <div class="sappcScheduleCalendarWeekday saturday">SAT</div>
                                <div id="brCalDayCells"></div>
                            </div>
                        </section>

                        <section class="sappcScheduleFormCard">
                            <header class="sappcScheduleFormHeader sappcModalHeaderPanel sappcModalHeaderPanel--centered">
                                <button type="button" class="btn-close sappcScheduleRequestModalClose" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                                <img src="{{ asset('assets/landingPage/SAPPC-transparent.png') }}" alt="Parish logo"
                                    class="sappcScheduleFormLogo">
                                <h2 id="burialScheduleRequestModalTitle">Burial Schedule Request Form</h2>
                            </header>

                            <hr class="sappcScheduleFormDivider" aria-hidden="true">

                            <form id="burialScheduleRequestForm" method="post" autocomplete="off"
                                data-schedule-save-url="{{ route('admin.burial.schedule-request') }}"
                                data-schedule-reserved-url="{{ route('admin.burial.schedule-reserved-dates') }}"
                                data-default-reference-code="{{ $generatedReferenceCode ?? '' }}">
                                @csrf
                                <div class="sappcScheduleFormField">
                                    <input type="hidden" name="burial_id" id="brScheduleBurialId" value="">
                                    <input type="hidden" name="sex" id="brScheduleSex" value="">
                                    <label for="brScheduleRefCode">Reference Code:</label>
                                    <input type="text" name="reference_code" id="brScheduleRefCode"
                                        value="{{ $generatedReferenceCode ?? '' }}"
                                        placeholder="System default; edit or pick a table row"
                                        title="Generated on page load. Click a row to use that record's code.">
                                </div>
                                <div class="sappcScheduleFormField">
                                    <label for="brScheduleContact">Contact Number:</label>
                                    <input type="text" name="contact_number" id="brScheduleContact" value="">
                                </div>
                                <div class="sappcScheduleFormField">
                                    <label for="brScheduleClient">Client:</label>
                                    <input type="text" name="client" id="brScheduleClient" value="">
                                </div>
                                <div class="sappcScheduleFormField">
                                    <label for="brScheduleAddress">Address:</label>
                                    <input type="text" name="address" id="brScheduleAddress" value="">
                                </div>
                                <div class="sappcScheduleFormField">
                                    <label for="brScheduleDate">Day / Date:</label>
                                    <div class="sappcScheduleInputIconWrap">
                                        <input type="date" name="schedule_date" id="brScheduleDate" required
                                            class="sappcScheduleNativeInput">
                                        <i class="fa-regular fa-calendar" aria-hidden="true"></i>
                                    </div>
                                </div>
                                <div class="sappcScheduleFormField">
                                    <label for="brScheduleTime24">Time:</label>
                                    <div class="sappcScheduleInputIconWrap">
                                        <input type="time" name="schedule_time" id="brScheduleTime24" required
                                            step="60" class="sappcScheduleNativeInput" value="10:00">
                                        <i class="fa-regular fa-clock" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </form>

                            <hr class="sappcScheduleFormDivider" aria-hidden="true">

                            <div class="sappcScheduleFormActions">
                                <button type="submit" form="burialScheduleRequestForm"
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
