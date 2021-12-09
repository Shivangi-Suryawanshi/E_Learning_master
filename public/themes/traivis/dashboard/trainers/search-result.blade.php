<div class="row">
    <div class="col-md-6">
        <div class="dashboard-card mb-12 d-flex border p-3 bg-white">
            <div class="card-icon mr-2 mr10">
                @if ($user->profile_pic)

                    <img src="{{ asset('assets/profile_pics/' . $user->profile_pic) }}" width="100" height="100"
                        class="avatar rounded-circle" alt="Avatar image">

                @else
                    <img src="http://train.ca/themes/traivis/assets/website/img/user.png" width="100" height="100"
                        class="avatar rounded-circle" alt="Avatar image">
                @endif
            </div>

            <div class="card-info">
                <div class="text-value">
                    <h5>{{ ucwords($user->name) }}</h5>
                </div>
                <div><b>Email : {{ $user->email }}</b></div>
                @if ($user->phone)
                    <div><b>Phone : {{ $user->phone }} </b></div>
                @endif
                @if ($user->address)
                    <div><b>Address : {{ $user->address }}</b></div>
                @endif
                {{-- <div><b>Training center:</b></div> --}}
                {{-- {{dd($user->trainingCenterTRainer($user->id))}} --}}
                @if ($user->trainingCenterTrainer($user->id) == false && $user->trainingCenterTrainerRequested($user->id) == false)

                    <a role="button" data-id="{{ $user->id }}"
                        class="btn btn-sm btn-primary btn-block mt10 request-trainer ">Request</a>

                @elseif($user->trainingCenterTrainerRequested($user->id) == true)
                    <a class="btn btn-sm btn-success btn-block mt10 request-success">Requested</a>

                @endif
                <a style="display: none;" class="btn btn-sm btn-success btn-block mt10 request-success">Requested</a>

            </div>
        </div>
    </div>
</div>
