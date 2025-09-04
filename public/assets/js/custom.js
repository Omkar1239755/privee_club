$(document).ready(function(){
    // Check admin password is correct or not
    $("#current_pwd").keyup(function(){
        var current_pwd = $("#current_pwd").val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:BaseadminUrl + '/' +'check_current_password',
            data:{current_pwd:current_pwd},
            success:function(resp){
                if(resp == "false"){
                    $("#vefiryCurrentPwd").html("Old Password is Incorrect !").css("color", "red");
                }else if(resp == "true"){
                    $("#vefiryCurrentPwd").html("Old Password is correct !").css("color", "blue");
                }
            },error:function(){
                alert('Error');
            }
        })
    });
});

// update company Activity status
$(document).on('click', '.updateCompanyActivityStatus', function(){
    var status = $(this).children('i').attr('status');
    var activity_id = $(this).attr('activity_id');
    // alert(activity_id);
    $.ajax({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type : 'post',
        url : 'update-company-activity-status',
        data : {status:status,activity_id:activity_id},
        success:function(resp){
            if(resp['status'] == 0){
                $("#activity-"+activity_id).html("<i class='fas fa-toggle-off' style='color:grey' status='Inactive'></i>");
            }else if(resp['status'] ==1){
                $("#activity-"+activity_id).html("<i class='fas fa-toggle-on' style='color:#3f6ed3' status='Active'></i>");
            }
        },error:function(){
            alert('Error');
        }
    });
});

// update Category status
$(document).on('click', '.updateCategoryStatus', function(){
    var status = $(this).children('i').attr('status');
    var category_id = $(this).attr('category_id');
    // alert(category_id);
    $.ajax({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: 'update-category-status',
        type : 'post',
        data : {status:status,category_id:category_id},
        success:function(resp){
            if(resp['status'] == 0){
                $("#category-"+category_id).html("<i class='fas fa-toggle-off' style='color:grey' status='Inactive'></i>");
            }else if(resp['status'] ==1){
                $("#category-"+category_id).html("<i class='fas fa-toggle-on' style='color:#3f6ed3' status='Active'></i>");
            }
        },error:function(){
            alert('Error');
        }
    });
});

// update SubCategory status
$(document).on('click', '.updateSubCategoryStatus', function(){
    var status = $(this).children('i').attr('status');
    var subcategory_id = $(this).attr('subcategory_id');
    // alert(subcategory_id);
    $.ajax({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type : 'post',
        url : 'update-subcategory-status',
        data : {status:status,subcategory_id:subcategory_id},
        success:function(resp){
            if(resp['status'] == 0){
                $("#subcategory-"+subcategory_id).html("<i class='fas fa-toggle-off' style='color:grey' status='Inactive'></i>");
            }else if(resp['status'] ==1){
                $("#subcategory-"+subcategory_id).html("<i class='fas fa-toggle-on' style='color:#3f6ed3' status='Active'></i>");
            }
        },error:function(){
            alert('Error');
        }
    });
});

// update type of business status
$(document).on('click', '.updateTOBStatus', function(){
    var status = $(this).children('i').attr('status');
    var tob_id = $(this).attr('tob_id');
    
    $.ajax({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type : 'POST',
        url : 'update-tob-status',
        data : {status:status,tob_id:tob_id},
        success:function(resp){
            if(resp['status'] == 0){
                $("#tob-"+tob_id).html("<i class='fas fa-toggle-off' style='color:grey' status='Inactive'></i>");
            }else if(resp['status'] ==1){
                $("#tob-"+tob_id).html("<i class='fas fa-toggle-on' style='color:#3f6ed3' status='Active'></i>");
            }
        },error:function(){
            alert('Error');
        }
    });
});


$('#validation-alert').fadeOut(4000);
// $(document).ready(function(){
// });

// alert message
/* --- Common Delete Function for all the modules */
$(document).on('click', ".confirmDelete", function(){
   var record = $(this).attr('record');
   var record_id = $(this).attr('record_id');
//    alert(record_id);
   Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
    if (result.isConfirmed) {
        Swal.fire(
        'Deleted!',
        'Your file has been deleted.',
        'success'
        )
        
        var root = $('#rootUrl').val();
        window.location.href = root + "/admin/"+record+"/"+record_id;
    }
    });
});
