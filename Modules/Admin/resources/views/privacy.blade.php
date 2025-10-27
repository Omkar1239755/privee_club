@extends('admin::layouts.master')
@section('content')
    <style>
        div.ck-editor__editable {
            min-height: 2000px;
        }

        input {
            width: 500%;
            border-radius: 10px;
            padding: 10px;
            margin-bottom: 10px;
        }
    </style>
    <div class="content-wrapper">
        <section class="content-header">
            <!--<div class="container-fluid">-->
            <!--    <div class="row mb-2">-->
            <!--        <div class="col-sm-6">-->
            <!--            <h1></h1>-->
            <!--        </div>-->
            <!--        <div class="col-sm-6">-->
            <!--            <ol class="breadcrumb float-sm-right">-->
            <!--                <li class="breadcrumb-item"><a href="#">Home</a></li>-->
            <!--                <li class="breadcrumb-item active"></li>-->
            <!--            </ol>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--</div>-->
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title"></h3>
                            </div>
                            <div class="card-body">
                                <form action="" method="POST">
                                    @csrf
                                      <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group mb-3">
                                                    <label class="col-form-label">Privacy</label>
                                                    <textarea id="editor" class="form-control" name="privacy" rows="15"></textarea>
                                                    @if($errors->has('privacy'))
                                                    <span class="text-danger">{{$errors->first('privacy')}}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
CKEDITOR.replace('editor', {
height: 300,  
removeButtons: 'Image,Flash,Table,Smiley,SpecialChar,PageBreak,Iframe' 
});
</script>
@endsection
