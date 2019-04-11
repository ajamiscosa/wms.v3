@extends('templates.content',[
    'title'=>'Reports',
    'description'=>'Shows list of available reports.',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Reports')
    ]
])
@section('title','Reports')
@section('content')
<div class="row pl-2">
    <div class="col-lg-3 col-6">
        @include('templates.smallbox', array(
            'box' => [
                'background' => 'bg-secondary',
                'text' => 'IL',
                'subtext' => 'Inventory Logs',
                'icon' => 'fa fa-box',
                'link' => '/reports/inventory-logs',
                'linktext' => 'Go to Inventory Logs',
            ]
        ))
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        @include('templates.smallbox', array(
            'box' => [
                'background' => 'bg-success',
                'text' => 'IR',
                'subtext' => 'Issuance Report',
                'icon' => 'fa fa-sign-out-alt',
                'link' => '/reports/issuance',
                'linktext' => 'Go to Issuance Report ',
            ]
        ))
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        @include('templates.smallbox', array(
            'box' => [
                'background' => 'bg-warning',
                'text' => 'RR',
                'subtext' => 'Receiving Report',
                'icon' => 'fa fa-sign-in-alt',
                'link' => '/reports/receiving',
                'linktext' => 'Go to Receiving Report ',
            ]
        ))
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        @include('templates.smallbox', array(
            'box' => [
                'background' => 'bg-danger',
                'text' => 'S&PCR',
                'subtext' => 'Supplies & Process Chem Report',
                'icon' => 'fa fa-flask',
                'link' => '/reports/supplies-pchem',
                'linktext' => 'Go to Supplies & Process Chem Report ',
            ]
        ))
    </div>
    <!-- ./col -->
 </div>
<div class="row pl-2">
    <div class="col-lg-3 col-6">
        @include('templates.smallbox', array(
            'box' => [
                'background' => 'bg-info',
                'text' => 'CR',
                'subtext' => 'Consumption Report',
                'icon' => 'fa fa-upload',
                'link' => '/reports/consumption',
                'linktext' => 'Go to Consumption Report ',
            ]
        ))
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        @include('templates.smallbox', array(
            'box' => [
                'background' => 'bg-light',
                'text' => 'IMR',
                'subtext' => 'Item Movement Report',
                'icon' => 'fa fa-truck-moving',
                'link' => '/reports/item-movement',
                'linktext' => 'Go to Item Movement Report ',
            ]
        ))
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        @include('templates.smallbox', array(
            'box' => [
                'background' => 'bg-dark',
                'text' => 'PRSR',
                'subtext' => 'PR Status Report',
                'icon' => 'fa fa-receipt',
                'link' => '/reports/pr-status',
                'linktext' => 'Go to PR Status Report ',
            ]
        ))
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        
    </div>
    <!-- ./col -->
 </div>
@endsection