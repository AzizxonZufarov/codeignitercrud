<!DOCTYPE html>
<html lang="en">

<head>
    <title>Таблица продуктов</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
</head>

<body>
    <div class="container"><br /><br />
        <div class="row">
            <div class="col-lg-10">
                <h2>Таблица продуктов</h2>
            </div>
            <div class="col-lg-2">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                    Add New Product
                </button>
            </div>
        </div>

        <table class="table table-bordered table-striped" id="productTable">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Name</th>
                    <th>Text</th>
                    <th>Price</th>
                    <th width="280px">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($products_detail as $row) {
                ?>
                    <tr id="<?php echo $row['id']; ?>">
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['text']; ?></td>
                        <td><?php echo $row['price']; ?></td>
                        <td>
                            <a data-id="<?php echo $row['id']; ?>" class="btn btn-primary btnEdit">Edit</a>
                            <a data-id="<?php echo $row['id']; ?>" class="btn btn-danger btnDelete">Delete</a>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModalLabel">Add New Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="addProduct" name="addProduct" action="<?php echo site_url('product/store'); ?>" method="post">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="txtName">Name:</label>
                                <input type="text" class="form-control" id="txtName" placeholder="Enter Name" name="txtName">
                            </div>
                            <div class="form-group">
                                <label for="txtText">Text:</label>
                                <input type="text" class="form-control" id="txtText" placeholder="Enter Text" name="txtText">
                            </div>
                            <div class="form-group">
                                <label for="txtPrice">Price:</label>
                                <textarea class="form-control" id="txtPrice" name="txtPrice" rows="10" placeholder="Enter Price"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModalLabel">Update Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="updateProduct" name="updateProduct" action="<?php echo site_url('product/update'); ?>" method="post">
                        <div class="modal-body">
                            <input type="hidden" name="hdnProductId" id="hdnProductId" />
                            <div class="form-group">
                                <label for="txtName">Name:</label>
                                <input type="text" class="form-control" id="txtName" placeholder="Enter Name" name="txtName">
                            </div>
                            <div class="form-group">
                                <label for="txtText">Text:</label>
                                <input type="text" class="form-control" id="txtText" placeholder="Enter Text" name="txtText">
                            </div>
                            <div class="form-group">
                                <label for="txtPrice">Price:</label>
                                <input class="form-control" id="txtPrice" name="txtPrice" rows="10" placeholder="Enter Price" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <script>
        $(document).ready(function() {
            $('#productTable').DataTable();

            $("#addProduct").validate({
                rules: {
                    txtName: "required",
                    txtText: "required",
                    txtPrice: "required"
                },
                messages: {},

                submitHandler: function(form) {
                    var form_action = $("#addProduct").attr("action");
                    $.ajax({
                        data: $('#addProduct').serialize(),
                        url: form_action,
                        type: "POST",
                        dataType: 'json',
                        success: function(res) {
                            var product = '<tr id="' + res.data.id + '">';
                            product += '<td>' + res.data.id + '</td>';
                            product += '<td>' + res.data.name + '</td>';
                            product += '<td>' + res.data.text + '</td>';
                            product += '<td>' + res.data.price + '</td>';
                            product += '<td><a data-id="' + res.data.id + '" class="btn btn-primary btnEdit">Edit</a>  <a data-id="' + res.data.id + '" class="btn btn-danger btnDelete">Delete</a></td>';
                            product += '</tr>';
                            $('#productTable tbody').prepend(product);
                            $('#addProduct')[0].reset();
                            $('#addModal').modal('hide');
                        },
                        error: function(data) {}
                    });
                }
            });

            $('body').on('click', '.btnEdit', function() {
                var product_id = $(this).attr('data-id');
                $.ajax({
                    url: 'product/edit/' + product_id,
                    type: "GET",
                    dataType: 'json',
                    success: function(res) {
                        $('#updateModal').modal('show');
                        $('#updateProduct #hdnProductId').val(res.data.id);
                        $('#updateProduct #txtName').val(res.data.name);
                        $('#updateProduct #txtText').val(res.data.text);
                        $('#updateProduct #txtPrice').val(res.data.price);
                    },
                    error: function(data) {}
                });
            });

            $("#updateProduct").validate({
                rules: {
                    txtName: "required",
                    txtText: "required",
                    txtPrice: "required"
                },
                messages: {},
                submitHandler: function(form) {
                    var form_action = $("#updateProduct").attr("action");
                    $.ajax({
                        data: $('#updateProduct').serialize(),
                        url: form_action,
                        type: "POST",
                        dataType: 'json',
                        success: function(res) {
                            var product = '<td>' + res.data.id + '</td>';
                            product += '<td>' + res.data.name + '</td>';
                            product += '<td>' + res.data.text + '</td>';
                            product += '<td>' + res.data.price + '</td>';
                            product += '<td><a data-id="' + res.data.id + '" class="btn btn-primary btnEdit">Edit</a>  <a data-id="' + res.data.id + '" class="btn btn-danger btnDelete">Delete</a></td>';
                            $('#productTable tbody #' + res.data.id).html(product);
                            $('#updateProduct')[0].reset();
                            $('#updateModal').modal('hide');
                        },
                        error: function(data) {}
                    });
                }
            });

            $('body').on('click', '.btnDelete', function() {
                var product_id = $(this).attr('data-id');
                $.get('product/delete/' + product_id, function(data) {
                    $('#productTable tbody #' + product_id).remove();
                })
            });
        });
    </script>
</body>

</html>