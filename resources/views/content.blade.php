<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Content') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{__('With selected')}}
                    <select id="sel_actions">
                        <option value="" selected>{{__('Select')}}</option>
                        <option value="delete">{{__('Delete')}}</option>
                        <option value="expire" disabled>{{__('Expire')}}</option>
                        <option value="publish" disabled>{{__('Publish')}}</option>
                    </select>
                    <button id="btn_action" type="button" class="btn btn-primary disabled">{{__('Apply')}}</button>
                    <table id="tbl_content" class="table table-striped" style="width:100%; font-size:80%">
                        <thead>
                        <tr>
                            <th>{{__('Select')}}</th>
                            <th>{{__('App')}}</th>
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
                                <td><input type="checkbox" value="{{ $item->id }}" > </td>
                                <td>{{ $item->app ?? '-'}}</td>
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
                                        <input type="text" class="text_plain value" data-id="{{ $item->id }}" data-mimetype="text/plain" data-value="{{ $item->value }}" value="{{ $item->value}}">
                                    @endif
                                    @if( $item->mimetype === 'text/html')
                                        <textarea class="value open-txt-html" data-id="{{ $item->id }}" data-mimetype="text/html" data-value="{{ $item->value }}">{{ $item->value ?? '-'}}</textarea>
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
    <div id="mdl_text_html" class="modal text_html" tabindex="-1">
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
    <script src="/tinymce/tinymce.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tinymce/tinymce-jquery@2/dist/tinymce-jquery.min.js"></script>
    <script>
        let table = new DataTable('#tbl_content');
        let actionIds = [];
        let body = $('body');
        $('#text_html').tinymce({ height: 500, /* other settings... */ });
        var mdlTextHtml = new bootstrap.Modal(document.getElementById("mdl_text_html"), {});

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
        body.on('dblclick', '.open-txt-html', function( e){
            let content = this.value;
            let id = e.currentTarget.dataset.id
            $(".modal.text_html .id" ).val( id)
            tinymce.get('text_html').setContent(content);
            mdlTextHtml.show();
        })
        $('.save_text_html').on('click', function( e){
            let content = tinymce.get('text_html').getContent();
            let id = $(".modal.text_html .id" ).val()
            saveContent( id, content)
            mdlTextHtml.hide();
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
        $('#btn_action').on('click', function(){
            let action = $('#sel_actions').val();
            switch( action){
                case 'delete':
                    deleteSelected( actionIds);
                    break;
            }
        })
        body.on('keyup', '.text_plain.value', function( e){
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
