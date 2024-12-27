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
                                <select id="app" name="app" class="filter-element">
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
                                <select name="language" id="language" class="filter-element">
                                    <option value="" >@c(['key' => 'select'])</option>
                                    @foreach( $locales as $locale)
                                        <option {{ ! empty( $filters['language']) ? (strtolower( $locale) == strtolower( $filters['language']) ? 'selected' : '') : '' }} value="{{ $locale }}">@c(['key' => $locale])</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-2">
                                <label for="user_id" class="form-label">@c(['key' => 'page'])</label>
                                <input type="text" class="form-control filter-element" id="page" name="page" value="{{ ! empty( $filters['page']) ?  $filters['page'] : '' }}">
                            </div>
                            <div class="col-2">
                                <label for="app" class="form-label">@c(['key' => 'status'])</label><br>
                                <select name="status" id="status" class="filter-element">
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
                                <select name="mimetype" id="mimetype" class="filter-element">
                                    <option value="" {{ ! empty( $filters['mimetype']) ? ( '' == strtolower( $filters['mimetype']) ? 'selected' : '') : 'selected' }}>@c(['key' => 'select'])</option>
                                    <option value="text/plain" {{ ! empty( $filters['mimetype']) ? ( 'text/plain' == strtolower( $filters['mimetype']) ? 'selected' : '') : '' }}>text/plain</option>
                                    <option value="text/html" {{ ! empty( $filters['mimetype']) ? ( 'text/html' == strtolower( $filters['mimetype']) ? 'selected' : '') : '' }}>text/html</option>
                                    <option value="image/jpeg" {{ ! empty( $filters['mimetype']) ? ( 'image/jpeg' == strtolower( $filters['mimetype']) ? 'selected' : '') : '' }}>image/jpeg</option>
                                    <option value="image/jpg" {{ ! empty( $filters['mimetype']) ? ( 'image/jpg' == strtolower( $filters['mimetype']) ? 'selected' : '') : '' }}>image/jpg</option>
                                    <option value="image/png" {{ ! empty( $filters['mimetype']) ? ( 'image/png' == strtolower( $filters['mimetype']) ? 'selected' : '') : '' }}>image/png</option>
                                    <option value="image/webp"  {{ ! empty( $filters['mimetype']) ? ( 'image/webp' == strtolower( $filters['mimetype']) ? 'selected' : '') : '' }}>image/webp</option>
                                    <option value="image/svg" {{ ! empty( $filters['mimetype']) ? ( 'image/svg' == strtolower( $filters['mimetype']) ? 'selected' : '') : '' }}>image/svg</option>
                                </select>
                            </div>

                            <div class="col-2">
                                <label for="env_source" class="form-label">@c(['key' => 'env_source'])</label>
                                <select name="env_source" id="env_source" class="filter-element">
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
                                <select name="env" id="env" class="filter-element">
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
                    <form class="row g-3" >
                        <div class="col-auto">
                            <label for="formFile" class="form-label">{{__('With selected')}}:</label>
                        </div>
                        <div class="col-2">
                            <select id="sel_actions" class="form-control" >
                                <option value="" selected>{{__('Select')}}</option>
                                <option value="delete">{{__('Delete')}}</option>
                                <option value="update">{{__('Update')}}</option>
                            </select>
                        </div>
                        <div class="col-1">
                            <a id="btn_action" href="javascript:void(0)" class="btn btn-primary disabled form-control">{{__('Apply')}}</a>
                        </div>

                    </form>
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
                                    <a href="javascript:void(0)" class="duplicate" data-id="{{ $item->id }}" data-mimetype="text/plain" data-value="{{ $item->value }}" style="text-decoration: underline">
                                        @c(['key' => 'duplicate'])
                                    </a>
                                </td>
                                <td>{{ $item->id ?? '-'}}</td>
                                <td>{{ $item->parent_id ?? '-'}}</td>
                                <td>{{ $item->user_id ?? '-'}}</td>
                                <td>{{ $item->status}}</td>
                                <td>{{ $item->page ?? '-'}}</td>
                                <td>{{ $item->language ?? '-'}}</td>
                                <td>
                                    {{ $item->key}}
                                </td>
                                <td>
                                    @if( $item->mimetype === 'text/plain')
                                        <input type="text" class="text-plain value id_{{ $item->id }}" data-id="{{ $item->id }}" data-mimetype="text/plain" data-value="{{ $item->value }}" value="{{ $item->value}}">
                                    @endif
                                    @if( $item->mimetype === 'text/html')
                                        <textarea rows="1" class="txt-html value id_{{ $item->id }}" data-id="{{ $item->id }}" data-mimetype="text/html" data-value="{{ $item->value }}">{{ $item->value }}</textarea>
                                    @endif
                                    @if( in_array( strtolower($item->mimetype), ['image/jpg', 'image/jpeg', 'image/png', 'image/svg', 'image/webp',]))
                                        <label class="id_{{ $item->id }}">Original: {{ $item->value }}</label>
                                        <form action="/file-upload"
                                              class="dropzone open-image" data-mimetype="image" data-value="{{ $item->value }}"
                                              id="my-awesome-dropzone"></form>
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
                <form id="frm_tag">
                    <input type="hidden" name="_method">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">New tag</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" class="id" name="id">
                        <input type="hidden" class="env_source" name="env_source">
                        <div class="row">
                            <div class="col-1">
                                <label for="app" class="form-label">App</label>
                                <select name="app" id="app" class="app">
                                    <option value="" selected>@c(['key' => 'select'])</option>
                                    <option value="Select Finance">Select Finance</option>
                                    <option value="VendiFill">VendiFill</option>
                                </select>
                            </div>

                            <div class="col-1">
                                <label for="parent_id" class="form-label">Parent ID</label>
                                <input type="number" class="form-control parent_id" id="parent_id" name="parent_id">
                            </div>
                            <div class="col-1">
                                <label for="user_id" class="form-label">User ID</label>
                                <input type="number" class="form-control user_id" id="user_id" name="user_id">
                            </div>
                            <div class="col-1">
                                <label for="active" class="form-label">Status</label>
                                <select name="status" id="status" class="status">
                                    <option value="active" selected>@c(['key' => 'Active'])</option>
                                    <option value="inactive">@c(['key' => 'Inactive'])</option>
                                </select>
                            </div>
                            <div class="col-2">
                                <label for="env" class="form-label">Env</label>
                                <select name="env" id="env" class="env">
                                    <option value="production" selected>@c(['key' => 'Production'])</option>
                                    <option value="local">@c(['key' => 'Local'])</option>
                                </select>
                            </div>
                            <div class="col-2">
                                <label for="publish" class="form-label">publish</label>
                                <input type="date" class="form-control publish_at" id="publish_at" name="publish_at">
                            </div>
                            <div class="col-2">
                                <label for="expire" class="form-label">expire</label>
                                <input type="date" class="form-control expire_at" id="expire_it" name="expire_at">
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-2">
                                <label for="language" class="form-label">Language</label>
                                <select name="language" id="language" class="language">
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
                                <select name="mimetype" id="mimetype" class="mimetype">
                                    <option value="text/plain">text/plain</option>
                                    <option value="text/html">text/html</option>
                                    <option value="image/jpeg">image/jpeg</option>
                                    <option value="image/jpg">image/jpg</option>
                                    <option value="image/png">image/png</option>
                                    <option value="image/webp">image/webp</option>
                                    <option value="image/svg">image/svg</option>
                                </select>
                            </div>
                            <div class="col-2">
                                <label for="page" class="form-label">Page</label>
                                <input type="text" class="form-control page" id="page" name="page">
                            </div>
                            <div class="col-2">
                                <label for="key" class="form-label">Key</label>
                                <input type="text" class="form-control key" id="key" name="key">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-auto">
                                <label for="value" class="form-label">Value</label>
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
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />

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


        $('#text_html').tinymce({ height: 500, /* other settings... */ });

        $('.btn.tag.new').on('click', function( e){
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
        $('.duplicate').on('click', function( e){
            // prefill form with selected options from current tag
            let id = parseInt( this.dataset.id);
            let tag = content.find(obj => {
                return obj.id === id
            })
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
            // remove id since this is a new tag
            $( '#mdl_new').find( '.id').val( '')
            // set the env_source to user logged in
            $( '#mdl_new').find( '.env_source').val( user.email)

            $( '#mdl_new').find( '.' + property).val( tag[property])
            mdlNew.show();
        })

        function saveContent( id, value){
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

        $('.save_text_html').on('click', function( e){
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
        $('#btn_action').on('click', function( e){
            e.preventDefault;
            let action = $('#sel_actions').val();
            switch( action){
                case 'delete':
                    deleteSelected( actionIds);
                    break;
                case 'update':
                    $( '#mdl_new').find( '.id').val( JSON.stringify( actionIds))
                    // set the env_source to user logged in
                    $( '#mdl_new').find( '.env_source').val( user.email)
                    mdlNew.show();
                    $( '#mdl_new').find( '[name="_method"]').val( 'PUT')
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

    </script>
</x-app-layout>
