@extends('layouts.dashboard')

@section('content')

    <div class="row">
        <div class="col-md-10">

            <div class="form-group row">
                    <div class="col-sm-offset-4 col-sm-5">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-cat">Add New Category</button>
                    </div>
                </div>
        </div>

    </div>
            <!--Add Category Modal-->
             <div class="modal fade" id="add-cat" tabindex="-1" role="dialog" aria-labelledby="categories" aria-hidden="true">
                  <div class="modal-dialog " role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="">Add New Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div class="container-fluid">
                                <form method="post" action="">
                                @csrf

                                <div class="form-group row {{ $errors->has('category_name')? 'has-error':'' }}">
                                    <label for="category_name" class="col-sm-4 control-label">@lang('app.category_name')</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control {{e_form_invalid_class('category_name', $errors)}}" id="category_name" value="{{ old('category_name') }}" name="category_name" placeholder="@lang('app.category_name')">

                                        {!! e_form_error('category_name', $errors) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-offset-4 col-sm-5">
                                        <button type="submit" class="btn btn-primary">Add Category</button>
                                    </div>
                                </div>
                            </form>
                          </div>
                      </div>
                      <div class="modal-footer">
                        
                        
                      </div>
                    </div>
                  </div>
                </div>
            <!--//Add Cat ends-->

    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered" id="categories">
                <tr>
                    <th>@lang('app.category_name')</th>
                    <th>#</th>
                </tr>
                @foreach($categories as $category)
                    <tr>
                        <td>
                            {{ $category->category_name }}
                        </td>
                        <td>
                            <a href="{{ route('edit_categories', $category->id) }}" class="btn btn-info"><i class="la la-pencil"></i> </a>
                            <a href="javascript:;" class="btn btn-danger category_delete" data-id="{{ $category->id }}"><i class="la la-trash"></i> </a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>



@endsection