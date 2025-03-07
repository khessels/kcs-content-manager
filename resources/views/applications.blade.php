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
                        <div class="col6">
                            @c(['key' => 'App']):
                            <select id="app" name="app">
                                <option value="">@c(['key' => 'select'])</option>
                                @foreach( $apps as $app)
                                    <option {{ ! empty( $filters['app']) ? (strtolower( $app->name) == strtolower( $filters['app']) ? 'selected' : '') : ''}} value="{{ $app->name }}">{{ $app->name }}</option>
                                @endforeach
                            </select>
                            <button class="btn btn-primary create-token">@c(['key' => 'Create'])</button>
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
                    <form>
                        <div class="row">
                            <div class="col6">
                                <label>@c(['key' => 'token', 'default'=> 'Token'])</label>
                                <span id="token"></span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        let body = $('body');
        body.on('click', '.btn.create-token', function(){
            $.ajax({
                headers : {
                    'X-CSRF-Token' : "{{ csrf_token() }}"
                },
                success : function( data) {
                    debugger;
                    $('#token').html( data.token)
                    //window.location.reload()
                },
                error: function (a, b, c){
                    console.log( a)
                },
                data: {app: $('#app').val()},
                url : '/token/create',
                type : 'POST'
            });
        })
    </script>
</x-app-layout>
