@extends('admin.layouts.admin-layout')
@section('title', $page_title.' - IMPEL JEWELLERS')
@section('content')

{{-- Page Title --}}
<div class="pagetitle">
    <h1>{{ $page_title }}</h1>
    <div class="row">
        <div class="col-md-8">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">{{ $page_title }}</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

{{-- Pages Section --}}
<section class="section dashboard">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('pages.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="slug" id="slug" value="{{ $page_slug }}">
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control {{ ($errors->has('name')) ? 'is-invalid' : '' }}" value="{{ (isset($page_details->name)) ? $page_details->name : '' }}">
                            @if($errors->has('name'))
                            <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                            @endif
                        </div>
                        <div class="form-group mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" name="image" id="image" class="form-control {{ ($errors->has('image')) ? 'is-invalid' : '' }}">
                            @if($errors->has('image'))
                            <div class="invalid-feedback">{{ $errors->first('image') }}</div>
                            @endif
                        </div>
                        @if(isset($page_details->image) && !empty($page_details->image) && file_exists('public/images/uploads/pages/'.$page_details->image))
                        <div class="form-group mb-3 text-center">
                            <img src="{{ asset('public/images/uploads/pages/'.$page_details->image) }}" alt="Page Image" width="300">
                        </div>
                        @endif
                        <div class="form-group mb-3">
                            <label for="content" class="form-label">Content</label>
                            <textarea name="content" id="content" class="form-control">{{ (isset($page_details->content)) ? $page_details->content : '' }}</textarea>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection


{{-- Custom Script --}}
@section('page-js')

<script type="text/javascript">
    // CKEditor for Content
    CKEDITOR.ClassicEditor.create(document.getElementById("content"), {
        toolbar: {
            items: [
                'heading', '|'
                , 'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', 'removeFormat', '|'
                , 'bulletedList', 'numberedList', 'todoList', '|'
                , 'outdent', 'indent', '|'
                , 'undo', 'redo'
                , '-'
                , 'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|'
                , 'alignment', '|'
                , 'link', 'insertImage', 'blockQuote', 'insertTable', 'mediaEmbed', 'codeBlock', 'htmlEmbed', '|'
                , 'specialCharacters', 'horizontalLine', 'pageBreak', '|'
                , 'sourceEditing'
            ]
            , shouldNotGroupWhenFull: true
        }
        , list: {
            properties: {
                styles: true
                , startIndex: true
                , reversed: true
            }
        }
        , 'height': 500
        , fontSize: {
            options: [10, 12, 14, 'default', 18, 20, 22]
            , supportAllValues: true
        }
        , htmlSupport: {
            allow: [{
                name: /.*/
                , attributes: true
                , classes: true
                , styles: true
            }]
        }
        , htmlEmbed: {
            showPreviews: true
        }
        , link: {
            decorators: {
                addTargetToExternalLinks: true
                , defaultProtocol: 'https://'
                , toggleDownloadable: {
                    mode: 'manual'
                    , label: 'Downloadable'
                    , attributes: {
                        download: 'file'
                    }
                }
            }
        }
        , mention: {
            feeds: [{
                marker: '@'
                , feed: [
                    '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes', '@chocolate', '@cookie', '@cotton', '@cream'
                    , '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread', '@gummi', '@ice', '@jelly-o'
                    , '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding', '@sesame', '@snaps', '@soufflé'
                    , '@sugar', '@sweet', '@topping', '@wafer'
                ]
                , minimumCharacters: 1
            }]
        }
        , removePlugins: [
            'CKBox'
            , 'CKFinder'
            , 'EasyImage'
            , 'RealTimeCollaborativeComments'
            , 'RealTimeCollaborativeTrackChanges'
            , 'RealTimeCollaborativeRevisionHistory'
            , 'PresenceList'
            , 'Comments'
            , 'TrackChanges'
            , 'TrackChangesData'
            , 'RevisionHistory'
            , 'Pagination'
            , 'WProofreader'
            , 'MathType'
        ]
    });

</script>

@endsection
