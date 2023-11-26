
@extends('layouts.admin.admin_layout',['title'=>'Create Deal SubCategory'])
@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <x-admin.title-and-breadcrumb title="Create Deal SubCategory"
                                      breadcrumbs='{"Home":"dashboard","Deals SubCategory":"sub_categories.index","Create Deal SubCategory":""}'/>
        <!-- /.content-header -->

        <x-admin.ui.card-form title="Deal SubCategory Details" form-route="sub_categories.store" form-id="create_deal_sub_category">
            <x-slot name="input">
                <div class="mb-3">
                    <x-admin.ui.bootstrap-switch name="status" id="status" label="Status" onText="Active"
                                                 offText="Inactive" value="1"/>
                </div>
                <x-admin.ui.select label="Select Category"
                                   type="text"
                                   name="category"
                                   id="category"
                                   add-class=""
                                   :options="\App\Models\DealCategory::categoryAsArray()"
                                   required/>
                <x-admin.ui.input label="SubCategory name" type="text" name="sub_category_name" id="sub_category_name" add-class=""
                                  placeholder="" required/>
            </x-slot>
            <x-slot name="button">
                <x-admin.ui.button type="submit" btn-name="Submit" name="category_submit" id="category_submit"/>
            </x-slot>
        </x-admin.ui.card-form>
    </div>
@endsection
