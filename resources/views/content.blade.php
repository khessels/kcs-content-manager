<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Content
        </h2>

    </x-slot>

    <form>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="row">
                            <div class="col6">
                                @c(['key' => 'App']):
                                <select id="app" name="app" class="form-select filter-element">
                                    <option value="">@c(['key' => 'select'])</option>
                                    @foreach( $apps as $app)
                                        <option {{ ! empty( $filters['app']) ? (strtolower( $app->name) == strtolower( $filters['app']) ? 'selected' : '') : ''}} value="{{ $app->name }}">{{ $app->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2">
                                <label for="language" class="form-label">@c(['key' => 'language'])</label>
                                <select name="language" id="language" class="form-select filter-element">
                                    <option value="" >@c(['key' => 'select'])</option>
                                    <option value="all" >@c(['key' => 'all'])</option>
                                    @foreach( $locales as $locale)
                                        <option {{ ! empty( $filters['language']) ? (strtolower( $locale) == strtolower( $filters['language']) ? 'selected' : '') : '' }} value="{{ $locale }}">@c(['key' => $locale])</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-2">
                                <label for="page" class="form-label">@c(['key' => 'page'])</label>
                                <input class="form-control filter-element" type="text" id="page" name="page" value="{{ ! empty( $filters['page']) ?  $filters['page'] : '' }}">
                            </div>
                            <div class="col-2">
                                <label for="status" class="form-label">@c(['key' => 'status'])</label><br>
                                <select name="status" id="status" class="form-select filter-element">
                                    <option {{ ! empty( $filters['status']) ? ( '' == strtolower( $filters['status']) ? 'selected' : '') : 'selected' }} value="" >@c(['key' => 'select'])</option>
                                    <option {{ ! empty( $filters['status']) ? ( 'active' == strtolower( $filters['status']) ? 'selected' : '') : '' }} value="active">@c(['key' => 'active'])</option>
                                    <option {{ ! empty( $filters['status']) ? ( 'inactive' == strtolower( $filters['status']) ? 'selected' : '') : '' }} value="inactive">@c(['key' => 'inactive'])</option>
                                </select>
                            </div>

                            <div class="col-2">
                                <label for="parent_id" class="form-label">@c(['key' => 'parent id'])</label>
                                <input style="max-width:100px" type="number" class="form-control filter-element" id="parent_id" name="parent_id" value="{{ ! empty( $filters['parent_id']) ?  $filters['parent_id'] : '' }}">
                            </div>
                            <div class="col-2">
                                <label for="user_id" class="form-label">@c(['key' => 'user id'])</label>
                                <input style="max-width:100px"  type="number" class="form-control filter-element" id="user_id" name="user_id" value="{{ ! empty( $filters['user_id']) ?  $filters['user_id'] : '' }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <label for="key" class="form-label">@c(['key' => 'key'])</label>
                                <input type="text" class="form-control filter-element" id="key" name="key" value="{{ ! empty( $filters['key']) ?  $filters['key'] : '' }}">
                            </div>
                            <div class="col-3">
                                <label for="value" class="form-label">@c(['key' => 'value'])</label>
                                <input type="text" class="form-control filter-element" id="value" name="value" value="{{ ! empty( $filters['value']) ?  $filters['value'] : '' }}">
                            </div>
                            <div class="col-2">
                                <label for="mimetype" class="form-label">@c(['key' => 'mimetype'])</label>
                                <select name="mimetype" id="mimetype" class="form-select filter-element">
                                    <option value="" {{ ! empty( $filters['mimetype']) ? ( '' == strtolower( $filters['mimetype']) ? 'selected' : '') : 'selected' }}>@c(['key' => 'select'])</option>
                                    @foreach( $mimetypes as $mimetype)
                                        <option value="{{ $mimetype->mimetype }}" {{ ! empty( $filters['mimetype']) ? ( $mimetype->mimetype == strtolower( $filters['mimetype']) ? 'selected' : '') : '' }}>{{ $mimetype->mimetype}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-2">
                                <label for="env_source" class="form-label">@c(['key' => 'env_source'])</label>
                                <select name="env_source" id="env_source" class="form-select filter-element">
                                    <option value="" {{ ! empty( $filters['env_source']) ? ( '' == strtolower( $filters['env_source']) ? 'selected' : '') : 'selected' }}>@c(['key' => 'select'])</option>
                                    <option value="unknown" {{ ! empty( $filters['env_source']) ? ( 'unknown' == strtolower( $filters['env_source']) ? 'selected' : '') : '' }}>Unknown</option>
                                    <option value="kees.hessels@gmail.com" {{ ! empty( $filters['env_source']) ? ( 'kes.hessels@gmail.com' == strtolower( $filters['env_source']) ? 'selected' : '') : '' }}>kees.hessels@gmail.com</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <label for="publish_at" class="form-label">@c(['key' => 'publish @'])</label>
                                <input type="date" class="form-control filter-element" id="publish_at" name="publish_at" value="{{ ! empty( $filters['publish_at']) ?  $filters['publish_at'] : '' }}">
                            </div>
                            <div class="col-3">
                                <label for="expire_at" class="form-label">@c(['key' => 'expire @'])</label>
                                <input type="date" class="form-control filter-element" id="expire_at" name="expire_at" value="{{ ! empty( $filters['expire_at']) ?  $filters['expire_at'] : '' }}">
                            </div>
                            <div class="col-2">
                                <label for="env" class="form-label">@c(['key' => 'env'])</label><br>
                                <select name="env" id="env" class="form-select filter-element">
                                    <option value="" {{ ! empty( $filters['env']) ? ( '' == strtolower( $filters['env']) ? 'selected' : '') : 'selected' }}>@c(['key' => 'select'])</option>
                                    <option value="local" {{ ! empty( $filters['env']) ? ( 'local' == strtolower( $filters['env']) ? 'selected' : '') : '' }}>@c(['key' => 'local'])</option>
                                    <option value="production" {{ ! empty( $filters['env']) ? ( 'production' == strtolower( $filters['env']) ? 'selected' : '') : '' }}>@c(['key' => 'production'])</option>
                                </select>
                            </div>
                        </div>
                        <div class="row" style="padding-top: 20px;">
                            <div class="col-4">
                                <button type="submit" class="btn btn-primary">@c(['key' => 'Apply Filter(s)'])</button>
                                <button type="reset" class="btn btn-secondary">@c(['key' => 'Reset'])</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="row" >
                        <div class="col-6">
                            <form style='display:inline;'>
                                <label for="formFile" >{{__('With selected')}}:</label>
                                <select id="sel_actions">
                                    <option value="" selected>{{__('Select')}}</option>
                                    <option value="delete">{{__('Delete')}}</option>
                                    <option value="update">{{__('Update')}}</option>
                                </select>
                                <a id="btn_action" href="javascript:void(0)" class="btn btn-primary disabled ">{{__('Apply')}}</a>
                            </form>
                        </div>
                        <div class="col-2">
                        </div>
                        <div class="col-2">
                        </div>
                    </div>
                    <div class="col-auto">
                        <a href="javascript:void(0)" class="btn tag new btn-outline-primary">@c(['key' => 'New translation'])</a>
                    </div>
                    <table id="tbl_content" class="table table-striped" style="width:100%; font-size:80%">
                        <thead>
                            <tr>
                                <th>{{__('Select')}}</th>
                                <th>{{__('Id')}}</th>
                                <th>{{__('Parent Id')}}</th>
                                <th>{{__('User Id')}}</th>
                                <th>{{__('Status')}}</th>
                                <th>{{__('Page')}}</th>
                                <th>{{__('Lang')}}</th>
                                <th>{{__('Key')}}</th>
                                <th>{{__('Value')}}</th>
                                <th>{{__('Mime')}}</th>
                                <th>{{__('Publish @')}}</th>
                                <th>{{__('Expire @')}}</th>
                                <th>{{__('Created @')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach( $content as $item)
                            <tr>
                                <td>
                                    <input type="checkbox" value="{{ $item->id }}" ><br>
                                    <a href="javascript:void(0)" class="duplicate" data-id="{{ $item->id }}" data-mimetype="{{ $item->mimetype }}" data-value="{{ $item->value }}" style="text-decoration: underline">
                                        @c(['key' => 'duplicate'])
                                    </a>
                                </td>
                                <td>{{ $item->id ?? '-'}}</td>
                                <td>{{ $item->parent_id ?? '-'}}</td>
                                <td>{{ $item->user_id ?? '-'}}</td>
                                <td>
                                    <select class='form-select item-status' name="status" id="status" data-id="{{ $item->id}}">
                                        @if( $item->status === 'ACTIVE')
                                            <option value='ACTIVE' selected>Active</option>
                                            <option value='INACTIVE'>Inactive</option>
                                        @else
                                            <option value='ACTIVE'>Active</option>
                                            <option value='INACTIVE' selected>Inactive</option>
                                        @endif
                                    </select>
                                </td>
                                <td>{{ $item->page ?? '-'}}</td>
                                <td>{{ $item->language ?? '-'}}</td>
                                <td>
                                    {{ $item->key}}
                                </td>
                                <td>
                                    @if( $item->mimetype === 'text/plain')
                                        <input type="text" class="form-control text-plain value id_{{ $item->id }}" data-id="{{ $item->id }}" data-mimetype="text/plain" data-value="{{ $item->value }}" value="{{ is_null($item->value) ? $item->default : $item->value }}">
                                    @endif
                                    @if( $item->mimetype === 'text/html')
                                        <textarea rows="1" class="form-control txt-html value id_{{ $item->id }}" data-id="{{ $item->id }}" data-mimetype="text/html" data-value="{{ $item->value }}">{{ is_null($item->value) ? html_entity_decode($item->default) : html_entity_decode($item->value) }}</textarea>
                                    @endif
                                    @if( in_array( strtolower($item->mimetype), ['image/jpg', 'image/jpeg', 'image/png', 'image/svg', 'image/webp',]))
                                        <label class="id_{{ $item->id }}">Original: {{ $item->value }}</label>
                                            <a href="javascript:void(0)" class="link image" data-id="{{ $item->id }}" data-mimetype="text/plain" data-value="{{ $item->value }}" style="text-decoration: underline">
                                                @c(['key' => 'Link image'])
                                            </a>
{{--                                        <form action="/resource" class="dropzone open-image" data-mimetype="image" data-value="{{ $item->value }}" ></form>--}}
                                    @endif

                                </td>
                                <td>{{ $item->mimetype ?? '-'}}</td>
                                <td>{{ $item->publish_at ?? '-'}}</td>
                                <td>{{ $item->expire_at ?? '-'}}</td>
                                <td>{{ $item->created_at ?? '-'}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="mdl_new" class="modal modal-xl" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="frm_tag" method="POST">
                    <input type="hidden" class="method" name="_method" value="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">New tag</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body ">
                        <input type="hidden" class="id" name="id">
                        <input type="hidden" class="env_source" name="env_source">
                        <input type="hidden" class="filename" name="filename">
                        <input type="hidden" class="uuid" name="uuid">
                        <div class="row">
                            <div class="col-1">
                                <label for="app" class="form-label">App</label>
                                <input name="cb_app" type="checkbox" class="update-selector" style="display:none;">
                                <select name="app" id="app" class="app">
                                    <option value="" selected>@c(['key' => 'select'])</option>
                                    <option value="Select Finance">Select Finance</option>
                                    <option value="VendiFill">VendiFill</option>
                                    <option value="Cleaning">Cleaning</option>
                                    <option value="lamigracion">La Migracion</option>
                                    <option value="offshore2">offshore2</option>
                                    <option value="travel">travel</option>
                                    <option value="myshop2">myshop2</option>
                                    <option value="batavia">Batavia</option>
                                </select>
                            </div>

                            <div class="col-1">
                                <label for="parent_id" class="form-label">Parent ID</label>
                                <input name="cb_parent_id" type="checkbox" class="update-selector" style="display:none;">
                                <input type="number" class="form-control parent_id" id="parent_id" name="parent_id">
                            </div>
                            <div class="col-1">
                                <label for="user_id" class="form-label">User ID</label>
                                <input name="cb_user_id" type="checkbox" class="update-selector" style="display:none;">
                                <input type="number" class="form-control user_id" id="user_id" name="user_id">
                            </div>
                            <div class="col-1">
                                <label for="active" class="form-label">Status</label>
                                <input name="cb_status" type="checkbox" class="update-selector" style="display:none;">
                                <select name="status" id="status" class="status">
                                    <option value="active" selected>@c(['key' => 'Active'])</option>
                                    <option value="inactive">@c(['key' => 'Inactive'])</option>
                                </select>
                            </div>
                            <div class="col-2">
                                <label for="env" class="form-label">Env</label>
                                <input name="cb_env" type="checkbox" class="update-selector" style="display:none;">
                                <select name="env" id="env" class="env">
                                    <option value="production" selected>@c(['key' => 'Production'])</option>
                                    <option value="local">@c(['key' => 'Local'])</option>
                                </select>
                            </div>
                            <div class="col-2">
                                <label for="publish" class="form-label">publish</label>
                                <input name="cb_publish_at" type="checkbox" class="update-selector" style="display:none;">
                                <input type="date" class="form-control publish_at" id="publish_at" name="publish_at">
                            </div>
                            <div class="col-2">
                                <label for="expire" class="form-label">expire</label>
                                <input name="cb_expire_at" type="checkbox" class="update-selector" style="display:none;">
                                <input type="date" class="form-control expire_at" id="expire_it" name="expire_at">
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-2">
                                <label for="language" class="form-label">Language</label>
                                <input name="cb_language" type="checkbox" class="update-selector" style="display:none;">
                                <select name="language" id="language" class="language">
                                    <option value="all" selected>@c(['key' => 'all' ])</option>
                                    @foreach( config('app.available_locales') as $locale)
                                        @php
                                            $selected = '';
                                            if( app()->getLocale() === $locale){
                                                $selected = 'selected';
                                            }
                                        @endphp
                                        <option value="{{ $locale }}" {{ $selected }}>@c(['key' => $locale ])</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-2">
                                <label for="mimetype" class="form-label">@c(['key' => 'mimetype'])</label>
                                <input name="cb_mimetype" type="checkbox" class="update-selector" style="display:none;">
                                <select name="mimetype" id="mimetype" class="mimetype">
                                    @foreach( $mimetypes as $mimetype)
                                        <option value="{{ $mimetype->mimetype }}" >{{ $mimetype->mimetype}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-2">
                                <label for="page" class="form-label">Page</label>
                                <input name="cb_page" type="checkbox" class="update-selector" style="display:none;">
                                <input type="text" class="form-control page" id="page" name="page">
                            </div>
                            <div class="col-2">
                                <label for="key" class="form-label">Key</label>
                                <input name="cb_key" type="checkbox" class="update-selector" style="display:none;">
                                <input type="text" class="form-control key" id="key" name="key">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-auto">
                                <label for="value" class="form-label">Value</label>
                                <input name="cb_value" type="checkbox" class="update-selector" style="display:none;">
                                <input type="text" class="form-control value" id="value" name="value">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary save_text_html">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="mdl_text_html" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">key: Language: Page:</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" class="id">
                    <div id="text_html"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary save_text_html">Save changes</button>
                </div>
            </div>
        </div>
    </div>
{{--    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>--}}
{{--    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />--}}

    <script src="/tinymce/tinymce.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tinymce/tinymce-jquery@2/dist/tinymce-jquery.min.js"></script>
    <script>
        let table = new DataTable('#tbl_content');
        let actionIds = [];
        let body = $('body');
        let content = @json( $content);
        let user = @json( $user);
        var mdlTextHtml = new bootstrap.Modal(document.getElementById("mdl_text_html"), {});
        var mdlNew = new bootstrap.Modal(document.getElementById("mdl_new"), {});

        body.on('change', '.item-status', function(){
            let id = this.dataset.id
            let val = this.value
            //console.log( val + ", " + id)
            $.ajax({
                headers : {
                    'X-CSRF-Token' : "{{ csrf_token() }}"
                },
                success : function( data) {
                    toastr.success( "Item status changed")
                    console.log( "Item status changed")
                },
                error: function (a, b, c){
                    toastr.error( a)
                    console.log( a)
                },
                url : '/content/' + id + "/status/" + val,
                type : 'PATCH'
            });

        })

        const config = {
            entity_encoding: "raw",
            license_key: 'gpl',
            selector: '.cms',
            menubar: true,
            inline: true,
            convert_urls:false,
            plugins: [
                'link', 'lists', 'nonbreaking', 'autolink', 'code'
            ],
            toolbar: [
                'undo redo | bold italic underline | fontfamily fontsize | code',
                'forecolor backcolor | alignleft aligncenter alignright alignfull | numlist bullist outdent indent'
            ],
            // closed: /^(br|hr|input|meta|img|link|param|area|source)$/,
            // valid_styles: {
            //     '*': 'font-size,font-family,color,text-decoration,text-align'
            // },
            //
            extended_valid_elements:"i[id|class|style],em,br[id|class|style]",
            // closed: /^(br|hr|input|meta|img|link|param|area|source)$/,
            // powerpaste_word_import: 'clean',
            // powerpaste_html_import: 'clean',
            {{--setup: function (editor) {--}}
            {{--    editor.on('change', function (elm) {--}}
            {{--        let content = editor.getContent()--}}
            {{--        console.log('Editor content changed:', content);--}}
            {{--        let id = elm.target.bodyElement.dataset.cmsId;--}}
            {{--        let mimetype = elm.target.bodyElement.dataset.cmsMimetype;--}}

            {{--        $.ajax('/cms/tag/direct/' + app + '/' + id, {--}}
            {{--            data: {--}}
            {{--                _method: 'patch',--}}
            {{--                "_token" : "{{ csrf_token() }}",--}}
            {{--                'value': editor.getContent(),--}}
            {{--                'mimetype': mimetype--}}
            {{--            },--}}
            {{--            type:'patch',--}}
            {{--            success: function(){--}}
            {{--                toastr.success("Updated", "Content");--}}
            {{--            },--}}
            {{--            error: function(){--}}
            {{--                toastr.error("Failed updating", "Content");--}}
            {{--            }--}}
            {{--        })--}}
            {{--    });--}}
            {{--}--}}
        };
        $('#text_html').tinymce({
            height: 500,
            license_key: 'gpl',
            convert_urls:false,
            setup: function (editor) {
                    editor.on('change', function (elm) {
                        let content = editor.getContent()
                        // let content = tinymce.get('text_html').getContent();
                        let id = $("#mdl_text_html .id" ).val()
                        saveContent( id, content)
                    })
            },
            plugins: [
                'link', 'lists', 'nonbreaking', 'autolink', 'code'
            ],toolbar: [
                'undo redo | bold italic underline | fontfamily fontsize | code',
                'forecolor backcolor | alignleft aligncenter alignright alignfull | numlist bullist outdent indent'
            ]
        });

        body.on('click', '.btn.tag.new', function( e){
            // prefill form with selected options from filter
            $('.filter-element').each(function(index, elm){
                let tagName = elm.tagName;
                let name = elm.name;
                let value = $(elm).val();
                $('#mdl_new').find('.' + name).val( value);
            })
            // set the env_source to user logged in
            $( '#mdl_new').find( '.env_source').val( user.email)
            mdlNew.show();
        })
        function duplicate( tag){
            for(var property in tag){
                if( property !== 'value') {
                    let v = tag[property];
                    $('#mdl_new').find('.' + property).val( tag[property])
                }else{
                    let val = tag.value;
                    if( typeof tag.default !== 'undefined'){
                        if( tag.default !== '') {
                            val = tag.default;
                        }
                    }
                    $( '#mdl_new').find( '.value').val( val)
                }
            }
            //$('#mdl_new .method').val('PUT')
        }

        body.on('click', '.duplicate', function( e){
            // prefill form with selected options from current tag
            let id = parseInt( this.dataset.id);
            let tag = content.find(obj => {
                return obj.id === id
            })
            duplicate( tag)
            $("#mdl_new .id" ).val( '')
            mdlNew.show();
        })

        function saveContent( id, value){
            console.log("saving...")
            $.ajax({
                headers : {
                    'X-CSRF-Token' : "{{ csrf_token() }}"
                },
                success : function( data) {
                    //window.location.reload()
                },
                error: function (a, b, c){
                    console.log( a)
                },
                data: { value:value},
                url : '/content/' + id ,
                type : 'PUT'
            });
        }

        body.on('dblclick', '.txt-html', function( e){
            let content = this.value;
            let id = e.currentTarget.dataset.id
            $("#mdl_text_html .id" ).val( id)
            tinymce.get('text_html').setContent(content);
            mdlTextHtml.show();
        })

        body.on('click', '.save_text_html', function( e){
            let content = tinymce.get('text_html').getContent();
            let id = $("#mdl_text_html .id" ).val()
            saveContent( id, content)
            mdlTextHtml.hide();
            $('.id_' + id).val( content)
        })

        body.on('click', 'input[type=checkbox]', function(){
            let val = this.value
            if( this.checked){
                actionIds.push( this.value)
                $('#btn_action').removeClass('disabled');
            }else{
                actionIds = actionIds.filter( function( obj ) {
                    return obj !== val;
                });
                if( actionIds.length === 0){
                    $('#btn_action').addClass('disabled');
                }
            }
        })

        function deleteSelected( ids){
            $.ajax({
                headers : {
                    'X-CSRF-Token' : "{{ csrf_token() }}"
                },
                success : function( data) {
                    window.location.reload()
                },
                error: function (a, b, c){
                    console.log( a)
                },
                data: JSON.stringify( actionIds),
                url : '/content?ids=' + actionIds.toString() ,
                type : 'DELETE'
            });
        }
        body.on('click', '#btn_action', function( e){
            e.preventDefault;
            let action = $('#sel_actions').val();
            switch( action){
                case 'delete':
                    deleteSelected( actionIds);
                    break;
                case 'update':
                    $( '#mdl_new').find( '.id').val( actionIds)
                    // set the env_source to user logged in
                    $( '#mdl_new').find( '.env_source').val( user.email)
                    $( '#mdl_new').find( '[name="_method"]').val( 'PUT')
                    $( '#mdl_new').find( '.update-selector').show();
                    mdlNew.show();
            }
        })
        body.on('keyup', '.text-plain.value', function( e){
            let mimetype = e.currentTarget.dataset.mimetype
            let id = e.currentTarget.dataset.id
            let value = undefined

            if( mimetype === 'text/plain' || mimetype === 'text/html'){
                value = this.value;
            }
            saveContent( id, value)
        })
        body.on('keyup','textarea', function( e){
            let mimetype = e.currentTarget.dataset.mimetype
            let id = e.currentTarget.dataset.id
            let value = undefined

            if( mimetype === 'text/plain' || mimetype === 'text/html'){
                value = this.value;
            }
            saveContent( id, value)
        })
        document.addEventListener('focusin', function (e) {
            if (e.target.closest('.tox-tinymce-aux, .moxman-window, .tam-assetmanager-root') !== null) {
                e.stopImmediatePropagation();
            }
        });
    </script>
</x-app-layout>
