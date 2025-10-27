@section('css')
<style>
.switch {
  position: relative;
  display: inline-block;
  width: 40px;   /* smaller width */
  height: 22px;  /* smaller height */
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
  background-color: #dc3545; /* InActive - red */
  transition: .4s;
  border-radius: 22px;
}
.slider:before {
  position: absolute;
  content: "";
  height: 16px;
  width: 16px;
  left: 3px;
  bottom: 3px;
  background-color: white;
  transition: .4s;
  border-radius: 50%;
}
input:checked + .slider {
  background-color: #28a745; /* Active - green */
}
input:checked + .slider:before {
  transform: translateX(18px);
}
</style>
@endsection

@extends('admin::layouts.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                 <div class="col-lg-12">
          
                	<div class="card">
                		<div class="card-header d-flex justify-content-between align-items-center">
                			<h3 class="card-title">Users</h3>
                        </div>
					   				 <div class="card-body">
					   				 	<table id="users" class="table table-striped" style="width:100%">
					   				 	<thead>
    							            <tr>
    							                <th>S.No</th>
                                                <th>Profile Picture</th>
    							                <th>Name</th>
    							                <th>Email</th>
                                                <th>Mobile Number</th>
                                                <th>Action</th>
    							            </tr>
							        	</thead>
							        	
							         @foreach($user as $index => $users)
							       		<tbody>
                                         <tr>
                                            <td>{{$index + 1 }}</td>
                                            
                                            
                                            <td>
                                                @if ($users->profile_image)
                                                   <img src="{{ asset($users->profile_image) }}" 
                                                     width="60" 
                                                   
                                                     style="border-radius: 60%; object-fit: cover; height: 70px; width: 70px;">
                                                @else
                                                    <img src="{{ asset('uploads/blankImage/blank.jpg' ) }}" width="60" alt="blank.jpg">
                                                 @endif
                                              </td>
                                            
                                            
                                            <td>{{$users->first_name}}</td>
                                            <td>{{$users->email}}</td>
                                                
                                            <td>{{$users->mobile_no}} </td>
                                                
                                   
                                           
                                             <td class="table_action text-center" style="white-space: nowrap;">
                                                
                                                    <a href="{{route('admin.viewuser',$users->id)}}" class="edit-btn" style="margin-left: 10px; color: green;">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                
                                                <!--delete-->
                                                                                           
                                                <a href="javascript:void(0)" 
                                                   class="delete-btn" 
                                                   data-id="{{ $users->id }}" 
                                                   style="margin-left: 10px; color: red;">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                                    
                                                    
                                            </td>

                                       </tr>
							        </tbody>
							      @endforeach
							        
							        
							    </table>    
					   		</div>
					  	</div>
                 </div>
            </div>
        </div>
    </section>
</div>
	

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
$(document).on('click', '.delete-btn', function () {
    let userId = $(this).data('id');

    Swal.fire({
        title: 'Are you sure?',
        text: "This will permanently delete the user!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
             url: "{{ route('destroy', ['id' => ':id']) }}".replace(':id', userId),
                type: "DELETE",
                data: {
                    id: userId,                  // ✅ id payload में जाएगी
                    _token: "{{ csrf_token() }}" // ✅ CSRF token
                },
                success: function (response) {
                    if (response.status) {
                        Swal.fire('Deleted!', response.message, 'success');
                        $(`.delete-btn[data-id="${userId}"]`).closest('tr').fadeOut();
                    } else {
                        Swal.fire('Error!', response.message, 'error');
                    }
                },
                error: function () {
                    Swal.fire('Error!', 'Something went wrong.', 'error');
                }
            });
        }
    });
});
</script>



 @endsection	



