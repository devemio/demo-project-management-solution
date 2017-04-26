let API_URL = $('#api-url').val() + '/';

$.get(API_URL)
    .done(function(data) {
        console.log(data);

        let $apiMethods = $('#ApiMethods');
        let $consoleInput = $('#ConsoleInput table');
        let $sendRequestBtn = $('#SendRequestBtn')
        let $consoleOutput = $('#ConsoleOutput');
        let $errorConsoleOutputContainer = $('#ErrorConsoleOutputContainer');
        let $errorConsoleOutput = $('#ErrorConsoleOutput');
        let $inputs = $('#inputs');

        $.each(data, function(resource, methods) {
            $apiMethods.append('<a href="#" class="list-group-item disabled">' + resource.toUpperCase() + ' </a>');
            $.each(methods, function(key, method) {
                let item = $('<a href="#" class="list-group-item clickable"><span class="badge">' + method.method + '</span>' + method.url + '</a>');
                item.data(method);
                $apiMethods.append(item);
            });
        });

        $apiMethods.find('.clickable').click(function() {
            let method = $(this).data();
            $sendRequestBtn.removeClass('hidden');

            $consoleInput.html('');

            if (method.url.includes('{id}')) {
                let item = $('<tr><td><kbd>*</kbd> Resource ID</td><td><input type="text" id="ResourceID" class="form-control input-sm"></td></tr>');
                $consoleInput.append(item);
            }

            $.each(method.params, function(key, param) {
                let item = $('<tr><td>' + (param.required ? '<kbd>*</kbd> ' : '') + param.name + '</td><td><input type="text" name="' + param.name + '" class="form-control input-sm"></td></tr>');
                $consoleInput.append(item);
            });
            $sendRequestBtn.data(method);
        });

        $sendRequestBtn.click(function() {
            let method = $(this).data();

            $consoleOutput.html('');
            $errorConsoleOutputContainer.addClass('hidden');
            console.log(method);

            let url = method.url.includes('{id}') ? method.url.replace('{id}', $inputs.find('#ResourceID').val()) : method.url;

            $.ajax({
                method: method.method,
                url: API_URL + url || method.url,
                data: $inputs.find(':input').filter(function(index, element) {
                    return $(element).val() !== '';
                }).serialize()
            })
                .done(function(data) {
                    $consoleOutput.html(JSON.stringify(data, null, '\t'));
                })
                .fail(function(jqXHR) {
                    $errorConsoleOutputContainer.removeClass('hidden');
                    $errorConsoleOutput.text('Request failed: ' + jqXHR.status + ' ' + jqXHR.statusText);
                });
        });
    });