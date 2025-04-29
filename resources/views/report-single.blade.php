@extends('layouts.app')

@section('content')
<style>
    .header-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        max-width: 100%;
        max-height: 100%;
    }

    .container {
        max-width: 100%;
        max-height: 100%;
    }
    
    .report-card {
        margin-bottom: 30px;
        max-width: 100%;
        max-height: 100%;
    }
    
    .card-container {
        position: relative;
    }

    .report-iframe {
        width: 100%;
        height: 80vh;
        border: none;

    }
    .card-body {
        max-width: 100%;
        max-height: 100%;
        width: 100%;
        height: 100%;
    }
</style>

    <div class="row">
        <div class="col-md-12">
            <div class="header-container">
                <a href="{{ route('reports.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to All Reports
                </a>
                <h2>Report Viewer</h2>
            </div>
            
            <div class="card-body">
                <iframe src="{{ $report->Link }}" 
                        class="report-iframe"
                        loading="lazy"
                        sandbox="allow-same-origin allow-scripts allow-popups allow-forms">
                </iframe>
            </div>
        
            <div class="text-center">
                <a href="{{ $report->Link }}" target="_blank" class="btn btn-primary">
                    <i class="fas fa-external-link-alt"></i> Open in New Tab
                </a>
            </div>
        </div>
    </div>
@endsection
