@extends('dash.core.app')

@section('content')

<div class="container-fluid">
    <div class="block-header">
        <h2>XML Items</h2>
    </div>
    <div class="row clearfix">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-pink hover-expand-effect">
                <div class="icon">
                    <i class="fas fa-khanda"></i>
                </div>
                <div class="content">
                    <div class="text">WEAPONS</div>
                    <div class="number count-to" data-from="0" data-to="{{ $queryWeapon }}" data-speed="15" data-fresh-interval="20">{{ $queryWeapon }}</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-cyan hover-expand-effect">
                <div class="icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <div class="content">
                    <div class="text">ARMOR</div>
                    <div class="number count-to" data-from="0" data-to="{{ $queryArmor }}" data-speed="1000" data-fresh-interval="20">{{ $queryArmor }}</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-light-green hover-expand-effect">
                <div class="icon">
                    <i class="fab fa-sketch"></i>
                </div>
                <div class="content">
                    <div class="text">ETC ITEMS</div>
                    <div class="number count-to" data-from="0" data-to="{{ $queryEtc }}" data-speed="1000" data-fresh-interval="20">{{ $queryEtc }}</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-orange hover-expand-effect">
                <div class="icon">
                    <i class="fas fa-cogs"></i>
                </div>
                <div class="content">
                    <div class="text">CUSTOMS</div>
                    <div class="number count-to" data-from="0" data-to="1225" data-speed="1000" data-fresh-interval="20">{{ $queryCustom }}</div>
                </div>
            </div>
        </div>
    </div>
        {{-- <form action="{{ route('xml.items.send') }}" method="post" enctype="multipart/form-data">
            @csrf
        <input type="file" class="form-control" name="files[]" multiple>
        <button type="submit" class="btn btn-primary">TEST</button>
        </form> --}}
        <!-- File Upload | Drag & Drop OR With Click & Choose -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            FILE UPLOAD - ARRASTE E SOLTE OU CLIQUE E SELECIONE
                        </h2>
                    </div>
                    <div class="body">
                        <form action="{{ route('xml.items.send') }}" id="my-awesome-dropzone" class="dropzone" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" value="@if(isset($custom))true @endif" name="custom_items" id="custom_items" />
                            <div class="dz-message">
                                <div class="drag-icon-cph">
                                    <i class="material-icons">touch_app</i>
                                </div>
                                <h3>Arraste os arquivos ou clique.</h3>
                            </div>
                            <div class="fallback">
                                <input name="files[]" type="file" multiple />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# File Upload | Drag & Drop OR With Click & Choose -->    
</div>

@endsection

@section('scripts')

@endsection