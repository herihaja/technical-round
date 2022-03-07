<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>

<body>


    <h4>Welcome to the dashboard</h4>

    <table id="articles-list">
        <thead>
            <tr>
                <td>Price list Id</td>
                <td>Price list name</td>
                <td>Number</td>
                <td>Short name</td>
                <td>Long name</td>
                <td>Exists</td>
            </tr>
        </thead>
        <tbody>
            <?php if ($articles) : ?>
                <?php foreach ($articles as $article) : ?>
                    <tr>
                        <td><?php echo $article['salePriceListId']; ?></td>
                        <td><?php echo $article['priceListName']; ?></td>
                        <td><?php echo $article['saleArticleNumber']; ?></td>
                        <td><?php echo $article['saleArticleShortName']; ?></td>
                        <td><?php echo $article['saleArticleLongName']; ?></td>
                        <td><?php echo $article['saleArticleExists']; ?></td>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>
        </tbody>
    </table>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>


    <script>
        $(document).ready(function() {
            $('#articles-list').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'excel'
                ]
            });
        });
    </script>
</body>

</html>