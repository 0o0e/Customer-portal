@extends('layouts.app')

@section('content')
    <h1>Report Previews</h1>

    <!-- @php use Illuminate\Support\Str; @endphp -->

    <style>
        #report-container {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 20px;    
            max-width: 400px;
            position: relative;
        }

        #report-iframe {
            width: 100%;
            height: 200px;
            border: none;
        }
        
        .fullscreen-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(0,0,0,0.5);
            color: white;
            border: none;
            border-radius: 4px;
            padding: 5px 10px;
            z-index: 10;
        }
    </style>
    
    @if(count($reports) > 0)
        @foreach($reports as $report)
            <div id="report-container">
                <iframe src="{{ $report->Link }}" 
                        id="report-iframe"
                        loading="lazy"
                        sandbox="allow-same-origin allow-scripts allow-popups allow-forms">
                </iframe>
                <a href="{{ route('reports.show', $report->ID) }}" class="fullscreen-btn">
                    <i class="fas fa-expand"></i>
                </a>
                <div style="margin-top: 10px;">
                    <a href="{{ $report->Link }}" target="_blank" style="color: #007bff; text-decoration: underline;">
                        Open in New Tab
                    </a>
                </div>
            </div>
        @endforeach
    @else
        <div class="alert alert-info">
            No reports found.
        </div>
    @endif
@endsection
