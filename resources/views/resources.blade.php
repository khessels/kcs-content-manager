<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Resources') }}
        </h2>
    </x-slot>
{{--    https://www.itsolutionstuff.com/post/laravel-11-drag-and-drop-file-upload-with-dropzone-jsexample.html--}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="row">
                        <div class="col-6">
                            <form action="/resource" class="dropzone" id="my-awesome-dropzone" data-position="new">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <select id="sel_actions">
                        <option value="" selected>{{__('Select')}}</option>
                        <option value="delete" >{{__('Delete')}}</option>
                        <option value="archive" >{{__('Archive')}}</option>
                    </select>
                    <button id="btn_action" type="button" class="btn btn-primary disabled">{{__('Apply')}}</button>
                    <table id="tbl_resources" class="table table-striped" style="width:100%; font-size:80%">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="cb_select_all"> {{__('Select')}}</th>
                                <th>{{__('Preview')}}</th>
                                <th>{{__('Name')}}</th>
                                <th>{{__('Dimensions')}}</th>
                                <th>{{__('Alt')}}</th>
                                <th>{{__('Title')}}</th>
                                <th>{{__('Actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach( $resources as $resource)
                            <tr>
                                <td><input type="checkbox" value="{{$resource['storage-name']}}" data-id="{{$resource['storage-name']}}"></td>
                                <td><img style="height:40px" height="40px" src="{{ $resource['url'] . $resource['storage-name'] }}" alt="" title=""></td>
                                <td>{{ $resource['storage-name'] }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <span disabled>Link to tag</span>
                                    <span disabled>copy tag</span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        let actionIds = [];
        let body = $( 'body');
        let myDropzone = new Dropzone(".dropzone", {
            maxFilesize: 20,
            paramName: "files",
            url: "/resource",
            uploadMultiple: true,
        });

        let table = new DataTable('#tbl_resources',{
            "columns": [
                {"name": "a", "orderable": false},
                {"name": "b", "orderable": true},
                {"name": "c", "orderable": true},
                {"name": "d", "orderable": true},
                {"name": "e", "orderable": true},
                {"name": "f", "orderable": true},
                {"name": "g", "orderable": true}
            ],
        });

        $('#cb_select_all').on('click', function(){
            let rows = table.rows( {page:'current'} ).data();
            if( $(this).is(':checked') ){
                for( let i = 0; i < rows.length; i++ ){
                    let email = $.parseHTML( rows[i][0])[0].defaultValue;
                    $('*[data-id="' + email + '"]').attr('checked', true);
                }
            } else {
                for( let i = 0; i < rows.length; i++ ){
                    let email = $.parseHTML( rows[i][0])[0].defaultValue;
                    $('*[data-id="' + email + '"]').attr('checked', false);
                }
            }
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
        $('#btn_action').on('click', function(){
            let action = $('#sel_actions').val();
            switch( action){
                case 'delete':
                    deleteSelected( actionIds);
                    break;
                case 'archive':
                    archiveSelected( actionIds);
            }
        })
        function deleteSelected( ids){
            {{--$.ajax({--}}
            {{--    headers : {--}}
            {{--        'X-CSRF-Token' : "{{ csrf_token() }}"--}}
            {{--    },--}}
            {{--    success : function( data) {--}}
            {{--        window.location.reload()--}}
            {{--    },--}}
            {{--    error: function (a, b, c){--}}
            {{--        console.log( a)--}}
            {{--    },--}}
            {{--    url : '/bkr/removal?ids=' + ids.toString() ,--}}
            {{--    type : 'DELETE'--}}
            {{--});--}}
        }
        function archiveSelected( ids){
            {{--$.ajax({--}}
            {{--    headers : {--}}
            {{--        'X-CSRF-Token' : "{{ csrf_token() }}"--}}
            {{--    },--}}
            {{--    success : function( data) {--}}
            {{--        window.location.reload()--}}
            {{--    },--}}
            {{--    error: function (a, b, c){--}}
            {{--        console.log( a)--}}
            {{--    },--}}
            {{--    data: { _token: "{{ csrf_token() }}"},--}}
            {{--    url : '/bkr/removal/archive?ids=' + ids.toString() ,--}}
            {{--    type : 'PUT'--}}
            {{--});--}}
        }
    </script>
</x-app-layout>
