@extends('dash.core.app')

@section('content')

<div class="container-fluid">
    <div class="block-header">
        <h2>XML Items</h2>
    </div>  
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
                        <form action="/" id="frmFileUpload" class="dropzone" method="post" enctype="multipart/form-data">
                            <div class="dz-message">
                                <div class="drag-icon-cph">
                                    <i class="material-icons">touch_app</i>
                                </div>
                                <h3>Arraste os arquivos ou clique.</h3>
                            </div>
                            <div class="fallback">
                                <input name="file" type="file" multiple />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# File Upload | Drag & Drop OR With Click & Choose -->    
</div>

@endsection