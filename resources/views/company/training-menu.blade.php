<div class="container mw50">
    <div class="row">
        <div class="col-md-12">
            <div class="panel">
                <div>
                    <ul class="nav nav-pills nav-fill">
                        <li class="nav-item">
                            <a class="nav-link nav-link-primary has-arrow active"
                                href="{{ route('training-matrix') }}">
                                <h6><i class="fa fa-cube" aria-hidden="true"></i>
                                    Training Matrix </h6>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-primary has-arrow" href="{{ route('progress-report') }}">
                                <h6><i class="fa fa-bullhorn" aria-hidden="true"></i> Progress</h6>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-primary has-arrow" href="{{ route('upcoming-courses') }}">
                                <h6> <i class="fa fa-bullhorn" aria-hidden="true"></i> Upcoming Courses</h6>
                            </a>
                        </li>
                        @if (Auth::user()->user_type == 'company')
                            <li class="nav-item">
                                <a class="nav-link nav-link-primary has-arrow" href="{{ route('graphs') }}">
                                    <h6><i class="fa fa-cubes" aria-hidden="true"></i> Graphs</h6>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
