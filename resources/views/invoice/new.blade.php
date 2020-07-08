@extends('layouts.dashboard')


@section('content')
    <div class="row">
        <div class="col-md-10" >
            <form action="{{route('store-invoice')}}" method="post">
                @csrf
                
                    <div class="form-group row   {{ $errors->has('acct_id')? 'has-error' : '' }}">

                        <label class="col-sm-3 control-label" for="account_id">Account ID *</label>
                        <div class="col-sm-7 acct_id">
                            
                            <input type="text" name="acct_id" id="acct_id" class="form-control appendUser" placeholder="Enter Account ID" />
                            {!! e_form_error('acct_id', $errors) !!}
                            <div id="user_id_area">
                                <div style="display: none;" id="loaderImg" class="">
                                    <img src="{{asset('assets/loader/loader.gif')}}" height="15" width="15">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row {{ $errors->has('job')? 'has-error' : '' }}">
                        <label class="col-sm-3 control-label" for="new_password">Job *</label>
                        <div class="col-sm-7">
                            <div style="display: none;" id="loaderImg2" class="">
                                <img src="{{asset('assets/loader/loader.gif')}}"   height="15" width="15">
                            </div>
                            <select name="job" id="job" class="form-control createInvoiceSelect">
                            </select> 
                            {!! e_form_error('job', $errors) !!}
                        </div>
                    </div>

                    <div class="form-group row {{ $errors->has('artisan')? 'has-error' : '' }}" id="artisanList" style="display: none;">
                        <label class="col-sm-3 control-label" for="artisan" style="color: red;">Assign Artisan *</label>
                        <div class="col-sm-7">
                            <div style="display: none;" id="loaderImg2" class="">
                                <img src="{{asset('assets/loader/loader.gif')}}"   height="15" width="15">
                            </div>
                            <select name="artisan" id="artisanInfo" class="form-control">
                            </select> 
                            {!! e_form_error('artisan', $errors) !!}
                        </div>
                    </div>

                    <div class="form-group row {{ $errors->has('item')? 'has-error' : '' }}" >
                        <label class="col-sm-3 control-label" for="item">Item *</label>
                        <div class="col-sm-3">
                            <input type="text" name="item_name[]" id="item_name" class="form-control" placeholder="Name - Ex: Rim of Wire" required="" />
                            {!! e_form_error('item_name', $errors) !!}
                        </div>
                        <div class="col-sm-2">
                            <input type="number" name="item_price[]" id="item_price" class="form-control" placeholder="Price/Unit " required="" />
                            {!! e_form_error('item_price', $errors) !!}
                        </div>
                        <div class="col-sm-2">
                            <input type="number" name="item_qty[]" id="item_qty" class="form-control" placeholder="Quantity" required="" />
                            {!! e_form_error('item_qty', $errors) !!}
                        </div>
                    </div>

                    <div class="newItem"></div>
                
                    <div class="form-group row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-success add_form_field"><span class="fa fa-plus-circle"></span> Add Item</button>
                        </div>
                    </div>


                    <div class="form-group row">
                        <div class="offset-md-3 col-md-9">
                            <button type="submit" class="btn btn-success">Create</button>
                        </div>
                    </div>
            </form>


        </div>
    </div>

    <style type="text/css">
        .user_acct{
            display: none;
        }

        .loaderImg{
            position: absolute;
            display: inline-block;
        }

    </style>



@endsection