"use strict";

class MethodClassMapper {
    constructor() {
        this.map = {
            GET: 'success',
            POST: 'warning',
            PUT: 'warning',
            DELETE: 'danger',
        };
    }

    get(method) {
        return this.map[method];
    }
}

class ConsoleOutput {
    constructor() {
        this.$consoleOutput = $('#ConsoleOutput');
        this.$errorConsoleOutputContainer = $('#ErrorConsoleOutputContainer');
        this.$errorConsoleOutput = $('#ErrorConsoleOutput');
        this.clear();
    }

    clear() {
        this.$consoleOutput.html('');
        this.$errorConsoleOutputContainer.addClass('hidden');
    }

    render(response) {
        response = response === '' ? 'OK' : JSON.stringify(response, null, '\t');
        this.$consoleOutput.html(response);
    }

    error(jqXHR) {
        this.$errorConsoleOutputContainer.removeClass('hidden');
        this.$errorConsoleOutput.text('Request failed: ' + jqXHR.status + ' ' + jqXHR.statusText);
    }
}

class Application {
    constructor(consoleOutput, methodClassMapper) {
        this.apiUrl = $('#api-url').val() + '/';
        this.consoleOutput = consoleOutput;
        this.methodClassMapper = methodClassMapper;
        this.$apiMethods = $('#ApiMethods');
        this.$consoleInput = $('#ConsoleInput table');
        this.$sendRequestBtn = $('#SendRequestBtn');
        this.$inputs = $('#inputs');
        this.renderApiMethods();
    }

    renderApiMethods() {
        let app = this;
        $.get(app.getApiUrl())
            .done((data) => {
                $.each(data, function(resource, methods) {
                    app.$apiMethods.append('<a href="#" class="list-group-item disabled">' + resource.toUpperCase() + ' </a>');
                    $.each(methods, function(key, method) {
                        let item = $('<a href="#" class="list-group-item clickable"><span class="badge badge-' + app.methodClassMapper.get(method.method) + '">' + method.method + '</span>' + method.url + '</a>');
                        item.data(method).click(function() {
                            app.clickOnMethodHandler($(this).data())
                        });
                        app.$apiMethods.append(item);
                    });
                });
                app.$sendRequestBtn.click(function() {
                    app.sendRequestHandler($(this).data())
                });
            });
    }

    clickOnMethodHandler(method) {
        let app = this;
        app.$sendRequestBtn.removeClass('hidden');
        app.$consoleInput.html('');

        if (method.url.includes('{id}')) {
            let item = $('<tr class="info"><td><kbd>*</kbd> Resource ID</td><td><input type="text" id="ResourceID" class="form-control input-sm"></td></tr>');
            app.$consoleInput.append(item);
        }

        $.each(method.params, function(key, param) {
            let item = $('<tr><td>' + (param.required ? '<kbd>*</kbd> ' : '') + param.name + '</td><td><input type="' + param.type + '" name="' + param.name + '" class="form-control input-sm"></td></tr>');
            app.$consoleInput.append(item);
        });
        app.$sendRequestBtn.data(method);
    }

    sendRequestHandler(method) {
        let app = this;
        app.consoleOutput.clear();

        let url = method.url;
        if (method.url.includes('{id}')) {
            let resourceID = app.$inputs.find('#ResourceID').val();
            if (!resourceID) {
                alert('Resource ID is empty');
                return false;
            }
            url = method.url.replace('{id}', resourceID);
        }

        $.ajax({
            method: method.method,
            url: app.getApiUrl() + url,
            data: app.$inputs.find(':input').filter(function(index, element) {
                return $(element).val() !== '';
            }).serialize()
        })
            .done((data) => app.consoleOutput.render(data))
            .fail((jqXHR) => app.consoleOutput.error(jqXHR));
    }

    getApiUrl() {
        return this.apiUrl;
    }
}

new Application(new ConsoleOutput(), new MethodClassMapper());