<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Applications') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="row">
                        <div class="col-4">
                            @c(['key' => 'App']):
                            <select id="app" name="app">
                                <option value="">@c(['key' => 'select'])</option>
                                @foreach( $apps as $app)
                                    <option {{ ! empty( $filters['app']) ? (strtolower( $app->name) == strtolower( $filters['app']) ? 'selected' : '') : ''}} value="{{ $app->name }}">{{ $app->name }}</option>
                                @endforeach
                            </select>
                            <input type="text" class="form-control" name="app_description" id="app_description" placeholder="@c(['key' => 'description'])">
                            <button class="btn btn-primary create-app-token">@c(['key' => 'Create'])</button>
                        </div>
                        <div class="col-4">
                            @c(['key' => 'User']):
                            <input type="text" class="form-control " disabled name="user_description" id="user_description" placeholder="@c(['key' => 'description'])">
                            <button class="btn btn-primary create-user-token disabled">@c(['key' => 'Create'])</button>
                        </div>
                        <div class="col-4">
                            <label>@c(['key' => 'token', 'default'=> 'Token'])</label>
                            <span id="token"></span>
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
                    <div class="row">
                        <div class="col-4">
                            <input type="text" class="form-control" name="app.token" id="app.token">
                            <button class="btn btn-primary get-app">@c(['key' => 'Get app'])</button>
                        </div>
                        <div class="col-4">
                            <input type="text" class="form-control" name="user.token" id="user.token">
                            <button class="btn btn-primary get-user">@c(['key' => 'Get user'])</button>
                        </div>
                        <div class="col-4">
                            <span id="token-app-user"></span>
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
                    <label >{{__('With selected')}}:</label>
                    <select id="sel_actions">
                        <option value="" selected>{{__('Select')}}</option>
                        <option value="delete">{{__('Delete')}}</option>
                        <option value="update">{{__('Update')}}</option>
                    </select>
                    <a id="btn_action" href="javascript:void(0)" class="btn btn-primary disabled ">{{__('Apply')}}</a>
                    <table id="tbl_tokens" class="table table-striped" style="width:100%; font-size:80%">
                        <thead>
                            <tr>
                                <th>{{__('Select')}}</th>
                                <th>{{__('Id')}}</th>
                                <th>{{__('Name')}}</th>
                                <th>{{__('Description')}}</th>
                                <th>{{__('Create @')}}</th>
                                <th>{{__('Expires $')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach( $tokens as $token)
                            <tr>
                                <td>
                                    <input type="checkbox" value="{{ $token->id }}" ><br>
                                </td>
                                <td>{{ $token->id ?? '-'}}</td>
                                <td>{{ $token->name ?? '-'}}</td>
                                <td>{{ $token->description ?? '-'}}</td>
                                <td>{{ $token->created_at ?? '-'}}</td>
                                <td>{{ $token->expires_at ?? '-'}}</td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        let table = new DataTable('#tbl_tokens');
        let body = $('body');
        let actionIds = [];
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
                url : '/tokens?ids=' + actionIds.toString() ,
                type : 'DELETE'
            });
        }
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
        body.on('click', '#btn_action', function( e){
            e.preventDefault;
            let action = $('#sel_actions').val();
            switch( action){
                case 'delete':
                    deleteSelected( actionIds);
                    window.location.reload();
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
        body.on('click', '.btn.create-app-token', function(){
            $.ajax({
                headers : {
                    'X-CSRF-Token' : "{{ csrf_token() }}"
                },
                success : function( data) {
                    $('#token').html( data.token)
                },
                error: function (a, b, c){
                    console.log( a)
                },
                data: {app: $('#app').val(), description: $('#app_description').val()},
                url : '/token/app/create',
                type : 'POST'
            });
        })
        body.on('click', '.btn.create-user-token', function(){
            $.ajax({
                headers : {
                    'X-CSRF-Token' : "{{ csrf_token() }}"
                },
                success : function( data) {
                    $('#token').html( data)
                },
                error: function (a, b, c){
                    console.log( a)
                },
                url : '/token/user/create',
                data: { description: $('#user_description').val()},
                type : 'POST'
            });
        })
        body.on('click', '.btn.get-app', function(){
            let token = $('#app\\.token').val();
            $.ajax({
                headers : {
                    'Authorization': 'Bearer ' + token
                },
                success : function( data) {
                    debugger;
                    $('#token-app-user').html( JSON.stringify( data))
                    //window.location.reload()
                },
                error: function (a, b, c){
                    console.log( a)
                },
                url : '/api/app/test',
                type : 'GET'
            });
        })
        body.on('click', '.btn.get-user', function(){
            let token = $('#user\\.token').val();
            $.ajax({
                headers : {
                    'Authorization': 'Bearer ' + token
                },
                success : function( data) {
                    debugger;
                    $('#token-app-user').html( JSON.stringify( data))
                    //window.location.reload()
                },
                error: function (a, b, c){
                    console.log( a)
                },
                url : '/api/user/test',
                type : 'GET'
            });
        })
    </script>
</x-app-layout>
