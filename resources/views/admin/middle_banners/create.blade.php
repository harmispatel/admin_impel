@extends('admin.layouts.admin-layout')
@section('title', 'CREATE - MIDDLE BANNERS - IMPEL JEWELLERS')
@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>Middle Banners</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
                        <li class="breadcrumb-item "><a href="{{ route('middle-banners.index') }}">Middle Banners</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    {{-- Create Middle Banner Section --}}
    <section class="section dashboard">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <form action="{{ route('middle-banners.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form_box">
                                <div class="form_box_inr">
                                    <div class="box_title">
                                        <h2>Middle Banner Details</h2>
                                    </div>
                                    <div class="form_box_info">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="image" class="form-label">Image <span class="text-danger">*</span></label>
                                                <input type="file" name="image" id="image" class="form-control {{ ($errors->has('image')) ? 'is-invalid' : '' }}">
                                                @if($errors->has('image'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('image') }}
                                                    </div>
                                                @endif
                                                <code>Note -: Image Upload in this Dimensions (550 x 450)</code>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="tag" class="form-label">Tag <span class="text-danger">*</span></label>
                                                <select name="tag" id="tag" class="form-select {{ ($errors->has('tag')) ? 'is-invalid' : '' }}">
                                                    <option value="">Select Tag</option>
                                                    @if(count($tags) > 0)
                                                        @foreach ($tags as $tag)
                                                            <option value="{{ $tag->id }}" {{ (old('tag') == $tag->id) ? 'selected' : '' }}>{{ $tag->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                @if($errors->has('tag'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('tag') }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label for="description" class="form-label">Description</label>
                                                <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-center">
                                <button class="btn form_button">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('page-js')
    <script type="text/javascript">

        // Select 2 for Tag
        $('#tag').select2({
            placeholder: "Select Tag",
            allowClear: true
        });

        // CKEditor for Description
        CKEDITOR.ClassicEditor.create(document.getElementById("description"),
        {
            toolbar: {
                items: [
                    'heading', '|',
                    'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', 'removeFormat', '|',
                    'bulletedList', 'numberedList', 'todoList', '|',
                    'outdent', 'indent', '|',
                    'undo', 'redo',
                    '-',
                    'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                    'alignment', '|',
                    'link', 'insertImage', 'blockQuote', 'insertTable', 'mediaEmbed', 'codeBlock', 'htmlEmbed', '|',
                    'specialCharacters', 'horizontalLine', 'pageBreak', '|',
                    'sourceEditing'
                ],
                shouldNotGroupWhenFull: true
            },
            list: {
                properties: {
                    styles: true,
                    startIndex: true,
                    reversed: true
                }
            },
            'height':500,
            fontSize: {
                options: [ 10, 12, 14, 'default', 18, 20, 22 ],
                supportAllValues: true
            },
            htmlSupport: {
                allow: [
                    {
                        name: /.*/,
                        attributes: true,
                        classes: true,
                        styles: true
                    }
                ]
            },
            htmlEmbed: {
                showPreviews: true
            },
            link: {
                decorators: {
                    addTargetToExternalLinks: true,
                    defaultProtocol: 'https://',
                    toggleDownloadable: {
                        mode: 'manual',
                        label: 'Downloadable',
                        attributes: {
                            download: 'file'
                        }
                    }
                }
            },
            mention: {
                feeds: [
                    {
                        marker: '@',
                        feed: [
                            '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes', '@chocolate', '@cookie', '@cotton', '@cream',
                            '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread', '@gummi', '@ice', '@jelly-o',
                            '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding', '@sesame', '@snaps', '@soufflé',
                            '@sugar', '@sweet', '@topping', '@wafer'
                        ],
                        minimumCharacters: 1
                    }
                ]
            },
            removePlugins: [
                'CKBox',
                'CKFinder',
                'EasyImage',
                'RealTimeCollaborativeComments',
                'RealTimeCollaborativeTrackChanges',
                'RealTimeCollaborativeRevisionHistory',
                'PresenceList',
                'Comments',
                'TrackChanges',
                'TrackChangesData',
                'RevisionHistory',
                'Pagination',
                'WProofreader',
                'MathType'
            ]
        });

    </script>
@endsection
