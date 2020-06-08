@extends('layouts.dashboard')


@section('content')
    <div class="row">
        <div class="col-md-10" >
            <form action="{{route('update_invoice', $invoice->id)}}" method="post">
                @csrf
                
                    <div class="form-group row   {{ $errors->has('acct_id')? 'has-error' : '' }}">
                        <label class="col-sm-3 control-label" for="account_id">Account</label>
                        <div class="col-sm-7 acct_id">
                            <input type="text" name="acct_id" id="acct_id" disabled="disabled" value="{{$invoice->service->user->account_id}}" class="form-control appendUser" placeholder="Enter Account ID" />
                            {!! e_form_error('acct_id', $errors) !!}
                            <div id="user_id_area">
                                <div class="" style="color: green;">
                                    <span class="fa fa-user"> {{$invoice->service->user->name}}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row {{ $errors->has('job')? 'has-error' : '' }}">
                        <label class="col-sm-3 control-label" for="new_password">Job</label>
                        <div class="col-sm-7">
                            <div style="display: none;" id="loaderImg2" class=""><img src="{{asset('assets/loader/loader.gif')}}"   height="15" width="15">
                            </div>
                            <select name="job" id="job" class="form-control">
                                <option value="{{$invoice->service->id}}" selected="selected">{{$invoice->service->category}}</option>
                            </select> 
                            {!! e_form_error('job', $errors) !!}
                        </div>
                    </div>
                    @if($invoice->items->count())
                    <div class="itemEdit">
                    @foreach($invoice->items as $item)
                    <div class="form-group row {{ $errors->has('item')? 'has-error' : '' }}" id="item">
                        <label class="col-sm-3 control-label" for="item">Item *</label>
                        <div class="col-sm-3">
                            <input type="text" name="item_name[]" id="item_name" value="{{$item->item_name}}" class="form-control" placeholder="Name - Ex: Rim of Wire" />
                            {!! e_form_error('item_name', $errors) !!}
                        </div>
                        <div class="col-sm-2">
                            <input type="number" name="item_price[]" id="item_price" value="{{$item->item_price}}" class="form-control" placeholder="Price/Unit " />
                            {!! e_form_error('item_price', $errors) !!}
                        </div>
                        <div class="col-sm-2">
                            <input type="number" name="item_qty[]" id="item_qty" value="{{$item->quantity}}" class="form-control" placeholder="Quantity" />
                            {!! e_form_error('item_qty', $errors) !!}
                        </div>
                        <!--Use this id attribute to delete unique items-->
                        <a href="javascript:void(0)" class="delete" id="{{$item->id}}" style="color: red;"> 
                            <span class="fa fa-times-circle"></a>
                    </div>
                    @endforeach
                    </div>
                    @else
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="no text-center">
                                    <h1 class="display-1"><i class="la la-frown-o"></i> </h1>
                                    <h1>No items on this invoice</h1>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="new_item_edit"></div>
                    
                    <div class="form-group row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-success add_form_field_edit"><span class="fa fa-plus-circle"></span> Add Item</button>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-danger del_invoice_from_edit" id="{{$invoice->id}}"><span class="fa fa-trash-alt"></span> Delete this invoice</button>
                        </div>
                    </div>


                    <div class="form-group row">
                        <div class="offset-md-3 col-md-9">
                            <button type="submit" class="btn btn-success">Update</button>
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