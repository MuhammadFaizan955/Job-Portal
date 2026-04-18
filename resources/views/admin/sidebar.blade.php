
<div class="card account-nav border-0 shadow mb-4 mb-lg-0">
    <div class="card-body p-0">
        <ul class="list-group list-group-flush ">
             <li class="list-group-item d-flex justify-content-between p-3">
                <a href="{{ route('admin.user') }}">Users</a>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                <a href="{{ route('job') }}"> Job</a>
            </li>

            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                <a href="{{ route('admin.job-application') }}">Application</a>
            </li>
            {{-- <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                <a href="{{ route('account.savedjobs') }}">Saved Jobs</a>
            </li> --}}
            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                <a href="">Log out</a>
            </li>
        </ul>
    </div>
</div>


