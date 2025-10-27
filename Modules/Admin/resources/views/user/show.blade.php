@extends('admin::layouts.master')

@section('content')
<style>
.card-body label {
    font-size: 14px;
    font-weight: 600;
    color: #555;
}
.card-body div {
    font-size: 15px;
    color: #222;
}
.switch {
    position: relative;
    display: inline-block;
    width: 50px;
    height: 26px;
}
.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}
.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: .4s;
    border-radius: 26px;
}
.slider:before {
    position: absolute;
    content: "";
    height: 20px;
    width: 20px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    transition: .4s;
    border-radius: 50%;
}
input:checked + .slider {
    background-color: #28a745;
}
input:checked + .slider:before {
    transform: translateX(24px);
}


.back-btn {
    background-color: #FFD0E7;
    color: #333;
    border: none;
    padding: 8px 18px;
    font-size: 14px;
    font-weight: 600;
    border-radius: 25px;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
}
.back-btn:hover {
    background-color: #f7bcd8;
    color: #000;
    text-decoration: none;
}
</style>

<div class="content-wrapper">
    <!-- Page Header -->
    <section class="content-header">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <div>
                <h1>User Profile</h1>
            </div>
            <div>
           
                <a href="{{ url()->previous() }}" class="back-btn">← Back</a>
            </div>
        </div>
    </section>


    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">

            <!-- Section 1: User Account Details -->
            <div class="card card-primary shadow-sm rounded-lg mb-4">
                <div class="card-header">
                    <h3 class="card-title">User  Details</h3>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">

                        <!-- Profile Image -->
                        <div class="col-md-3 text-center mb-4 mb-md-0">
                            <img src="{{ $user->profile_image ? asset($user->profile_image) : asset('uploads/blankImage/blank.jpg') }}"
                                class="img-fluid rounded-circle shadow"
                                style="width: 165px; height:165px; object-fit: cover;"
                                alt="Profile Image">
                            <h5 class="mt-3">{{ $user->profile_name }}</h5>
                        </div>

                        <!-- Account Info -->
                        <div class="col-md-9">
                            <div class="row">
                                  <div class="col-md-6 mb-3">
                                    <label>First Name</label>
                                    <div>{{ $user->first_name ?? '-' }}</div>
                                </div>
                                
                            <div class="col-md-6 mb-3">
                                <label>Last Name</label>
                                <div>{{ $user->last_name ?? '-' }}</div>
                            </div>
                                
                            <div class="col-md-6 mb-3">
                                <label>Gender</label>
                                <div>{{ ucfirst($user->gender) ?? '-' }}</div>
                            </div>
    
                            <div class="col-md-6 mb-3">
                                <label>Date of Birth</label>
                                <div>{{ $user->dob ?? '-' }}</div>
                            </div>
                                    
                                <div class="col-md-6 mb-3">
                                    <label>Email</label>
                                    <div>{{ $user->email ?? '-' }}</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Mobile Number</label>
                                    <div>{{ $user->mobile_no ?? '-' }}</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Country Code</label>
                                    <div>{{ $user->country_code ?? '-' }}</div>
                                </div>

                                <!-- Admin Toggle -->
                                <div class="col-md-6 mb-3">
                                    <label>Admin Status</label>
                                    <div>
                                        <label class="switch">
                                            <input type="checkbox" class="admin-toggle"
                                                data-id="{{ $user->id }}"
                                                {{ $user->admin_status ? 'checked' : '' }}>
                                            <span class="slider"></span>
                                        </label>
                                        <span id="admin-status-text-{{ $user->id }}" class="ml-2">
                                            {{ $user->admin_status ? 'Active' : 'Inactive' }}
                                        </span>
                                    </div>
                                </div>
                                
                                
                                  
                                <!-- Profile Approval -->
                                <div class="col-md-6 mb-3">
                                    <label>Profile Approval Status</label>
                                    <div>
                                        <label class="switch">
                                            <input type="checkbox" class="profile-approval-toggle"
                                                   data-id="{{ $user->id }}"
                                                   {{ $user->profile_approval ? 'checked' : '' }}>
                                            <span class="slider"></span>
                                        </label>
                                        <span id="profile-approval-text-{{ $user->id }}" class="ml-2">
                                            {{ $user->profile_approval ? 'Active' : 'Inactive' }}
                                        </span>
                                    </div>
                                </div>

                                
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>

            <!-- Section 2: Personal Details -->
            <div class="card card-primary shadow-sm rounded-lg">
                <div class="card-header">
                    <h3 class="card-title">Personal Details</h3>
                </div>
                <div class="card-body">
                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label>Height</label>
                            <div>{{ $user->height ?? '-' }}</div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Weight</label>
                            <div>{{ $user->weight ?? '-' }}</div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Body Type</label>
                            <div>{{ ucfirst($user->body_type) ?? '-' }}</div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Hair Color</label>
                            <div>{{ $user->hair_color ?? '-' }}</div>
                        </div>


                         <div class="col-md-6 mb-3">
                            <label>Eye Color</label>
                            <div>{{ $user->eye_color ?? '-' }}</div>
                        </div> 
                        
                        <div class="col-md-6 mb-3">
                            <label>Nationality</label>
                            <div>{{ $user->nationality ?? '-' }}</div>
                        </div>  
                        
                        
                        <div class="col-md-6 mb-3">
                            <label>Region</label>
                            <div>{{ $user->region ?? '-' }}</div>
                        </div>


                        <div class="col-md-6 mb-3">
                            <label>City</label>
                            <div>{{ $user->city ?? '-' }}</div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Zodiac Sign</label>
                            <div>{{ $user->zodiac_sign ?? '-' }}</div>
                        </div>


                         <div class="col-md-6 mb-3">
                            <label>Sexual Orientation</label>
                            <div>{{ $user->sexual_orientation ?? '-' }}</div>
                        </div>


                        <!-- Add more personal fields if needed -->
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).on('change', '.admin-toggle', function () {
        let userId = $(this).data('id');
        let isAdmin = $(this).is(':checked') ? 1 : 0;

        $.ajax({
            url: "{{ route('admin.update') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                user_id: userId,
                admin_status: isAdmin
            },
            success: function (response) {
                if (response.status) {
                    let statusText = isAdmin ? 'Active' : 'Inactive';
                    $('#admin-status-text-' + userId).text(statusText);

                    Swal.fire({
                        icon: 'success',
                        title: 'Updated!',
                        text: 'Admin status changed to ' + statusText,
                        timer: 1500,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!'
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Failed to update admin status.'
                });
            }
        });
    });
</script>







<script>
    $(document).on('change', '.profile-approval-toggle', function () {
        let userId = $(this).data('id');
        let isApproved = $(this).is(':checked') ? 1 : 0;

        $.ajax({
            url: "{{ route('profileApproval.update') }}", 
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                user_id: userId,
                profile_approval: isApproved
            },
            success: function (response) {
                if (response.status) {
                    let statusText = isApproved ? 'Active' : 'Inactive';
                    $('#profile-approval-text-' + userId).text(statusText);

                    Swal.fire({
                        icon: 'success',
                        title: 'Updated!',
                        text: 'Profile approval changed to ' + statusText,
                        timer: 1500,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: response.message || 'Something went wrong!'
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Failed to update profile approval.'
                });
            }
        });
    });
</script>




@endsection
