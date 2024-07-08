@extends('layouts.app')

@section('content')
<div id="order-content">
    <h1 class="centered-header">User Management Dashboard</h1>
    <div id="message"></div>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col col-sm-9">Manage Users</div>
                    <div class="col col-sm-3">
                        <button type="button" id="export_excel" class="btn btn-info btn-sm float-end me-2">Export to Excel</button>
                        <button type="button" id="add_data" class="btn btn-success btn-sm float-end">Add</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="sample_data">
                        <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Contact</th>
                                <th>Address</th>
                                <th>Active Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Add/Edit -->
<div class="modal" tabindex="-1" id="action_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" id="sample_form">
                <div class="modal-header">
                    <h5 class="modal-title" id="dynamic_modal_title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">First Name</label>
                        <input type="text" name="first_name" id="first_name" class="form-control" />
                        <span id="first_name_error" class="text-danger"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Last Name</label>
                        <input type="text" name="last_name" id="last_name" class="form-control" />
                        <span id="last_name_error" class="text-danger"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" />
                        <span id="email_error" class="text-danger"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contact</label>
                        <input type="text" name="contact" id="contact" class="form-control" />
                        <span id="contact_error" class="text-danger"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <input type="text" name="address" id="address" class="form-control" />
                        <span id="address_error" class="text-danger"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Active Status</label>
                        <select name="active_status" id="active_status" class="form-control">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                        <span id="active_status_error" class="text-danger"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id" id="id" />
                    <input type="hidden" name="action" id="action" value="Add" />
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="action_button">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    function load_data() {
        $.getJSON("{{ route('admin.fetchUsers') }}", function(data) {
            var data_arr = [];

            for (var count = 0; count < data.length; count++) {
                var sub_array = {
                    'first_name': data[count].first_name,
                    'last_name': data[count].last_name,
                    'email': data[count].email,
                    'contact': data[count].contact,
                    'address': data[count].address,
                    'active_status': data[count].active_status ? 'Active' : 'Inactive',
                    'action': '<button type="button" class="btn btn-warning btn-sm edit" data-id="' + data[count].id + '">Edit</button>&nbsp;<button type="button" class="btn btn-danger btn-sm delete" data-id="' + data[count].id + '">Delete</button>'
                };

                data_arr.push(sub_array);
            }

            $('#sample_data').DataTable({
                data: data_arr,
                order: [],
                columns: [
                    { data: "first_name" },
                    { data: "last_name" },
                    { data: "email" },
                    { data: "contact" },
                    { data: "address" },
                    { data: "active_status" },
                    { data: "action" }
                ]
            });
        }).fail(function(jqxhr, textStatus, error) {
            var err = textStatus + ", " + error;
            console.error("Request Failed: " + err);
            $('#message').html('<div class="alert alert-danger">Error loading data</div>');
        });
    }

    load_data();

    $('#add_data').click(function() {
        $('#dynamic_modal_title').text('Add User');
        $('#sample_form')[0].reset();
        $('#action').val('Add');
        $('#action_button').text('Add');
        $('.text-danger').text('');
        $('#action_modal').modal('show');
    });

    $('#sample_form').on('submit', function(event) {
        event.preventDefault();

        $.ajax({
            url: "{{ route('admin.saveUser') }}",
            method: "POST",
            data: $(this).serialize(),
            dataType: "JSON",
            beforeSend: function() {
                $('#action_button').attr('disabled', 'disabled');
            },
            success: function(data) {
                $('#action_button').attr('disabled', false);
                if (data.error) {
                    $('#first_name_error').text(data.error.first_name_error || '');
                    $('#last_name_error').text(data.error.last_name_error || '');
                    $('#email_error').text(data.error.email_error || '');
                    $('#contact_error').text(data.error.contact_error || '');
                    $('#address_error').text(data.error.address_error || '');
                    $('#active_status_error').text(data.error.active_status_error || '');
                } else {
                    $('#message').html('<div class="alert alert-success">' + data.success + '</div>');
                    $('#action_modal').modal('hide');
                    $('#sample_data').DataTable().destroy();
                    load_data();
                    setTimeout(function() {
                        $('#message').html('');
                    }, 5000);
                }
            }
        });
    });

    $(document).on('click', '.edit', function() {
        var id = $(this).data('id');
        $('#dynamic_modal_title').text('Edit User');
        $('#action').val('Edit');
        $('#action_button').text('Edit');
        $('.text-danger').text('');
        $('#action_modal').modal('show');

        $.ajax({
            url: "{{ route('admin.fetchSingleUser', '') }}/" + id,
            method: "GET",
            dataType: "JSON",
            success: function(data) {
                $('#first_name').val(data.first_name);
                $('#last_name').val(data.last_name);
                $('#email').val(data.email);
                $('#contact').val(data.contact);
                $('#address').val(data.address);
                $('#active_status').val(data.active_status ? 'active' : 'inactive');
                $('#id').val(data.id);
            },
            error: function(xhr, textStatus, errorThrown) {
                console.error("Error fetching single user:", errorThrown);
            }
        });
    });

    $(document).on('click', '.delete', function() {
        var id = $(this).data('id');

        if (confirm("Are you sure you want to delete this user?")) {
            $.ajax({
                url: "{{ route('admin.deleteUser', '') }}/" + id,
                method: "DELETE",
                data: { _token: "{{ csrf_token() }}" },
                dataType: "JSON",
                success: function(data) {
                    $('#message').html('<div class="alert alert-success">' + data.success + '</div>');
                    $('#sample_data').DataTable().destroy();
                    load_data();
                    setTimeout(function() {
                        $('#message').html('');
                    }, 5000);
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.error("Error deleting user:", errorThrown);
                }
            });
        }
    });

    $('#export_excel').click(function() {
        window.location.href = "{{ route('admin.exportUsersToExcel') }}";
    });
});
</script>
@endpush
