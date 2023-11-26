
@extends('layouts.admin.admin_layout',['title'=>'Create Deal Category'])
@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <x-admin.title-and-breadcrumb title="Create Deal Category"
                                      breadcrumbs='{"Home":"dashboard","Deals Category":"categories.index","Create Deal Category":""}'/>
        <!-- /.content-header -->

        <x-admin.ui.card-form title="Deal Category Details" form-route="categories.store" form-id="create_deal_category">
            <x-slot name="input">
                <div class="mb-3">
                    <x-admin.ui.bootstrap-switch name="status" id="status" label="Status" onText="Active"
                                                 offText="Inactive" value="1"/>
                </div>
                <x-admin.ui.input label="Category name" type="text" name="category_name" id="category_name" add-class=""
                                  placeholder="" required/>
            </x-slot>
            <x-slot name="button">
                <x-admin.ui.button type="submit" btn-name="Submit" name="category_submit" id="category_submit"/>
            </x-slot>
        </x-admin.ui.card-form>
    </div>
@endsection
