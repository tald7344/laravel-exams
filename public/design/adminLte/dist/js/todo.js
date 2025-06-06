var todo = (function ($, params) {
    'use strict';

    function getToDoList() {
        // Fetch Latest to do
        fetch(params.listToDoUrl)
            .then(res => res.json())
            .then(response => {
                let toDoElement = document.getElementById('todo_list');
                if (!response.error) {
                    let resultHtml = '';
                    for (let item of response.data) {
                        resultHtml += generateHtml(item);
                    }
                    toDoElement.innerHTML = resultHtml;
                } else {
                    toDoElement.innerHTML = response.data;
                }
            });
    }

    function getPaginateList(event, name) {
        let itemsNumber = 5;
        let offset = +event.target.dataset.offset;
        let page = +$('#page_number').attr('data-page');
        $.ajax({
            url: params.paginateListToDoUrl,
            type: 'POST',
            data: {
                _token: params.token,
                type: name,
                page,
                offset,
                limit: itemsNumber
            },
            success: function (response) {
                console.log(response);
                if (name == 'next') {
                    if (response.isLast) {
                        $('#next').css({'opacity': '.7', 'pointers-events': 'none'});
                    } else {
                        $('#next').css({'opacity': '1', 'pointers-events': 'auto'});
                        $('#page_number').attr('data-page', response.page).text(response.page);
                        $('#next').attr('data-offset', response.offset);
                        $('#prev').attr('data-offset', response.offset - (itemsNumber * 2));
                        let resultHtml = '';
                        for (let item of response.data) {
                            resultHtml += generateHtml(item);
                        }
                        $('#todo_list').html(resultHtml);
                    }
                } else {
                    $('#prev').css({'opacity': '1', 'pointers-events': 'auto'});
                    $('#page_number').attr('data-page', response.page).text(response.page);
                    $('#next').attr('data-offset', response.offset + itemsNumber);
                    if (response.offset == 0) {
                        $('#prev').attr('data-offset', response.offset);
                    } else {
                        $('#prev').attr('data-offset', response.offset - itemsNumber);
                    }
                    let resultHtml = '';
                    for (let item of response.data) {
                        resultHtml += generateHtml(item);
                    }
                    $('#todo_list').html(resultHtml);
                }

            }
        });
    }

    function showToDoItemDetails(e) {
        let id = e.target.dataset.id;
        let model = $('#showToDoListItemModal');
        model.find('.modal-body').html('');
        model.find('.modal-footer').addClass('d-none');
        $.ajax({
            url: params.showToDoItemUrl,
            type: 'GET',
            data: { _token: params.token, id },
            success: function (response) {
                if (response.error) {
                    toastr.error(response.result, 'ToDo');
                } else {
                    model.find('.modal-body').html(response.result);
                    model.find('.modal-footer').addClass('d-none');
                }
            }
        });
    }

    // Add New To Do Item
    function addNewToDoItem() {
        let form = document.getElementById('create_todo_item_form');
        let formData = new FormData(form);
        $.ajax({
            url: params.addOrEditToDoUrl,
            type: 'POST',
            contentType: false,
            processData: false,
            data: formData,
            beforeSend: function () {
                $('#new_todo_item').css({'pointer-events': 'none', 'opacity': .7});
            },
            error: function () {
                $('#new_todo_item').css({'pointer-events': 'auto', 'opacity': 1});
            },
            success: function (response) {
                $('#new_todo_item').css({'pointer-events': 'auto', 'opacity': 1});
                if (response.error) {
                    $('#create_todo_item_form').find('.todo-error-messages').removeClass('d-none').html(response.result);
                    setTimeout(() => {
                        $('#create_todo_item_form').find('.todo-error-messages').addClass('d-none').html('');
                    }, 5000);
                } else {
                    getToDoList();
                    $('#newToDoListItemModal').find('.close_button').click();
                    $('#create_todo_item_form')[0].reset();
                    toastr.success(response.result, 'ToDo');
                }
            }
        });
    }

    function renderToDoItemDetails(e) {
        let itemId = e.target.dataset.id;
        $.ajax({
            url: params.renderToDoItemDetailsUrl,
            type: 'POST',
            data: {
                _token: params.token,
                id: itemId
            },
            success: function(response) {
                if (!response.error) {
                    $('#editToDoListItemModal').find('.modal-body').html(response.result);
                }
            }
        });
    }

    function editToDoItemDetails() {
        let form = $('#edit_todo_item_form');
        let formData = new FormData(form[0]);
        const formDataObj = {};
        formData.forEach((value, key) => (formDataObj[key] = value));
        $.ajax({
            url: params.addOrEditToDoUrl,
            type: 'PATCH',
            data: formDataObj,
            beforeSend: function () {
                $('#edit_todo_item').css({'pointer-events': 'none', 'opacity': .7});
            },
            error: function (response) {
                $('#edit_todo_item').css({'pointer-events': 'auto', 'opacity': 1});
            },
            success: function (response) {
                $('#edit_todo_item').css({'pointer-events': 'auto', 'opacity': 1});
                if (response.error) {
                    form.find('.todo-error-messages').removeClass('d-none').html(response.result);
                    setTimeout(() => {
                        form.find('.todo-error-messages').addClass('d-none').html('');
                    }, 5000);
                } else {
                    getToDoList();
                    $('#editToDoListItemModal').find('.close_button').click();
                    form[0].reset();
                    toastr.success(response.result, 'ToDo');
                }
            }
        });
    }

    function checkToDoItem(e) {
        let value = e.target.value;
        let id = e.target.dataset.id;
        $.ajax({
            url: params.checkToDoUrl,
            type: 'PATCH',
            data: { _token: params.token, value, id },
            success: function (response) {
                if (!response.error) {
                    let element = $('#' + e.target.getAttribute('id'));
                    if (response.result == 1) {
                        element.closest('li').addClass('done');
                        element.attr('checked');
                    } else {
                        element.closest('li').removeClass('done');
                        element.removeAttr('checked');
                    }
                    e.target.value = response.result;     // change input checkbox value
                    toastr.success(response.message, 'ToDo');
                } else {
                    toastr.error(response.message, 'ToDo');
                }
            }
        });
    }

    function deleteToDoItem(e) {
        if (!confirm(params.deleteMessageAlert)) return false;
        let id = e.target.dataset.id;
        $.ajax({
            url: params.deleteToDoUrl,
            type: 'DELETE',
            data: { _token: params.token, id },
            success: function (response) {
                if (!response.error) {
                    getToDoList();
                    toastr.success(response.message, 'ToDo');
                } else {
                    toastr.error(response.message, 'ToDo');
                }
            }
        });
    }

    function generateHtml(response) {
        let lang = params.lang;
        let randomColor = '#' + Math.floor(Math.random() * 16777215).toString(16);
        return `<li class="${response['isDone'] == 1 ? "done" : ''}">
            <span class="handle">
              <i class="fas fa-ellipsis-v"></i>
              <i class="fas fa-ellipsis-v"></i>
            </span>
            <div class="icheck-primary d-inline ml-2">
              <input type="checkbox" name="todo_${response['id']}" value="${response['isDone'] == 1 ? 1 : 0}" id="todoCheck_${response['id']}" data-id="${response['id']}" ${response['isDone'] == 1 ? 'checked' : ''}>
              <label for="todoCheck_${response['id']}"></label>
            </div>
            <span class="todo-title text" id="show_details" data-toggle="modal" data-target="#showToDoListItemModal" data-id="${response['id']}" style="cursor: pointer;">${response['content_' + lang].substring(0, 20) + '...'}</span>
            <small class="badge badge-danger" style="background-color: ${randomColor}"><i class="far fa-clock fa-fw"></i> ${response['deadline']}</small>
            <div class="tools">
              <i class="fas fa-edit text-success" id="renderToDoItemDetails" data-toggle="modal" data-target="#editToDoListItemModal" data-id="${response['id']}"></i>
              <i class="fas fa-trash" id="deleteToDoItem" data-id="${response['id']}"></i>
            </div>
          </li>`;
    }

    return {
        getList: function () {
            getToDoList();
        },
        getPaginate: function () {
            $('#prev').click((event) => getPaginateList(event, 'prev'));
            $('#next').click((event) => getPaginateList(event, 'next'));
        },
        showDetails: function () {
            $('#todo_list').on('click', '#show_details', function (e) {
                console.log('click to show');
                showToDoItemDetails(e);
            });
        },
        addItem: function () {
            $('#new_todo_item').on('click', function (e) {
                e.preventDefault();
                addNewToDoItem();
            })
        },
        renderItemDetail: function () {
            $('#todo_list').on('click', '#renderToDoItemDetails', function (e) {
                renderToDoItemDetails(e);
            });
        },
        editItem: function () {
            $('#edit_todo_item').on('click', function (e) {
                e.preventDefault();
                editToDoItemDetails();
            })
        },
        checkItem: function () {
            $('#todo_list').on('change', 'input[type="checkbox"]', function (e) {
                checkToDoItem(e);
            })
        },
        deleteItem: function () {
            $('#todo_list').on('click', '#deleteToDoItem', function (e) {
                deleteToDoItem(e);
            })
        }
    }
})(window.jQuery, _todoParams);
