<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Yeni Sipariş</title>
</head>
<body>

<div class="container mt-5">
    <h2>Yeni Sipariş</h2>
    <button class="btn btn-primary" id="addRow">Yeni Satır</button>
    <button class="btn btn-success" id="saveData">Kaydet</button>
    <table class="table" id="dynamicTable">
        <thead>
            <tr>
                <th>Ürün Adı</th>
                <th>Adet</th>
                <th>Birim Fiyat</th>
                <th>Column 4</th>
                <th>Column 5</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <select class="form-control product-select">
                        <option value="">Seçin...</option>
                        <option value="1" data-price="100">Ürün 1</option>
                        <option value="2" data-price="200">Ürün 2</option>
                        <option value="3" data-price="300">Ürün 3</option>
                    </select>
                </td>
                <td>
                    <input type="number" class="form-control quantity" disabled>
                </td>
                <td>
                    <input type="text" class="form-control price" disabled>
                </td>
                <td>
                    <input type="text" class="form-control" disabled>
                </td>
                <td>
                    <input type="text" class="form-control" disabled>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function() {
        $('#addRow').click(function() {
            var newRow = `<tr>
                <td>
                    <select class="form-control product-select">
                        <option value="">Seçin...</option>
                        <option value="1" data-price="100">Ürün 1</option>
                        <option value="2" data-price="200">Ürün 2</option>
                        <option value="3" data-price="300">Ürün 3</option>
                    </select>
                </td>
                <td>
                    <input type="number" class="form-control quantity" disabled>
                </td>
                <td>
                    <input type="text" class="form-control price" disabled>
                </td>
                <td>
                    <input type="text" class="form-control" disabled>
                </td>
                <td>
                    <input type="text" class="form-control" disabled>
                </td>
            </tr>`;
            $('#dynamicTable tbody').append(newRow);
        });

        $(document).on('change', '.product-select', function() {
            var selectedOption = $(this).find('option:selected');
            var price = selectedOption.data('price');

            if (selectedOption.val() !== "") {
                $(this).closest('tr').find('.quantity').prop('disabled', false);
                $(this).closest('tr').find('.price').val(price).prop('disabled', false);
            } else {
                $(this).closest('tr').find('.quantity').val('').prop('disabled', true);
                $(this).closest('tr').find('.price').val('').prop('disabled', true);
            }
        });

        $('#saveData').click(function() {
            // Verileri kaydetme işlemi burada yapılacak
            alert("Veriler kaydedildi (şu anda sadece bir bildirim).");
        });
    });
</script>

</body>
</html>
