<!-- Modal -->
<div class="modal fade modal-lg" id="CreateScheduleModal_{{ $room->id }}" tabindex="-1" aria-labelledby="CreateScheduleLabel_{{ $room->id }}"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 text-uppercase" id="CreateScheduleLabel_{{ $room->id }}">
                    {{ $date_cur }}
                    <div class="vr mx-2"></div>
                    {{ $room->name }}
                    <div class="vr mx-2"></div>
                    @lang('lang.add_schedule')
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/admin/schedule/create" method="post">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label> @lang('lang.time')</label>
                                <div class="d-flex position-relative">
                                    @foreach ($room->latestSchedule as $latest)
                                            <?php $endTimeLatest = date('H:i', strtotime($latest->endTime) + 600) ?>
                                    @endforeach
                                    <input class="form-control" id="time" type="time" name="startTime"
                                           @if($room->schedules->count() == 0)
                                               min="08:00"
                                           @else
                                               min="{{$endTimeLatest}}"
                                           @endif
                                           max="22:00"
                                           value="@if($room->schedules->count() == 0) {{ date("H:i") }} @else {{ $endTimeLatest  }}  @endif"
                                           aria-label="time">
                                    <span class="input-group-text"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label"> @lang('lang.movies')</label>
                                <select class="form-select" id="address" name="movie" aria-label="">
                                    @foreach($movies as $movie)
                                        <option value="{{ $movie->id }}">{{ $movie->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label> @lang('lang.audio')</label>
                                <select id="city_create" class="form-select" name="audio" aria-label="audio">
                                    @foreach($audios as $audio)
                                        <option value="{{ $audio->id }}">{{ $audio->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label> @lang('lang.subtitle')</label>
                                <select class="form-select" name="subtitle" aria-label="subtitle">
                                    @foreach($subtitles as $sub)
                                        <option value="{{ $sub->id }}">{{ $sub->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="theater" value="{{ $theater_cur->id }}">
                        <input type="hidden" name="room" value="{{ $room->id }}">
                        <input type="hidden" name="date" value="{{ $date_cur }}">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> @lang('lang.close')</button>
                    <button type="submit" class="btn btn-primary"> @lang('lang.save')</button>
                </div>
            </form>
        </div>
    </div>
</div>
