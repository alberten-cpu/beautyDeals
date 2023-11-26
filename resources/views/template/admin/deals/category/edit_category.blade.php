
@extends('layouts.admin.admin_layout',['title'=>'Edit Deal Category'])
@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <x-admin.title-and-breadcrumb title="Edit Deal Category"
                                      breadcrumbs='{"Home":"dashboard","Deals Category":"categories.index","Edit Deal Category":""}'/>
        <!-- /.content-header -->

        <x-admin.ui.card-form title="Deal Category Details" form-route="categories.update" form-id="edit_deal_category" form-route-id="{{ $category->dealCategoryId }}">
            <x-slot name="input">
                <div class="mb-3">
                    <x-admin.ui.bootstrap-switch name="status" id="status" label="Status" onText="Active"
                                                 offText="Inactive" :value="$category->dealCategoryStatus"/>
                </div>
                <x-admin.ui.input label="Category name" type="text" name="category_name" id="category_name" add-class=""
                                  placeholder="" required :value="$category->dealCategoryName"/>
            </x-slot>
            <x-slot name="button">
                <x-admin.ui.button type="submit" btn-name="Submit" name="category_submit" id="category_submit"/>
            </x-slot>
        </x-admin.ui.card-form>
    </div>
@endsection
