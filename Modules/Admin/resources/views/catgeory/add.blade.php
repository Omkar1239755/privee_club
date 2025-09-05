@extends('admin::layouts.master')
@section('content')

<main>
    <div class="content-wrapper">
        <!-- Page Header -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 align-items-center">
                    <div class="col-sm-6">
                        <h1 class="m-0" style="color:#cf195a;">
                            <i class="fas fa-folder-plus mr-2"></i> Add Category
                        </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Category</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Section -->
        <section class="content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-12">
                        <div class="card shadow-sm border-0">
                            <div class="card-header text-white" style="background-color:#cf195a;">
                                <h3 class="card-title">
                                    <i class="fas fa-plus-circle mr-2"></i> Add New Category
                                </h3>
                            </div>
                            <div class="card-body">
                                <form action="#" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="category_name">Category Name</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" style="background-color:#cf195a; color:#fff;">
                                                    <i class="fas fa-tag"></i>
                                                </span>
                                            </div>
                                            <input type="text" id="category_name" name="category_name" class="form-control" placeholder="Enter category name" required>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <a href="{{ route('admin.catgeories') }}" class="btn" style="background-color:#6c757d; color:#fff;">
                                            <i class="fas fa-arrow-left"></i> Back
                                        </a>
                                        <button type="submit" class="btn" style="background-color:#cf195a; color:#fff;">
                                            <i class="fas fa-check-circle"></i> Submit
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>

@endsection
