
@extends('layouts.admin.admin_layout',['title'=>'Edit Deal SubCategory'])
@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <x-admin.title-and-breadcrumb title="Edit Deal SubCategory"
                                      breadcrumbs='{"Home":"dashboard","Deals SubCategory":"sub_categories.index","Edit Deal SubCategory":""}'/>
        <!-- /.content-header -->

        <x-admin.ui.card-form title="Deal SubCategory Details" form-route="sub_categories.update" form-id="edit_deal_sub_category" form-route-id="{{ $sub_category->dealSubCategoryId }}">
            <x-slot name="input">
                <div class="mb-3">
                    <x-admin.ui.bootstrap-switch name="status" id="status" label="Status" onText="Active"
                                                 offText="Inactive" :value="$sub_category->dealSubCategoryStatus"/>
                </div>
                <x-admin.ui.select label="Select Category"
                                   type="text"
                                   name="category"
                                   id="category"
                                   add-class=""
                                   :options="\App\Models\DealCategory::categoryAsArray()"
                                   required
                                   :value="$sub_category->dealCategoryId"/>
                <x-admin.ui.input label="SubCategory name" type="text" name="sub_category_name" id="sub_category_name"
                                  add-class=""
                                  :value="$sub_category->dealSubCategoryName"
                                  required/>
            </x-slot>
            <x-slot name="button">
                <x-admin.ui.button type="submit" btn-name="Submit" name="category_submit" id="category_submit"/>
            </x-slot>
        </x-admin.ui.card-form>
    </div>
@endsection
